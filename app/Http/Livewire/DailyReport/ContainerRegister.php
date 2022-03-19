<?php

namespace App\Http\Livewire\DailyReport;

use App\Exports\InContainerExport;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Models\InContainer;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\OutContainer;
class ContainerRegister extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $shipping;
    public $selected_start_date,$selected_end_date;
    public $lines = 'all',$status = 'all',$check_table = 1;
    public $message;
    public $status_master,$check = [];
    public $result = 0;
    protected $data;
    public $query,$table;
    public function render()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->shipping = DB::table('line_masters')->get();
        $this->status_master = DB::table('status_masters')->get();
        $this->data = $this->search();
        return view('livewire.daily-report.container-register');
    }
    public function search(){
        if ($this->selected_start_date != null && $this->selected_end_date != null) {
            if ($this->check_table == 1) {
                if ($this->lines !== 'all' && $this->status !== 'all') {
                    return InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$this->selected_start_date)
                    ->whereDate('in_containers.created_at','<=',$this->selected_end_date)
                    ->where('in_containers.shipping_line',$this->lines)
                    ->where('in_containers.status',$this->status)
                    ->get();
                }
                if ($this->lines == 'all' && $this->status !== 'all') {
                    return InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$this->selected_start_date)
                    ->whereDate('in_containers.created_at','<=',$this->selected_end_date)
                    ->where('in_containers.status',$this->status)
                    ->get();
                }
                if ($this->lines !== 'all' && $this->status == 'all') {
                    return InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$this->selected_start_date)
                    ->whereDate('in_containers.created_at','<=',$this->selected_end_date)
                    ->where('in_containers.shipping_line',$this->lines)
                    ->get();
                }
                if ($this->lines == 'all' && $this->status == 'all') {
                    return InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$this->selected_start_date)
                    ->whereDate('in_containers.created_at','<=',$this->selected_end_date)
                    ->get();
                }
            }elseif ($this->check_table == 2) {
                if ($this->lines !== 'all' && $this->status !== 'all') {
                    return OutContainer::select('out_containers.*','in_containers.*')
                    ->leftJoin("in_containers", "in_containers.id", "=", "out_containers.in_container_id")
                    ->whereDate('out_containers.created_at','>=',$this->selected_start_date)
                    ->whereDate('out_containers.created_at','<=',$this->selected_end_date)
                    ->where('in_containers.status',$this->status)
                    ->where('in_containers.shipping_line',$this->lines)
                    ->get();
                }
                if ($this->lines == 'all' && $this->status !== 'all') {
                    return OutContainer::select('out_containers.*','in_containers.*')
                    ->leftJoin("in_containers", "in_containers.id", "=", "out_containers.in_container_id")
                    ->whereDate('out_containers.created_at','>=',$this->selected_start_date)
                    ->whereDate('out_containers.created_at','<=',$this->selected_end_date)
                    ->where('in_containers.status',$this->status)
                    ->get();
                    
                }
                if ($this->lines !== 'all' && $this->status == 'all') {
                    return OutContainer::select('out_containers.*','in_containers.*')
                    ->leftJoin("in_containers", "in_containers.id", "=", "out_containers.in_container_id")
                    ->whereDate('out_containers.created_at','>=',$this->selected_start_date)
                    ->whereDate('out_containers.created_at','<=',$this->selected_end_date)
                    ->where('in_containers.shipping_line',$this->lines)
                    ->get();
                }
                if ($this->lines == 'all' && $this->status == 'all') {
                    return OutContainer::select('out_containers.*','in_containers.*')
                    ->leftJoin("in_containers", "in_containers.id", "=", "out_containers.in_container_id")
                    ->whereDate('out_containers.created_at','>=',$this->selected_start_date)
                    ->whereDate('out_containers.created_at','<=',$this->selected_end_date)
                    ->get();
                }
            }elseif ($this->check_table == 4) {
                if ($this->lines !== 'all' && $this->status !== 'all') {
                    return InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$this->selected_start_date)
                    ->whereDate('in_containers.created_at','<=',$this->selected_end_date)
                    ->where('in_containers.shipping_line',$this->lines)
                    ->where('in_containers.status',$this->status)
                    ->where('in_containers.av_date','!=',null)
                    ->get();
                }
                if ($this->lines == 'all' && $this->status !== 'all') {
                    return InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$this->selected_start_date)
                    ->whereDate('in_containers.created_at','<=',$this->selected_end_date)
                    ->where('in_containers.status',$this->status)
                    ->where('in_containers.av_date','!=',null)
                    ->get();
                }
                if ($this->lines !== 'all' && $this->status == 'all') {
                    return InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$this->selected_start_date)
                    ->whereDate('in_containers.created_at','<=',$this->selected_end_date)
                    ->where('in_containers.shipping_line',$this->lines)
                    ->where('in_containers.av_date','!=',null)
                    ->get();
                }
                if ($this->lines == 'all' && $this->status == 'all') {
                    return InContainer::select('in_containers.*','out_containers.*')
                    ->leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                    ->whereDate('in_containers.created_at','>=',$this->selected_start_date)
                    ->whereDate('in_containers.created_at','<=',$this->selected_end_date)
                    ->where('in_containers.av_date','!=',null)
                    ->get();
                }
            }
        }else{
            $this->result = 1;
            $this->message = 'please select start date and end date first';
        }
    }
    public function export(){
        if ($this->check) {
            return (new InContainerExport($this->check,$this->query,$this->table))->download('container.xls');
        }else{
            $this->result = 1;
            $this->message = 'please select Rows First To Excel Export';
        }
    }
}
