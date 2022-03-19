<?php

namespace App\Http\Livewire\DailyReport;

// use App\Http\Livewire\DailyEntry\OutContainer;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\InContainer;
use App\Models\OutContainer;
class TotalInOutMovement extends Component
{
    public $start_date,$end_date,$shipping,$data,$shipping_lines,$message;
    public $in_out_summary,$in_details,$out_details;
    public function render()
    {
        $this->shipping_lines = DB::table('line_masters')->get();
        return view('livewire.daily-report.total-in-out-movement');
    }
    public function search(){
        if ($this->start_date !== null && $this->end_date !== null && $this->shipping !== null) {
            $start_date = str_replace('T', ' ', $this->start_date);
            $end_date = str_replace('T', ' ', $this->end_date);
            $this->message = '';
            $this->in_out_summary = '';
            $this->in_details = InContainer::whereDate('in_date','>=',$start_date)->whereDate('in_date','<=',$end_date)->get();
            $this->out_details = OutContainer::select('out_containers.*','in_containers.container_no','in_containers.size','in_containers.container_type','in_containers.in_date','in_containers.mfg_date'
                                ,'in_containers.tare','in_containers.max_gross','in_containers.payload')
                                ->leftJoin("in_containers", "in_containers.id", "=", "out_containers.in_container_id")
                                ->whereDate('out_containers.out_date','>=',$start_date)->whereDate('out_containers.out_date','<=',$end_date)
                                ->get();
        }else{
            $this->message = 'Please Select All The Fields First';
        }
    }
}
