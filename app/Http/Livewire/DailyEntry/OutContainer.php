<?php

namespace App\Http\Livewire\DailyEntry;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class OutContainer extends Component
{
    // container information
    public $total_days,$size,$type,$container_type,$import,$message,$depot,$shipping,$status_master,$container_id,$result,$company_detail,$inventory_id;

    // inward information
    public $in_date,$in_status,$in_party,$in_place,$in_vessel,$in_port,$in_cha,$in_transpoter,$in_vehicle,$in_grade,$in_driver_name,$in_driver_contact,$in_added_by,$in_container_remark,$in_booking_remark;
    // Outward information
    public $ap_date,$av_date,$status; 
    public function render()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->company_detail = DB::table('company_details')->where('id',1)->get();
        $this->status_master = DB::table('status_masters')->get();
        return view('livewire.daily-entry.out-container');
    }
    public function search($val)
    {
        $this->result = 0;
        $pattern = "/^([A-Z]{4}[0-9]{7})$/i";
        if (preg_match($pattern, $val)) {
            $find = DB::table('inventories')->where('container_no',$val)->get();
            if (count($find) <= 0) {
                $this->result = 1;
                $this->resetFilters();
                $this->message = 'This Container Number Is Not Exist in Inventory';
            }else{
                $this->result = 0;
                $this->container_id = DB::table('in_containers')->where('container_no',$val)->first()->id;
                foreach ($find as $value) {
                    $this->depot = $value->depot;
                    $this->size = $value->size;
                    $this->container_type = $value->container_type;
                    $this->import = $value->import_do;
                    $this->in_date = $value->in_date;
                    $this->in_status = $value->status;
                    $this->in_party = $value->consignee_party;
                    $this->in_place = $value->place;
                    $this->in_vessel = $value->vessel;
                    $this->in_port = $value->place;
                    $this->in_cha = $value->cha;
                    $this->in_transpoter = $value->transpoter;
                    $this->in_vehicle = $value->vehicle;
                    $this->in_grade = $value->grade;
                    $this->in_driver_name = $value->driver_name;
                    $this->in_driver_contact = $value->driver_contact;
                    $this->in_added_by = $value->added_by;
                    $this->in_container_remark = $value->container_remark;
                    $this->in_booking_remark = $value->booking_remark;
                    $this->shipping = $value->shipping_line;
                    $this->inventory_id = $value->id;
                    $this->ap_date = $value->approval_date;
                    $this->av_date = $value->av_date;
                    $this->status = $value->status;
                }
                $old = strtotime($this->in_date);
                $new = strtotime(Carbon::now());
                $diff = $new - $old;
                $this->total_days = round($diff / 86400);
                $this->message = '';
            }
        }else{
            $this->type = 1;
            $this->resetFilters();
            $this->result = 1;
            $this->message = 'Invalid Pattern';
        }
    }
    public function resetFilters(){
        $this->reset(['ap_date','av_date','status','depot','container_id','container_type','size','shipping','type','import','in_date','in_status','in_party','in_place','in_vessel','in_port','in_cha','in_transpoter','in_vehicle','in_grade','in_driver_name','in_driver_contact','in_added_by','in_container_remark','in_booking_remark']);
    }
}
