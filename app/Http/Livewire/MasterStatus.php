<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\StatusMaster;
use Livewire\WithPagination;
class MasterStatus extends Component
{ 
    use WithPagination;
    protected $data;
    public $status_detail;
    public $status_code;
    public $priority;
    public $delete;
    public $user_id = 0;
    public function render()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->data = StatusMaster::latest()->paginate(20);
        return view('livewire.master.master-status',['data' => $this->data]);
    }
    public function store(){
        $msg = '';
        $unique = "";
        if ($this->user_id > 0) {
            $model = StatusMaster::findOrfail($this->user_id);
            $msg = 'Status Master Updated Successfully';
        }else{
            $model = new StatusMaster;
            $unique = "|unique:status_masters";
            $msg = 'New Status Master Created Successfully';
        }
        $this->validate([
            'status_detail' => 'required',
            'status_code' => 'required',
            'priority' => 'required'.$unique,
           ]);
           $model->status_detail = $this->status_detail;
           $model->status_code = $this->status_code;
           $model->priority = $this->priority;
           $model->save();
           session()->flash('success',$msg);
           $this->resetFilters();
    }
    public function delete_data($id){
        $this->delete = StatusMaster::find($id);
        $this->delete->delete();
        session()->flash('success','Status Master Deleted Successfully');
    }
    public function resetFilters(){
        $this->reset(['status_detail','status_code','priority','user_id']);
    }
    public function edit_data($id){
        $this->delete = StatusMaster::find($id);
        $this->status_detail = $this->delete->status_detail;
        $this->status_code = $this->delete->status_code;
        $this->priority = $this->delete->priority;
        $this->user_id = $id;
    }
    public function clear(){
        $this->user_id = 0;
        $this->resetFilters();
    }
}
