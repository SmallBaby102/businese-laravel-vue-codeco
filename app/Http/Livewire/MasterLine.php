<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\LineMaster;
use Livewire\WithPagination;
class MasterLine extends Component
{
    use WithPagination;
    public $coll = 0;
    protected $data;
    public $code;
    public $client_name;
    public $address;
    public $user_id;
    public $city;
    public $pincode;
    public $b_l;
    public $group;
    public $cont_press;
    public $loc;
    public $email;
    public $phone;

    public $v_created;
    public $v_code;
    public $v_client_name;
    public $v_address;
    public $v_city;
    public $v_pincode;
    public $v_b_l;
    public $v_group;
    public $v_cont_press;
    public $v_loc;
    public $v_email;
    public $v_phone;
    public function render()
    { 
        
        date_default_timezone_set('Asia/Kolkata');
        $this->data = LineMaster::latest()->paginate(20);
        return view('livewire.master.master-line',['data' => $this->data]);
    }
    public function updated($field){
        $this->coll = 1;
        $this->validateOnly($field,[
            'code' => 'required|unique:line_masters',
            'email' => 'required|unique:line_masters',
           ]);
    }
    public function store(){
        $email_validate = '';
        $code_validate = '';
        $msg = '';
        if ($this->user_id > 0) {
            $model = LineMaster::findOrfail($this->user_id);
            $msg = 'User Conpany Updated Successfully';
        }else{
            $model = new LineMaster;
            $email_validate = "|unique:line_masters";
            $code_validate = "|unique:line_masters";
            $msg = 'New Conpany Created Successfully';
        }
        $this->validate([
            'code' => 'required'.$code_validate,
            'email' => 'required'.$email_validate,
            'client_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pincode' => 'required',
            'b_l' => 'required',
            'group' => 'required',
            'cont_press' => 'required',
            'loc' => 'required',
            'phone' => 'required|min:10|max:13',
           ]);
           $model->code = $this->code;
           $model->client_name = $this->client_name;
           $model->email = $this->email;
           $model->phone = $this->phone;
           $model->address = $this->address;
           $model->city = $this->city;
           $model->pincode = $this->pincode;
           $model->b_l = $this->b_l;
           $model->company_group = $this->group;
           $model->cont_pers = $this->cont_press;
           $model->loc_code = $this->loc;
           $model->status = 1;
           $model->save();
           session()->flash('success',$msg);
           $this->resetFilters();
    }
    public function resetFilters(){
        $this->coll = 0;
        $this->reset(['code','email','client_name','phone','address','user_id','city','pincode','b_l','group','cont_press','loc']);
    }
    public function delete_data($id){
        $this->delete = LineMaster::find($id);
        $this->delete->delete();
        session()->flash('success','Company Deleted Successfully');
    }
    public function edit_data($id){
        $this->coll = 1;
        $this->delete = LineMaster::find($id);
        $this->code = $this->delete->code;
        $this->client_name = $this->delete->client_name;
        $this->email = $this->delete->email;
        $this->phone = $this->delete->phone;
        $this->address = $this->delete->address;
        $this->city = $this->delete->city;
        $this->pincode = $this->delete->pincode;
        $this->b_l = $this->delete->b_l;
        $this->group = $this->delete->company_group;
        $this->cont_press = $this->delete->cont_pers;
        $this->loc = $this->delete->loc_code;
        $this->status = $this->delete->status;
        $this->user_id = $id;
    }
    public function clear(){
        $this->user_id = 0;
        $this->resetFilters();
        $this->coll = 1;
    }
    // public function view_data($id){
    //     $this->delete = LineMaster::find($id);
    //     $this->v_code = $this->delete->code;
    //     $this->v_client_name = $this->delete->client_name;
    //     $this->v_email = $this->delete->email;
    //     $this->v_phone = $this->delete->phone;
    //     $this->v_address = $this->delete->address;
    //     $this->v_city = $this->delete->city;
    //     $this->v_pincode = $this->delete->pincode;
    //     $this->v_b_l = $this->delete->b_l;
    //     $this->v_group = $this->delete->company_group;
    //     $this->v_cont_press = $this->delete->cont_pers;
    //     $this->v_loc = $this->delete->loc_code;
    //     $this->v_status = $this->delete->status;
    //     $this->v_created = $this->delete->created_at;
    // }
}
