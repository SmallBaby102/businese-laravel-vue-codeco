<?php

namespace App\Http\Controllers;
use App\Imports\ial_upload_import;
use App\Models\ial_upload;
use App\Models\LineMaster;
use Illuminate\Http\Request;
class IalUploadController extends Controller
{
    public function index()
    {
        $shipper = LineMaster::latest()->get();
        $list = ial_upload::all();
        return view('ial-upload',compact('shipper','list'));
    }

    public function store(Request $request)
    {
        $ial = (new ial_upload_import)->toArray($request->file('file'));
        $container = [];
        $size = [];
        $type = [];
        $old_size = [];
        $old_type = [];
        $data = [];
        $row = 0;
        for ($i=0; $i <count($ial[0]) ; $i++) { 
            if ($ial[0][$i]['container_no'] !== null) {
                $new_size = $ial[0][$i]['size'];
                $new_type = $ial[0][$i]['type'];
                if (in_array($new_size,$old_size)) {
                    if (in_array($new_type,$old_type)) {
                        $push_arr = $ial[0][$i]['container_no'];
                        $data[$ial[0][$i]['size']][$ial[0][$i]['type']][] = $push_arr;
                        
                    } else {
                        $old_type[] = $new_type;
                        $push_arr = array($ial[0][$i]['type'] =>
                                        array(
                                            $ial[0][$i]['container_no']
                                        ));
                        $data[$ial[0][$i]['size']] += $push_arr;
                    }
                }else{
                    $old_size[] = $new_size;
                    $old_type[] = $new_type;
                    $data += array($ial[0][$i]['size'] => 
                                array($ial[0][$i]['type'] =>
                                    array(
                                        $ial[0][$i]['container_no']
                                    )  
                                )
                            );
                }
            }
        }
        foreach ($data as $key => $value) {
            foreach ($value as $k => $v) {
                $model = new ial_upload;
                $model->container_no = json_encode($v);
                $model->total_container = json_encode($v);
                $model->size = $key;
                $model->type = $k;
                $model->import_do = $request->post('import_do');
                $model->vessel = $request->post('vessel');
                $model->shipper = $request->post('shipper');
                $model->voyage = $request->post('voyage');
                $model->port = $request->post('port');
                $model->reached = json_encode([]);
                $model->save();
            }
        }
        return back()->with('success','IAL File Uploaded Successfully');
    }
    public function ial_report(){
        return view('ial_report');
    }
    public function get_ial_data(Request $req){
        $model = ial_upload::find($req->id);
        return $model;
    }
    
}
