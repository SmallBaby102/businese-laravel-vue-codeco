<?php

namespace App\Http\Controllers;
use EDI\Parser;
use EDI\Analyser;
use App\Imports\EstimateDataReport;
use App\Imports\ExcelUpdate;
use Illuminate\Http\Request;
use App\Models\InContainer;
use App\Models\LineMaster;
use App\Models\ContainerType;
use App\Models\Inventory;
use App\Models\CompanyDetail;
use App\Models\OutContainer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Excel;
use App\Exports\MultiSheetExport;

class InventoryController extends Controller
{
    private $excel;
    public function __construct(Excel $excel)
    {
        $this->middleware('auth');
        $this->excel = $excel;
    }
    public function index()
    {
        date_default_timezone_set('Asia/Kolkata');
        $shipping = DB::table('line_masters')->get();
        $data = [];
        $selected_date = '';
        return view('inventory_report',compact('shipping','data','selected_date'));  
    }
    public function inventory_report_fetch(Request $request){
        $selected_date = $request->post('date');
        $shipping = $request->post('shipping');
        $data = [];
        if ($selected_date <= Carbon::now()) {
            if($shipping !== 'all'){
                $data =  DB::select("SELECT * FROM in_containers AS A WHERE date(A.created_at) <= '".$selected_date."' AND A.shipping_line = '".$shipping."' AND A.id NOT IN (SELECT in_container_id FROM out_containers WHERE created_at <= '".$selected_date." 23:59:59' )");
            }else{
                $data =  DB::select("SELECT * FROM in_containers AS A WHERE date(A.created_at) <= '".$selected_date."' AND A.id NOT IN (SELECT in_container_id FROM out_containers WHERE created_at <= '".$selected_date." 23:59:59' )");
            }
        }
        date_default_timezone_set('Asia/Kolkata');
        $shipping = DB::table('line_masters')->get();
        return view('inventory_report',compact('shipping','data','selected_date'));  
    }


    public function container_register(){
        $shipping = DB::table('line_masters')->get();
        $status_master = DB::table('status_masters')->get();
        $data = [];
        $start_date = '';
        $end_date = '';
        return view('container_register',compact('shipping','status_master','data','start_date','end_date'));
    }
    public function container_register_fetch(Request $request){
        $lines = $request->post('shipping');
        $status = $request->post('status');
        $check_table = $request->post('check_table');
        $start_date = $request->post('start_date');
        $end_date = $request->post('end_date');
        $data = [];
        if ($start_date != null && $end_date != null) {
            if ($check_table == 1) {
                if ($lines !== 'all' && $status !== 'all') {
                    $data = InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$start_date)
                    ->whereDate('in_containers.created_at','<=',$end_date)
                    ->where('in_containers.shipping_line',$lines)
                    ->where('in_containers.status',$status)
                    ->get();
                }
                if ($lines == 'all' && $status !== 'all') {
                    $data = InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$start_date)
                    ->whereDate('in_containers.created_at','<=',$end_date)
                    ->where('in_containers.status',$status)
                    ->get();
                }
                if ($lines !== 'all' && $status == 'all') {
                    $data = InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$start_date)
                    ->whereDate('in_containers.created_at','<=',$end_date)
                    ->where('in_containers.shipping_line',$lines)
                    ->get();
                }
                if ($lines == 'all' && $status == 'all') {
                    $data = InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$start_date)
                    ->whereDate('in_containers.created_at','<=',$end_date)
                    ->get();
                }
            }elseif ($check_table == 2) {
                if ($lines !== 'all' && $status !== 'all') {
                    $data = OutContainer::select('out_containers.*','in_containers.*')
                    ->leftJoin("in_containers", "in_containers.id", "=", "out_containers.in_container_id")
                    ->whereDate('out_containers.created_at','>=',$start_date)
                    ->whereDate('out_containers.created_at','<=',$end_date)
                    ->where('in_containers.status',$status)
                    ->where('in_containers.shipping_line',$lines)
                    ->get();
                }
                if ($lines == 'all' && $status !== 'all') {
                    $data = OutContainer::select('out_containers.*','in_containers.*')
                    ->leftJoin("in_containers", "in_containers.id", "=", "out_containers.in_container_id")
                    ->whereDate('out_containers.created_at','>=',$start_date)
                    ->whereDate('out_containers.created_at','<=',$end_date)
                    ->where('in_containers.status',$status)
                    ->get();
                    
                }
                if ($lines !== 'all' && $status == 'all') {
                    $data = OutContainer::select('out_containers.*','in_containers.*')
                    ->leftJoin("in_containers", "in_containers.id", "=", "out_containers.in_container_id")
                    ->whereDate('out_containers.created_at','>=',$start_date)
                    ->whereDate('out_containers.created_at','<=',$end_date)
                    ->where('in_containers.shipping_line',$lines)
                    ->get();
                }
                if ($lines == 'all' && $status == 'all') {
                    $data = OutContainer::select('out_containers.*','in_containers.*')
                    ->leftJoin("in_containers", "in_containers.id", "=", "out_containers.in_container_id")
                    ->whereDate('out_containers.created_at','>=',$start_date)
                    ->whereDate('out_containers.created_at','<=',$end_date)
                    ->get();
                }
            }elseif ($check_table == 4) {
                if ($lines !== 'all' && $status !== 'all') {
                    $data = InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$start_date)
                    ->whereDate('in_containers.created_at','<=',$end_date)
                    ->where('in_containers.shipping_line',$lines)
                    ->where('in_containers.status',$status)
                    ->where('in_containers.av_date','!=',null)
                    ->get();
                }
                if ($lines == 'all' && $status !== 'all') {
                    $data = InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$start_date)
                    ->whereDate('in_containers.created_at','<=',$end_date)
                    ->where('in_containers.status',$status)
                    ->where('in_containers.av_date','!=',null)
                    ->get();
                }
                if ($lines !== 'all' && $status == 'all') {
                    $data = InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$start_date)
                    ->whereDate('in_containers.created_at','<=',$end_date)
                    ->where('in_containers.shipping_line',$lines)
                    ->where('in_containers.av_date','!=',null)
                    ->get();
                }
                if ($lines == 'all' && $status == 'all') {
                    $data = InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$start_date)
                    ->whereDate('in_containers.created_at','<=',$end_date)
                    ->where('in_containers.av_date','!=',null)
                    ->get();
                }
            }
        }
        $shipping = DB::table('line_masters')->get();
        $status_master = DB::table('status_masters')->get();
        return view('container_register',compact('shipping','status_master','data','start_date','end_date'));
    }
    
    public function depot_stock_report()
    {
        $shipping = LineMaster::all();
        $container_type = ContainerType::all();
        $company =  CompanyDetail::find(1);
        $data = [];
        $client = [];
        $select_date = '';
        return view('depot_stock_report',compact('company','shipping','container_type','data','client','select_date'));
    }

    public function store_tues_value(Request $request){
        $model =  CompanyDetail::find(1);
        $model->total_tues = $request->post('tues');
        $model->save();
        return 'Tues Updated Successfully';
    }

    public function depot_stock_report_fetch(Request $request)
    {
        $shipping = LineMaster::all();
        $container_type = ContainerType::all();
        $company =  CompanyDetail::find(1);
        $data = [];
        $client = [];
        $select_date = $request->post('select_date');
        $data = InContainer::whereDate('created_at','=', $request->post('select_date'))->get();
            $all_data = [];
            $new_size = [];
            $new_type = [];
            $client = [];
            $size = [];
            $type = [];
            foreach ($container_type as $c_detail) {
                $size[] = $c_detail->size;                
                $type[] = $c_detail->type;
            }
            foreach ($shipping as $ship) {
                foreach ($data as $con){
                    if ($ship->client_name == $con->shipping_line){
                       if (in_array($con->shipping_line,$client)) {
                           if (in_array($con->size,$new_size)) {
                                if (in_array($con->size.$con->container_type,$new_type)) {
                                    $all_data[$con->shipping_line][$con->size][$con->container_type]++;
                                }else{
                                    $new_type[] = $con->size.$con->container_type;
                                    $push = ["$con->container_type" => 1];
                                    $all_data[$con->shipping_line][$con->size] += $push;
                                }
                           }else{
                               $push = [
                                   "$con->size" => [
                                       "$con->container_type" => 1
                                   ]
                               ];
                               $new_size[] = $con->size;
                               $new_type[] = $con->size.$con->container_type;
                               $all_data[$con->shipping_line] += $push;
                           }
                       }else{
                        $new_size[] = $con->size;
                        $new_type[] = $con->size.$con->container_type;
                        $client[] = $con->shipping_line;
                        $all_data +=[
                            "$con->shipping_line" =>[
                                "$con->size" =>[
                                    "$con->container_type" => 1
                                ]
                            ]
                        ]; 
                       }
                    }
                }
            }
            $data = $all_data;
            $size = $size;
            $type = $type;
            $client = $client;
        return view('depot_stock_report',compact('company','shipping','container_type','data','client','new_size','size','type','select_date'));
    }

    public function excel_update_view(){
        return view('excel_update');
    }
    public function excel_update(Request $request){
        $estimate = (new ExcelUpdate)->toArray($request->file('file'));
        $status = ['AVAILABLE','available','AV','av'];
        $error = 0;
        $message = [];
        for ($i=0; $i < count($estimate) ; $i++) { 
            for ($j=0; $j < count($estimate[$i]); $j++) { 
                if (InContainer::where('container_no',$estimate[$i][$j]['containerno'])->where('shipping_line',$estimate[$i][$j]['shipper'])->where('status','!=','AV')->first()) {
                    $model = InContainer::where('container_no',$estimate[$i][$j]['containerno'])->where('shipping_line',$estimate[$i][$j]['shipper'])->where('status','!=','AV')->first();
                    $model->in_date = transformDate($estimate[$i][$j]['indate']);
                    if (in_array($estimate[$i][$j]['value'],$status)) {
                        $model->status = 'AV';
                    }else{
                        $error++;
                        $message[] = 'Failed To Update Status For This'.$estimate[$i][$j]['containerno'].' Check Status Spelling In Excel Sheets';
                    }
                    $model->save();
                }
                if (Inventory::where('container_no',$estimate[$i][$j]['containerno'])->where('shipping_line',$estimate[$i][$j]['shipper'])->where('status','!=','AV')->first()) {
                    $model = Inventory::where('container_no',$estimate[$i][$j]['containerno'])->where('shipping_line',$estimate[$i][$j]['shipper'])->where('status','!=','AV')->first();
                    $model->in_date = transformDate($estimate[$i][$j]['indate']);
                    if (in_array($estimate[$i][$j]['value'],$status)) {
                        $model->status = 'AV';
                    }else{
                        $error++;
                        $message[] = 'Failed To Update Status For This'.$estimate[$i][$j]['containerno'].' Check Status Spelling In Excel Sheets';
                    }
                    $model->save();
                }
            }
        }
        if ($error > 0) {
            return back()->with('error',$message);
        }else{
            return back()->with('success','Excel Updated Successfully');
        }
        
    }
    public function estimate_data_import(){
        return view('estimate_data_import');
    }
    public function upload_estimate_data_import(Request $request){
        $estimate = (new EstimateDataReport)->toArray($request->file('file'));
        for ($i=0; $i < count($estimate) ; $i++) { 
            for ($j=0; $j < count($estimate[$i]); $j++) { 
                if (InContainer::where('container_no',$estimate[$i][$j]['containerno'],'estimate_date',Null)->first()) {
                    $model = InContainer::where('container_no',$estimate[$i][$j]['containerno'],'estimate_date',Null)->first();
                    $model->in_date = transformDate($estimate[$i][$j]['indate']);
                    $model->estimate_date = transformDate($estimate[$i][$j]['estdate']);
                    $model->estimate_amt = $estimate[$i][$j]['estamt'];
                    $model->approval_date = transformDate($estimate[$i][$j]['apdate']);
                    $model->approval_amt = $estimate[$i][$j]['apamt'];
                    $model->av_date = transformDate($estimate[$i][$j]['avdate']);
                    $model->save();
                }
                if (Inventory::where('container_no',$estimate[$i][$j]['containerno'],'estimate_date',Null)->first()) {
                    $model = Inventory::where('container_no',$estimate[$i][$j]['containerno'],'estimate_date',Null)->first();
                    $model->in_date = transformDate($estimate[$i][$j]['indate']);
                    $model->estimate_date = transformDate($estimate[$i][$j]['estdate']);
                    $model->estimate_amt = $estimate[$i][$j]['estamt'];
                    $model->approval_date = transformDate($estimate[$i][$j]['apdate']);
                    $model->approval_amt = $estimate[$i][$j]['apamt'];
                    $model->av_date = transformDate($estimate[$i][$j]['avdate']);
                    $model->save();
                }
            }
        }
        return back()->with('success','IAL File Uploaded Successfully');
    }

    public function total_in_out_movement(){
        $shipping_lines = DB::table('line_masters')->get();
        $container_type = ContainerType::all();
        $out_details = [];
        $in_details = [];
        $in_out_summary = [];
        $shipping = '';
        $new_start_date = '';
        $new_end_date = '';
        $all_data = [];
        $size = [];
        $type = [];
        $type = [];
        $all_total= [];
        return view('total-in-out-movement',compact('all_total','size','type','all_data','container_type','shipping_lines','new_start_date','shipping','new_end_date','in_out_summary','in_details','out_details'));
    }
    public function total_in_out_movement_fetch(Request $request){
        $start_date = $request->post('start_date');
        $end_date = $request->post('end_date');
        $shipping = $request->post('shipping');
        $new_start_date = $request->post('start_date');
        $new_end_date = $request->post('end_date');
        $out_details = [];
        $in_details = [];
        $in_out_summary = [];
        $all_data = [];
        $size = [];
        $type = [];
        $num = 0;
        if ($start_date !== null && $end_date !== null && $shipping !== null) {
            $start_date = str_replace('T', ' ', $start_date);
            $end_date = str_replace('T', ' ', $end_date);
            $in_out_summary = '';
            $in_details = InContainer::whereDate('in_date','>=', $start_date)
                            ->whereDate('in_date','<=', $end_date)
                            ->where('shipping_line',$shipping)
                            ->get();
            $out_details = OutContainer::select('out_containers.*','in_containers.shipping_line','in_containers.container_no','in_containers.size','in_containers.container_type','in_containers.in_date','in_containers.mfg_date'
                                ,'in_containers.tare','in_containers.max_gross','in_containers.payload')
                                ->leftJoin("in_containers", "in_containers.id", "=", "out_containers.in_container_id")
                                ->where('in_containers.shipping_line',$shipping)
                                ->whereDate('out_containers.out_date','>=',$start_date)
                                ->whereDate('out_containers.out_date','<=',$end_date)
                                ->get();
            $in_out_summary = InContainer::leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                                ->where('in_containers.shipping_line',$shipping)
                                ->whereDate('in_containers.in_date','>=',$start_date)
                                ->whereDate('in_containers.in_date','<=',$end_date)
                                ->get();
            for ($i=0; $i <count($in_out_summary) ; $i++) { 
                $turnin = 0;
                $turnout = 0;
                $closing = 1;
                $ae = 0;$ap = 0;$ur = 0;$av = 0;
                if (date('Y-m-d',strtotime($in_out_summary[$i]->in_date)) == date('Y-m-d',strtotime(Carbon::now()))) {
                    $turnin = 1;
                }
                if (date('Y-m-d',strtotime($in_out_summary[$i]->out_date)) == date('Y-m-d',strtotime(Carbon::now()))) {
                    
                    $turnout = 1;
                }
                if($in_out_summary[$i]->out_date !== null){
                    $num++;
                    $closing = 0;
                }
                if ($in_out_summary[$i]->status == 'AE') {
                    $ae = 1;
                }
                if ($in_out_summary[$i]->status == 'AP') {
                    $ap = 1;
                }
                if ($in_out_summary[$i]->status == 'UR') {
                    $ur = 1;
                }
                if ($in_out_summary[$i]->status == 'AV') {
                    $av = 1;
                }
                if (in_array($in_out_summary[$i]->size,$size)) {
                    if (in_array($in_out_summary[$i]->size.$in_out_summary[$i]->container_type,$type)) {
                        $push = ['opening' => +1];
                        $opening = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['opening'] + 1;
                        $turn_in_inc = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['turnin'] + $turnin;
                        $turn_out_inc = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['turnout'] + $turnout;
                        $ae_inc = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['AE'] + $ae;
                        $ap_inc = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['AP'] + $ap;
                        $ur_inc = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['UR'] + $ur;
                        $av_inc = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['AV'] + $av;
                        $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['opening'] = $opening;
                        $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['turnin'] = $turn_in_inc;
                        $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['turnout'] = $turn_out_inc;
                        if($in_out_summary[$i]->out_date !== null){
                            $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['closing'] -= $closing;
                        } else {
                            $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['closing'] += $closing;
                        }
                        $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['total'] = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['closing'];
                        $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['AE'] = $ae_inc;
                        $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['AP'] = $ap_inc;
                        $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['UR'] = $ur_inc;
                        $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['AV'] = $av_inc;
                    }else{
                        $type[] = $in_out_summary[$i]->size.$in_out_summary[$i]->container_type;
                        $push = [$in_out_summary[$i]->container_type
                                    => ['opening' => 1,'turnin' => $turnin,'turnout' => $turnin,'closing' => $closing,'AE' => $ae,'AP' => $ap,'UR' => $ur,'AV' => $av,'total' => $closing]
                                ];
                        $all_data[$in_out_summary[$i]->size] += $push;
                    }
                }else{
                    $size[] = $in_out_summary[$i]->size;
                    $type[] = $in_out_summary[$i]->size.$in_out_summary[$i]->container_type;
                    $all_data += [$in_out_summary[$i]->size
                                    => [$in_out_summary[$i]->container_type
                                        => ['opening' => 1,'turnin' => $turnin,'turnout' => $turnout,'closing' => $closing,'AE' => $ae,'AP' => $ap,'UR' => $ur,'AV' => $av,'total' => $closing]
                                        ]
                                ];
                }
            }
        }
        $all_total = ['opening' => 0,'turnin' => 0,'turnout' => 0,'closing' => 0,'AE' => 0,'AP' => 0,'UR' => 0,'AV' => 0,'total' => 0];
        
        foreach($all_data as $key => $val) { 
            foreach($val as $k => $v) { 
                $all_total['opening'] += $all_data[$key][$k]['opening'];
                $all_total['turnin'] +=  $all_data[$key][$k]['turnin'];
                $all_total['turnout'] +=  $all_data[$key][$k]['turnout'];
                $all_total['closing'] +=  $all_data[$key][$k]['closing'];
                $all_total['AE'] +=  $all_data[$key][$k]['AE'];
                $all_total['AP'] +=  $all_data[$key][$k]['AP'];
                $all_total['UR'] +=  $all_data[$key][$k]['UR'];
                $all_total['AV'] +=  $all_data[$key][$k]['AV'];
                $all_total['total'] +=  $all_data[$key][$k]['total'];
            }
        }
        $shipping_lines = DB::table('line_masters')->get();
        $container_type = ContainerType::all();
        return view('total-in-out-movement',compact('all_total','size','type','all_data','container_type','shipping_lines','new_start_date','shipping','new_end_date','in_out_summary','in_details','out_details'));
    }
    public function multi_sheets(Request $request){
        $name = $request->post('shipping_line') .'-'. date('d-M-Y', strtotime(Carbon::now()));
        return $this->excel->download(new MultiSheetExport($request->post('start_date'),$request->post('end_date'),$request->post('shipping_line')),$name.'.xlsx');
    }
    public function edi_generator(){
        
    }
}
