<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use EDI\Encoder;
use EDI\Generator\Codeco;
use EDI\Generator\Interchange;
use EDI\Generator\Codeco\Container;
class EDIController extends Controller
{
    public function index(){
        $shipping = DB::table('line_masters')->get();
        $status_master = DB::table('status_masters')->get();
        $data = [];
        $start_date = '';
        $end_date = '';
        return view('edi',compact('shipping','status_master','data','start_date','end_date'));
    }
    public function edi_fetch(Request $request){
        $shipping = DB::table('line_masters')->get();
        $status_master = DB::table('status_masters')->get();
        $start_date = $request->post('start_date');
        $end_date = $request->post('end_date');
        $shipping_line = $request->post('shipping');
        $activity = '';
        if ($request->post('check_table') == 'in_containers') {
            $data = DB::table($request->post('check_table'))
                    ->whereDate('in_date','>=',$start_date)
                    ->whereDate('in_date','<=',$end_date)
                    ->where('shipping_line',$shipping_line)
                    ->get();
            $activity = 'IN CONTAINER';
        }else{
            $data = DB::table($request->post('check_table'))
                    ->join('in_containers', 'in_containers.id', '=', 'out_containers.in_container_id')
                    ->whereDate('out_containers.out_date','>=',$start_date)
                    ->whereDate('out_containers.out_date','<=',$end_date)
                    ->where('in_containers.shipping_line',$shipping_line)
                    ->get(['out_containers.*', 'in_containers.*']);
            $activity = 'OUT CONTAINER';
        }
        return view('edi',compact('shipping','activity','status_master','data','start_date','end_date'));
    }
    // edi report in codeco format
    public function edi_report(Request $request){
        // $arr = []; //array
        // $arr['sa0'] = array('asfsd','ds','sf');
        // $arr['s12'] = array('asf','ds');
        // $p = new Encoder($arr, true); //one segment per line
        // echo $p->get();
        $result = [];
        $file_url = "edi_report.edi";
        file_put_contents($file_url,"\n==========This is the edi codeco formart.=========\n\n");

        $postData = $request->postData;
        foreach ($postData['content'] as $key => $value) {
            # code...
            $oInterchange = new Interchange('JMJMUN', 'BWL');

            $oCodeco = (new Codeco())
                ->setSenderAndReceiver('JMJMUN',"BWL");
            $oContainer = (new Container())
                ->setContainer($value['container'], '2210', $value['status'], 5)
                ->setBooking('21INMUN22020287A')
                ->setEffectiveDate($postData['end_date'])
                // ->setSeal($value['port'], 'CA')
                ->setModeOfTransport($value['transporter'], 31)
                ->setWeight('JMJMUN', "ZZZ")
                ->setLocation($value['location'])
            ;
    
            $oCodeco = $oCodeco->addContainer($oContainer);
            $oCodeco = $oCodeco->compose(5, 34);
            $aComposed = $oInterchange->addMessage($oCodeco)->getComposed();
            file_put_contents($file_url, (new Encoder($aComposed, false))->get()."\n", FILE_APPEND);
                
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');  
        header("Content-Transfer-Encoding: utf-8");   
        header("Content-disposition: attachment; filename=\"" .$file_url. "\"");   
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_url));
        // flush(); // Flush system output buffer
        readfile($file_url); 
        // unlink($file_url);
        $result['filename'] = $file_url;
        $result['success'] = true;
        echo json_encode($result);
   
    }
}
