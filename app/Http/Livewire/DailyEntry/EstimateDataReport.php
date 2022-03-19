<?php

namespace App\Http\Livewire\DailyEntry;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class EstimateDataReport extends Component
{
    public $company_detail,$status_master,$result,$message,$size,$type,$shipping,$in_date,$status,$container_id,$inventory_id;  
    public $data = ['estimate_date' =>'','estimate_amount'=>'','approval_date'=>'','approval_amount'=>'','av_date'=>''];
    public function render()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->company_detail = DB::table('company_details')->where('id',1)->get();
        $this->status_master = DB::table('status_masters')->get();
        return view('livewire.daily-entry.estimate-data-report');
    }
    public function search($val)
    {
        $this->result = 0;
        $pattern = "/^([A-Z]{4}[0-9]{7})$/i";
        if (preg_match($pattern, $val)) {
            $find = DB::table('in_containers')->where('container_no',$val)->get();
            if (count($find) <= 0) {
                $this->result = 1;
                $this->resetFilters();
                $this->message = 'This Container Number Is Not Exist in Inventory';
            }else{
                $this->result = 0;
                $this->inventory_id = DB::table('inventories')->where('container_no',$val)->first()->id;
                foreach ($find as $value) {
                    $this->size = $value->size;
                    $this->type = $value->container_type;
                    $this->shipping = $value->shipping_line;
                    $this->in_date = $value->in_date;
                    $this->status = $value->status;
                    $this->container_id = $value->id;
                    $this->data['estimate_date'] = date('Y-m-d', strtotime($value->estimate_date));
                    $this->data['estimate_amount'] = $value->estimate_amt;
                    $this->data['approval_date'] = date('Y-m-d', strtotime($value->approval_date));
                    $this->data['approval_amount'] = $value->approval_amt;
                    $this->data['av_date'] = date('Y-m-d', strtotime($value->av_date));
                }
                $this->message = '';
            }
        }else{
            $this->resetFilters();
            $this->result = 1;
            $this->message = 'Invalid Pattern';
        }
    }
    public function resetFilters(){
        $this->reset(['size','type','shipping','in_date','status']);
    }
}
