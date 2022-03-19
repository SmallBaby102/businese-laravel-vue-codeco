<?php

namespace App\Http\Livewire\DailyReport;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ial_upload;
class IalReportWithDelete extends Component
{
    use WithPagination;
    public $show = 0;
    public $container_no;
    public $size;
    public $type;
    public $container_reached;
    protected $data;
    public $find;
    public function render()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->data = ial_upload::latest()->paginate(20);
        return view('livewire.daily-report.ial-report-with-delete',['data' => $this->data]);
    }
    public function view_data($id){
        $this->show = 1;
        $find = ial_upload::find($id);
        $this->container_no = $find->total_container;
        $this->size = $find->size;
        $this->type = $find->type;
        $this->container_reached = $find->reached;

    }
    public function delete_data($id){
        $this->find = ial_upload::find($id);
        $this->find->delete();
    }
}
