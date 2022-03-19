<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\ial_upload;
use App\Models\InContainer;
use App\Models\LineMaster;
use App\Imports\OffhireImport;
use App\Models\CompanyDetail;
use App\Models\OutContainer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class GetPassController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->middleware('auth');
    }
    public function index()
    {
        return view('get_pass');        
    }
    public function gate_pass_preview(Request $request){
        $error = 0;
        $error_msg = [];
        $size = $request->post('size');
        $container_pattern = "/^([A-Z]{4}[0-9]{7})$/i";
        $phone_pattern = "/^[7-9][0-9]{9}$/i";
        for ($i=0; $i < count($size) ; $i++) { 
            if ($request->post('container_no')[$i] !== null) {
               $find = Inventory::where('container_no',$request->post('container_no')[$i])->get();
               if (count($find) > 0) {
                   $error++;
                   $error_msg[] = 'Container Number '.$request->post('container_no')[$i].' Is Already Exist In Inventory';
               }
               if (!preg_match($container_pattern, trim($request->post('container_no')[$i]))) {
                    $error++;
                    $error_msg[] = 'Container Number '.$request->post('container_no')[$i].' Is Invalid Pattern';
               }
            }
               
        }
        if (!preg_match($phone_pattern, $request->post('driver_phone'))) {
            $error++;
            $error_msg[] = 'Invalid Contact Number '.$request->post('driver_phone');
        }
        if ($error == 0) {
            return ['error' => $error,'message' => $request->all()];
        } else {
            return ['error' => $error,'message' => $error_msg];
        }
    }
    public function store(Request $request)
    {
        $error = 0;
        $error_msg = [];
        $size = $request->post('size');
        $container_pattern = "/^([A-Z]{4}[0-9]{7})$/i";
        $phone_pattern = "/^[7-9][0-9]{9}$/i";
        for ($i=0; $i < count($size) ; $i++) { 
            if ($request->post('container_no')[$i] !== null) {
               $find = Inventory::where('container_no',$request->post('container_no')[$i])->get();
               if (count($find) > 0) {
                   $error++;
                   $error_msg[] = 'Container Number '.$request->post('container_no')[$i].' Is Already Exist In Inventory';
               }
               if (!preg_match($container_pattern, trim($request->post('container_no')[$i]))) {
                    $error++;
                    $error_msg[] = 'Container Number '.$request->post('container_no')[$i].' Is Invalid Pattern';
               }
            }
               
        }
        if (!preg_match($phone_pattern, $request->post('driver_phone'))) {
            $error++;
            $error_msg[] = 'Invalid Contact Number '.$request->post('driver_phone');
        }
        $container_1 = '';
        
        $related = Str::slug($request->post('driver'), '-');
        $related = $related . '-' .rand(100000,1000000000000);
        if ($error == 0) {
            for ($i=0; $i < count($size) ; $i++) {
                if ($size[$i] !== null) {
                    $model = new Inventory();
                    $model->container_no = $request->post('container_no')[$i];
                    $model->shipping_line = $request->post('shipping');
                    $model->gate_pass_no = $request->post('gate_pass_no');
                    $model->depot = $request->post('depot');
                    $model->depot_code = $request->post('depot_code');
                    $model->in_date = Carbon::now();
                    $model->consignee_party = $request->post('consignee');
                    $model->place = $request->post('place');
                    $model->vessel = $request->post('vessel');
                    $model->transpoter = $request->post('transpoter');
                    $model->vehicle = $request->post('vehicle');
                    $model->booking_remark = $request->post('booking');
                    $model->port_from = $request->post('port');
                    $model->cha = $request->post('cha');
                    $model->driver_name = $request->post('driver');
                    $model->driver_contact = $request->post('driver_phone');
                    $model->size = $request->post('size')[$i];
                    $model->container_type = $request->post('type')[$i];
                    $model->status = $request->post('sstatus')[$i];
                    $model->max_gross = $request->post('gross')[$i];
                    $model->tare = $request->post('tare')[$i];
                    $model->mfg_date = $request->post('mfg')[$i];
                    $model->csc_date = $request->post('csc')[$i];
                    $model->import_do = $request->post('import')[$i];
                    $model->payload = $request->post('payload')[$i];
                    $model->container_remark = $request->post('container_remark')[$i];
                    $model->grade = $request->post('grade')[$i];
                    $model->related = $related;
                    $model->container_adding_type = $request->post('container_type');
                    $model->added_by = Auth::user()->name;
                    if ($model->save()) {
                        $model = new InContainer();
                        $model->container_no = $request->post('container_no')[$i];
                        $model->gate_pass_no = $request->post('gate_pass_no_in');
                        $model->shipping_line = $request->post('shipping');
                        $model->depot = $request->post('depot');
                        $model->depot_code = $request->post('depot_code');
                        $model->in_date = Carbon::now();
                        $model->consignee_party = $request->post('consignee');
                        $model->place = $request->post('place');
                        $model->vessel = $request->post('vessel');
                        $model->transpoter = $request->post('transpoter');
                        $model->vehicle = $request->post('vehicle');
                        $model->booking_remark = $request->post('booking');
                        $model->port_from = $request->post('port');
                        $model->cha = $request->post('cha');
                        $model->driver_name = $request->post('driver');
                        $model->driver_contact = $request->post('driver_phone');
                        $model->size = $request->post('size')[$i];
                        $model->container_type = $request->post('type')[$i];
                        $model->status = $request->post('sstatus')[$i];
                        $model->max_gross = $request->post('gross')[$i];
                        $model->tare = $request->post('tare')[$i];
                        $model->mfg_date = $request->post('mfg')[$i];
                        $model->csc_date = $request->post('csc')[$i];
                        $model->import_do = $request->post('import')[$i];
                        $model->payload = $request->post('payload')[$i];
                        $model->container_remark = $request->post('container_remark')[$i];
                        $model->grade = $request->post('grade')[$i];
                        $model->related = $related;
                        $model->container_adding_type = $request->post('container_type');
                        $model->added_by = Auth::user()->name;
                        if ($model->save()) {
                            if ($request->post('container_type') == 0) {
                                $ial = ial_upload::find($request->post('ial_upload_id')[$i]);
                                $container = json_decode($ial->container_no,true);
                                $new_data = array_diff($container, array($request->post('container_no')[$i]));
                                $reached = json_decode($ial->reached,true);
                                $new_date = Carbon::now();
                                $reached[] = [$request->post('container_no')[$i] => "$new_date"];
                                $reached = json_encode($reached);
                                $ial->container_no = json_encode($new_data);
                                $ial->reached = $reached;
                                $ial->save();
                                $error_msg[] = 'Data Inserted Successfully';
                            }else{
                                $error_msg[] = 'Data Inserted Successfully';
                            }
                        }else{
                            $error++;
                            $error_msg[] = 'Data inserted in Inventory Table But Failed To Insert In Container Table';
                        }
                    }else{
                        $error++;
                        $error_msg[] = 'Failed To Insert Data';
                    }
                }

            }
            
        }
        return ['error' => $error,'message' => $error_msg,'related' => $related];
    }
    public function out_container(){
        return view('out_container');
    }
    public function out_container_store(Request $request){
        $error = 0;
        $error_msg = [];
        $container_pattern = "/^([A-Z]{4}[0-9]{7})$/i";
        $phone_pattern = "/^[7-9][0-9]{9}$/i";
        if ($request->post('container_no') !== null) {
            if (!preg_match($container_pattern, trim($request->post('container_no')))) {
                    $error++;
                    $error_msg[] = 'Container Number '.$request->post('container_no').' Is Invalid Pattern';
            }else{
                $find = Inventory::where('container_no',$request->post('container_no'))->get();
                if (count($find) <= 0) {
                       $error++;
                       $error_msg[] = 'Container Number '.$request->post('container_no').' Is Not Exist In Inventory';
                }
            }
        }else{
            $error++;
            $error_msg[] = 'Please Fill Container Number';
        }
        if (!preg_match($phone_pattern, $request->post('out_driver_contact'))) {
            $error++;
            $error_msg[] = 'Invalid Contact Number '.$request->post('out_driver_contact');
        }
        if ($request->post('out_status') !== 'AV') {
            $error++;
            $error_msg[] = ' This Container Status Is Not Available';
        }
        $related = Str::slug($request->post('out_driver_name'), '-');
        $related = $related . '-' .rand(100000,1000000000000);
        if ($error == 0) {
            $model = new OutContainer();
            $model->in_container_id = $request->post('container_id');
            $model->out_depot = $request->post('depot');
            $model->final_dest = $request->post('final_dest');
            $model->out_date = Carbon::now();
            $model->no_of_days_in_depot = $request->post('total_days');
            $model->out_consignee_party = $request->post('out_shipper_party');
            $model->out_place = $request->post('out_place');
            $model->out_vessel = $request->post('out_vessel');
            $model->out_transpoter = $request->post('out_transpoter');
            $model->out_vehicle = $request->post('out_vehicle');
            $model->port_to = $request->post('out_port_to');
            $model->out_driver_name = $request->post('out_driver_name');
            $model->out_driver_contact = $request->post('out_driver_contact');
            $model->out_status = $request->post('out_status');
            $model->export_do = $request->post('export_do');
            $model->seal_no = $request->post('out_seal_no');
            $model->challan_no = $request->post('out_challan_no');
            $model->original_port = $request->post('org_port');
            $model->remak_note = $request->post('out_container_remark');
            $model->out_grade = $request->post('out_grade');
            $model->out_related = $related;
            $model->eao_cono = $request->post('out_eao');
            $model->out_added_by = Auth::user()->name;
            if ($model->save()) {
                $delete = Inventory::find($request->post('inventory_id'));
                $delete->delete();
                $error_msg[] = 'Container Out successfully';
            }else{
                $error++;
                $error_msg[] = 'Failed To Out Container';
            }
            
        }
        return ['error' => $error,'message' => $error_msg,'related' => $related];
    }
    public function reciept($related){
        $model = Inventory::where('related',$related)->get();
        $company = CompanyDetail::find(1);
        return view('gate_pass_reciept',compact('model','company'));
        
    }
    public function estimate_data_report(){
        return view('estimate_data_report');
    }
    public function save_estimate_report(Request $request){
        $error = 0;
        $error_msg = [];
        $container_pattern = "/^([A-Z]{4}[0-9]{7})$/i";
        if ($request->post('container_no') !== null) {
            if (!preg_match($container_pattern, trim($request->post('container_no')))) {
                    $error++;
                    $error_msg[] = 'Container Number '.$request->post('container_no').' Is Invalid Pattern';
            }else{
                $find = InContainer::where('container_no',$request->post('container_no'))->get();
                if (count($find) <= 0) {
                       $error++;
                       $error_msg[] = 'Container Number '.$request->post('container_no').' Is Not Exist In Inventory';
                }
            }
        }else{
            $error++;
            $error_msg[] = 'Please Fill Container Number';
        }
        if ($error == 0) {
            $model = Inventory::find($request->post('inventory_id'));
            $model->estimate_date = $request->post('es_date');
            $model->estimate_amt = $request->post('es_amount');
            $model->approval_date = $request->post('ap_date');
            $model->approval_amt = $request->post('ap_amount');
            $model->av_date = $request->post('av_date');
            $model->status = $request->post('status');
            if ($model->save()) {
                $model = InContainer::find($request->post('container_id'));
                $model->estimate_date = $request->post('es_date');
                $model->estimate_amt = $request->post('es_amount');
                $model->approval_date = $request->post('ap_date');
                $model->approval_amt = $request->post('ap_amount');
                $model->av_date = $request->post('av_date');
                $model->status = $request->post('status');
                $model->save();
                $error_msg[] = 'Estimate Report Updated Successfully';
            }
        }
         
        return ['error' => $error,'message' => $error_msg];
    }

    public function offhire(){
        return view('offhire');
    }
    public function offhire_save(Request $request){
        $off = (new OffhireImport)->toArray($request->file('file'));
        $company = CompanyDetail::find(1);
        $inv_last = Inventory::orderBy('id', 'desc')->first();
        $in_conn_last = InContainer::orderBy('id', 'desc')->first();
        $inv_id = $inv_last->gate_pass_no;
        $in_con_id = $in_conn_last->gate_pass_no;
        foreach ($off as $value) {
            foreach ($value as $v) {
                if ($v['container_no'] !== null) {
                    $inv_id++;
                    $in_con_id++;
                    $in_con = InContainer::where('container_no',$v['container_no'])->orderBy('id', 'desc')->first();
                    // dd($in_con);
                    $total_num_day = strtotime(Carbon::now()) - strtotime($in_con->in_date);
                    $diff = round($total_num_day / 86400);
                    $model = new OutContainer();
                    $model->in_container_id = $in_con->id;
                    $model->out_depot = $company->depot;
                    $model->out_date = Carbon::now();
                    $model->no_of_days_in_depot = $diff;
                    $model->out_consignee_party = '';
                    $model->out_place = '';
                    $model->out_vessel = '';
                    $model->out_transpoter = '';
                    $model->out_vehicle = '';
                    $model->port_to = '';
                    $model->out_driver_name = '';
                    $model->out_driver_contact = '';
                    $model->out_status = '';
                    $model->export_do = '';
                    $model->seal_no = '';
                    $model->challan_no = '';
                    $model->remak_note = 'Offhire '.$request->post('shipping_from').' To '.$request->post('shipping_to');
                    $model->out_grade = '';
                    $model->out_related = '';
                    $model->eao_cono = '';
                    $model->out_added_by = Auth::user()->name;
                    if ($model->save()) {
                        $inv = Inventory::where('container_no',$v['container_no'])->first();
                        $inv->delete();
                        $model = new Inventory();
                        $model->container_no = $v['container_no'];
                        $model->shipping_line = $request->post('shipping_to');
                        $model->gate_pass_no = $inv_id;
                        $model->depot = $company->depot;
                        $model->in_date = Carbon::now();
                        $model->consignee_party = '';
                        $model->place = '';
                        $model->vessel = '';
                        $model->transpoter = '';
                        $model->vehicle = '';
                        $model->booking_remark = '';
                        $model->port_from = '';
                        $model->cha = '';
                        $model->driver_name = '';
                        $model->driver_contact = '';
                        $model->size = $v['size'];
                        $model->container_type = $v['type'];
                        $model->status = $v['status'];
                        $model->max_gross = $in_con->max_gross;
                        $model->tare = $in_con->tare;
                        $model->mfg_date = $in_con->mfg_date;
                        $model->csc_date = $in_con->csc_date;
                        $model->estimate_date = $in_con->estimate_date;
                        $model->estimate_amt = $in_con->estimate_amt;
                        $model->approval_date = $in_con->approval_date;
                        $model->approval_amt = $in_con->approval_amt;
                        $model->av_date = $in_con->av_date;
                        $model->import_do = '';
                        $model->payload = '';
                        $model->container_remark = $in_con->container_remark;
                        $model->grade = $in_con->grade;
                        $model->related = '';
                        $model->container_adding_type = 2;
                        $model->added_by = Auth::user()->name;
                        if ($model->save()) {
                            $model = new InContainer();
                            $model->container_no = $v['container_no'];
                            $model->gate_pass_no = $in_con_id;
                            $model->shipping_line = $request->post('shipping_to');
                            $model->depot = '';
                            $model->in_date = Carbon::now();
                            $model->consignee_party = '';
                            $model->place = '';
                            $model->vessel = '';
                            $model->transpoter = '';
                            $model->vehicle = '';
                            $model->booking_remark = '';
                            $model->port_from = '';
                            $model->cha = '';
                            $model->driver_name = '';
                            $model->driver_contact = '';
                            $model->size = $v['size'];
                            $model->container_type = $v['type'];
                            $model->status = $v['status'];
                            $model->max_gross = $in_con->max_gross;
                            $model->tare = $in_con->tare;
                            $model->mfg_date = $in_con->mfg_date;
                            $model->csc_date = $in_con->csc_date;
                            $model->estimate_date = $in_con->estimate_date;
                            $model->estimate_amt = $in_con->estimate_amt;
                            $model->approval_date = $in_con->approval_date;
                            $model->approval_amt = $in_con->approval_amt;
                            $model->av_date = $in_con->av_date;
                            $model->import_do = '';
                            $model->payload = '';
                            $model->container_remark = $in_con->container_remark;
                            $model->grade = $in_con->grade;
                            $model->related = '';
                            $model->container_adding_type = 2;
                            $model->added_by = Auth::user()->name;
                            $model->save();
                        }
                    }
                }
            }
        }

        return redirect()->route('offhire')->with('success','Offhire '.$request->post('shipping_from').' To '.$request->post('shipping_to').' Successfully');
    }

}
