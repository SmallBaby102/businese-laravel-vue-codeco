<?php

namespace App\Http\Livewire\DailyEntry;

use Livewire\Component;
use App\Models\ial_upload;
use App\Models\ContainerType;
use Illuminate\Support\Facades\DB;
class GatePass extends Component
{
    public $search,$ial_upload_id,$ial_upload_id_2;
    public $type = 1;
    public $message = '';
    public $result = 0;
    public $party,$vessel,$port,$place,$transporter,$vehicle,$booking_remark,$cha,$driver_name,$driver_contact;
    public $size_1,$import_1,$type_1,$container_no_1,$status_1,$sub_status_1,$gross_1,$tare_1,$mfg_1,$csc_1,$payload_1,$container_remark_1;
    public $size_2,$import_2,$type_2,$container_no_2,$status_2,$sub_status_2,$gross_2,$tare_2,$mfg_2,$csc_2,$payload_2,$container_remark_2;
    public $container_type;
    public $company_detail;
    public $gate_pass_no;
    public $gate_pass_no_in;
    public function render()
    {
        
        if ($gate_pass_in = DB::table('in_containers')->latest('id')->first()) {
            $this->gate_pass_no_in = $gate_pass_in->gate_pass_no;
        }
        if ($gate_pass = DB::table('inventories')->latest('id')->first()) {
            $this->gate_pass_no = $gate_pass->gate_pass_no;
        }
        $this->container_type = ContainerType::all();
        $status = DB::table('status_masters')->get();
        $line_master = DB::table('line_masters')->get();
        $this->company_detail = DB::table('company_details')->where('id',1)->get();
        return view('livewire.daily-entry.gate-pass',['status_master' => $status,'line_master' => $line_master]);
    }
    public function search($val)
    {
        $this->result = 0;
        $all = ial_upload::all();
        $pattern = "/^([A-Z]{4}[0-9]{7})$/i";
        if (preg_match($pattern, $val)) {
            $find = DB::table('inventories')->where('container_no',$val)->get();
            if (count($find) > 0) {
                $this->result = 2;
                $this->resetFilters();
                $this->message = 'This Container Number Already Exist in Inventory';
            }else{

                foreach ($all as $value) {
                    $container = json_decode($value->container_no,true);    
                    if (in_array($val,$container)) {
                        $this->party = $value->shipper;
                        $this->vessel = $value->vessel;
                        $this->port = $value->port;
                        $this->size_1 = $value->size;
                        $this->type_1 = $value->type;
                        $this->import_1 = $value->import_do;
                        $this->result = 0;
                        $this->type = 0;
                        $this->ial_upload_id = $value->id;
                        $this->message = '';
                        break;
                    }else{
                        $this->type = 1;
                        $this->reset(['size_1','type_1','import_1']);
                        $this->resetFilters();
                        $this->result = 3;
                        $this->message = 'This Container Number Not Exist in IAL List';
                    }
                }
            }
        }else{
            $this->type = 1;
            $this->reset(['size_1','type_1','import_1']);
            $this->resetFilters();
            $this->result = 1;
            $this->message = 'Invalid Pattern';
        }
        
    }
    public function search_2($val)
    {
        $this->result = 0;
        $all = ial_upload::all();
        $pattern = "/^([A-Z]{4}[0-9]{7})$/i";
        if (preg_match($pattern, $val)) {
            $find = DB::table('inventories')->where('container_no',$val)->get();
            if (count($find) > 0) {
                $this->result = 1;
                $this->resetFilters();
                $this->message = 'This Container Number Already Exist in Inventory';
            }else{
                foreach ($all as $value) {
                    $container = json_decode($value->container_no,true);    
                    if (in_array($val,$container)) {
                        $this->party = $value->shipper;
                        $this->vessel = $value->vessel;
                        $this->port = $value->port;
                        $this->size_2 = $value->size;
                        $this->type_2 = $value->type;
                        $this->import_2 = $value->import_do;
                        $this->result = 0;
                        $this->type = 0;
                        $this->ial_upload_id_2 = $value->id;
                        break;
                    }else{
                        $this->type = 1;
                        $this->reset(['size_2','type_2','import_2']);
                        $this->resetFilters();
                        $this->result = 1;
                        $this->message = 'This Container Number Not Exist in IAL List';
                    }
                }
            }
        }else{
            $this->type = 1;
            $this->reset(['size_2','type_2','import_2']);
            $this->resetFilters();
            $this->result = 1;
            $this->message = 'Invalid Pattern';
        }
    }
    public function resetFilters(){
        $this->reset(['party','vessel','port']);
    }
}
