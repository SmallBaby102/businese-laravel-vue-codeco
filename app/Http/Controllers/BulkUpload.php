<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon\Carbon;
use App\Models\InContainer;
use App\Models\Inventory;
use App\Models\OutContainer;
class BulkUpload extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (Auth::user()->type == 'super_admin') {
            return view('bulk_upload');
        } else {
            return redirect('/dashboard');
        }
    }
    public function bulk_upload_in(Request $request){
        $in_data = (new FastExcel)->import($request->file('in_file'));
        for ($i=0; $i < count($in_data); $i++) { 
                $model = new Inventory();
                $model->container_no = $in_data[$i]['container_no'];
                $model->shipping_line = $in_data[$i]['shipping_line'];
                $model->gate_pass_no = $i;
                $model->depot = $in_data[$i]['depot'];
                if ($in_data[$i]['estimate_date'] !== "") {
                    $model->estimate_date = $in_data[$i]['estimate_date']->format('Y-m-d H:i:s');
                }
                if ($in_data[$i]['estimate_amount'] !== "") {
                    $model->estimate_amt = $in_data[$i]['estimate_amount'];
                }
                if ($in_data[$i]['approval_date'] !== "") {
                    $model->approval_date = $in_data[$i]['approval_date']->format('Y-m-d H:i:s');
                }
                if ($in_data[$i]['approval_amount'] !== "") {
                    $model->approval_amt = $in_data[$i]['approval_amount'];
                }
                if ($in_data[$i]['available_date'] !== "") {
                    $model->av_date = $in_data[$i]['available_date']->format('Y-m-d H:i:s');
                }
                $model->in_date = $in_data[$i]['in_date']->format('Y-m-d H:i:s');
                $model->consignee_party = $in_data[$i]['consignee_Party'];
                $model->place = $in_data[$i]['place'];
                $model->vessel = $in_data[$i]['vessel'];
                $model->transpoter = $in_data[$i]['transporter'];
                $model->vehicle = $in_data[$i]['vehicle'];
                $model->booking_remark = $in_data[$i]['booking_remark'];
                $model->port_from = $in_data[$i]['port_from'];
                $model->cha = $in_data[$i]['cha'];
                $model->driver_name = $in_data[$i]['driver_name'];
                $model->driver_contact = $in_data[$i]['driver_contact'];
                $model->size = $in_data[$i]['size'];
                $model->container_type = $in_data[$i]['type'];
                $model->status = $in_data[$i]['status'];
                $model->max_gross = $in_data[$i]['max_gross'];
                $model->tare = $in_data[$i]['tare'];
                $model->mfg_date = $in_data[$i]['mfg_date']->format('Y-m-d H:i:s');
                $model->csc_date = $in_data[$i]['csc_date']->format('Y-m-d H:i:s');
                $model->import_do = $in_data[$i]['import_do'];
                $model->payload = $in_data[$i]['payload'];
                $model->container_remark = $in_data[$i]['container_remark'];
                $model->grade = $in_data[$i]['grade'];
                $model->related = $i;
                $model->container_adding_type = 0;
                $model->added_by = Auth::user()->name;
                    if ($model->save()) {
                        $model = new InContainer();
                        $model->container_no = $in_data[$i]['container_no'];
                        $model->gate_pass_no = $i;
                        $model->shipping_line = $in_data[$i]['shipping_line'];
                        $model->depot = $in_data[$i]['depot'];
                        if ($in_data[$i]['estimate_date'] !== "") {
                            $model->estimate_date = $in_data[$i]['estimate_date']->format('Y-m-d H:i:s');
                        }
                        if ($in_data[$i]['estimate_amount'] !== "") {
                            $model->estimate_amt = $in_data[$i]['estimate_amount'];
                        }
                        if ($in_data[$i]['approval_date'] !== "") {
                            $model->approval_date = $in_data[$i]['approval_date']->format('Y-m-d H:i:s');
                        }
                        if ($in_data[$i]['approval_amount'] !== "") {
                            $model->approval_amt = $in_data[$i]['approval_amount'];
                        }
                        if ($in_data[$i]['available_date'] !== "") {
                            $model->av_date = $in_data[$i]['available_date']->format('Y-m-d H:i:s');
                        }
                        $model->in_date = $in_data[$i]['in_date']->format('Y-m-d H:i:s');
                        $model->consignee_party = $in_data[$i]['consignee_Party'];
                        $model->place = $in_data[$i]['place'];
                        $model->vessel = $in_data[$i]['vessel'];
                        $model->transpoter = $in_data[$i]['transporter'];
                        $model->vehicle = $in_data[$i]['vehicle'];
                        $model->booking_remark = $in_data[$i]['booking_remark'];
                        $model->port_from = $in_data[$i]['port_from'];
                        $model->cha = $in_data[$i]['cha'];
                        $model->driver_name = $in_data[$i]['driver_name'];
                        $model->driver_contact = $in_data[$i]['driver_contact'];
                        $model->size = $in_data[$i]['size'];
                        $model->container_type = $in_data[$i]['type'];
                        $model->status = $in_data[$i]['status'];
                        $model->max_gross = $in_data[$i]['max_gross'];
                        $model->tare = $in_data[$i]['tare'];
                        $model->mfg_date = $in_data[$i]['mfg_date']->format('Y-m-d H:i:s');
                        $model->csc_date = $in_data[$i]['csc_date']->format('Y-m-d H:i:s');
                        $model->import_do = $in_data[$i]['import_do'];
                        $model->payload = $in_data[$i]['payload'];
                        $model->container_remark = $in_data[$i]['container_remark'];
                        $model->grade = $in_data[$i]['grade'];
                        $model->related = $i;
                        $model->container_adding_type = 0;
                        $model->added_by = Auth::user()->name;
                        $model->save();
                    }
        }  
        return redirect()->route('bulk_upload.index')->with('success','Data Inserted Successfully');
    }
    public function bulk_upload_out(Request $request){
        $out_data = (new FastExcel)->import($request->file('out_file'));
        for ($i=0; $i < count($out_data) ; $i++) { 
            if ($inv = Inventory::where('container_no',$out_data[$i]['container_no'])->first()) {
                $inc = InContainer::where('container_no',$out_data[$i]['container_no'])->first();
                $model = new OutContainer();
                $model->in_container_id = $inc->id;
                $model->out_depot = $out_data[$i]['depot'];
                $model->out_date  = $out_data[$i]['out_date']->format('Y-m-d H:i:s');
                $no_in_depo = strtotime(Carbon::now()) - strtotime($inc->in_date);
                $diff = round($no_in_depo / 86400);
                $model->no_of_days_in_depot = $diff;
                $model->out_consignee_party = $out_data[$i]['shipper_party'];
                $model->out_place = $out_data[$i]['place'];
                $model->out_vessel = $out_data[$i]['vessel'];
                $model->out_transpoter = $out_data[$i]['transporter'];
                $model->out_vehicle = $out_data[$i]['vehicle'];
                $model->port_to = $out_data[$i]['port_to'];
                $model->out_driver_name = $out_data[$i]['driver_name'];
                $model->out_driver_contact = $out_data[$i]['driver_contact'];
                $model->out_status = $out_data[$i]['status'];
                $model->export_do = $out_data[$i]['export_do'];
                $model->seal_no = $out_data[$i]['seal_no'];
                $model->challan_no = $out_data[$i]['challan_no'];
                $model->remak_note = $out_data[$i]['remark_note'];
                $model->out_grade = $out_data[$i]['grade'];
                $model->out_related  = $i;
                $model->eao_cono = $out_data[$i]['eao'];
                $model->out_added_by = Auth::user()->name;
                $model->save();
                $inv->delete();
            }
        }
        return redirect()->route('bulk_upload.index')->with('success','Data Inserted Successfully');
    }
}
