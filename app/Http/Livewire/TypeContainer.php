<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ContainerType;
use Livewire\WithPagination;
class TypeContainer extends Component
{
    use WithPagination;
    protected $data;
    public $size;
    public $type;
    public $iso;
    public $description;
    public $delete;
    public $user_id = 0;
    public function render()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->data = ContainerType::latest()->paginate(20);
        return view('livewire.master.type-container',['data' => $this->data]);
    }
    public function store(){
        $msg = '';
        $unique = "";
        if ($this->user_id > 0) {
            $model = ContainerType::findOrfail($this->user_id);
            $msg = 'Status Master Updated Successfully';
        }else{
            $model = new ContainerType;
            $msg = 'New Status Master Created Successfully';
        }
        $this->validate([
            'size' => 'required',
            'type' => 'required',
            'description' => 'required'.$unique,
            'iso' => 'required'.$unique,
           ]);
           $model->size = $this->size;
           $model->type = $this->type;
           $model->iso_code = $this->iso;
           $model->description = $this->description;
           $model->save();
           session()->flash('success',$msg);
           $this->resetFilters();
    }
    public function delete_data($id){
        $this->delete = ContainerType::find($id);
        $this->delete->delete();
        session()->flash('success','Container Type Deleted Successfully');
    }
    public function resetFilters(){
        $this->reset(['iso','size','type','user_id','description']);
    }
    public function edit_data($id){
        $this->delete = ContainerType::find($id);
        $this->size = $this->delete->size;
        $this->type = $this->delete->type;
        $this->description = $this->delete->description;
        $this->iso = $this->delete->iso_code;
        $this->user_id = $id;
    }
    public function clear(){
        $this->user_id = 0;
        $this->resetFilters();
    }
}
