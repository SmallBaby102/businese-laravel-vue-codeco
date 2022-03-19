<?php

namespace App\Http\Livewire\DailyReport;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Carbon\Carbon;
class InventoryReport extends Component
{
    use WithPagination;
    public $shipping;
    public $selected_date;
    public $lines = 'all';
    public $message;
    public $result = 0;
    public $data;
    public function render()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->shipping = DB::table('line_masters')->get();
        $this->data = $this->search();
        return view('livewire.daily-report.inventory-report');
    }
    public function search(){
        if ($this->selected_date !== null) {
            if ($this->selected_date <= Carbon::now()) {
                if($this->lines !== 'all'){
                    return DB::select("SELECT * FROM in_containers AS A WHERE date(A.created_at) <= '".$this->selected_date."' AND A.shipping_line = '".$this->lines."' AND A.id NOT IN (SELECT in_container_id FROM out_containers WHERE created_at <= '".$this->selected_date." 23:59:59' )");
                }else{
                    return DB::select("SELECT * FROM in_containers AS A WHERE date(A.created_at) <= '".$this->selected_date."' AND A.id NOT IN (SELECT in_container_id FROM out_containers WHERE created_at <= '".$this->selected_date." 23:59:59' )");
                }
            }else{
                $this->result = 1;
                $this->message = 'please select Current Or Previous Date';
            }
        }else{
            $this->result = 1;
            $this->message = 'please select date first';
        }
    }
}
