<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
class CreateUser extends Component
{
    use WithPagination;
    public $name;
    public $email;
    public $phone;
    public $role;
    public $password;
    protected $data;
    public $delete;
    public $user_id = 0;
    public $status = 0;
    public function render()
    {
        date_default_timezone_set('Asia/Kolkata');
        $this->data = User::latest()->paginate(20);
        return view('livewire.master.create-user',['data' => $this->data]);
    }
    public function updated($field){
        $this->validateOnly($field,[
            'email' => 'required|unique:users',
           ]);
    }
    public function store(){
        $email_validate = '';
        $msg = '';
        if ($this->user_id > 0) {
            $model = User::findOrfail($this->user_id);
            $msg = 'User Updated Successfully';
        }else{
            $model = new User;
            $email_validate = "|unique:users";
            $msg = 'New User Created Successfully';
        }
        $this->validate([
            'name' => 'required',
            'email' => 'required'.$email_validate,
            'password' => 'required',
            'role' => 'required',
            'phone' => 'required|min:10|max:13',
           ]);
           $model->password = Hash::make($this->password);
           $model->name = $this->name;
           $model->email = $this->email;
           $model->phone = $this->phone;
           $model->email_verified_at = Carbon::now()->toDateTimeString();
           $model->type = $this->role;
           $model->status = 1;
           $model->save();
           session()->flash('success',$msg);
           $this->resetFilters();
    }
    public function delete_data($id){
        $this->delete = User::find($id);
        if (Auth::user()->type !== 'super_admin') {
            if ($this->delete->type !== 'admin') {
                $this->delete->delete();
            }else{
                session()->flash('error','You Cant Delete Admin account');
            } 
        }else{
            if (admin_varify($this->delete->type)) {
                session()->flash('error','You Cant Delete '.$this->delete->type.' account');
            }else{
                $this->delete->delete();
            } 
        }
    }
    public function suspend_data($id){
        $model = User::findOrfail($id);
        $msg = "";
        $type = "";
        if (Auth::user()->type !== 'super_admin') {
            if ($model->type !== 'admin') {
                $msg = "";
                if ($model->status == 0) {
                    $model->status = 1;
                    $msg = 'User Aciver Successfully';
                    $type = 'success';
                }else{
                    $model->status = 0;
                    $msg = 'User Suspended Successfully';
                    $type = 'success';
                }
                $model->save();
            }else{
                $msg = 'You Cant suspend Admin account';
                $type = 'error';
            } 
        }else{
            if ($model->type !== 'super_admin') {
                $msg = "";
                if ($model->status == 0) {
                    $model->status = 1;
                    $msg = 'User Aciver Successfully';
                    $type = 'success';
                }else{
                    $model->status = 0;
                    $msg = 'User Suspended Successfully';
                    $type = 'success';
                }
                $model->save();
            }else{
                $msg = 'You Cant suspend Super Admin account';
                $type = 'error';
            } 
        }
        session()->flash($type,$msg);
    }
    public function edit_data($id){
        $this->delete = User::find($id);
        $this->name = $this->delete->name;
        $this->email = $this->delete->email;
        $this->phone = $this->delete->phone;
        $this->role = $this->delete->type;
        $this->user_id = $id;
        
    }
    public function resetFilters(){
        $this->reset(['name','email','password','phone','user_id']);
    }
    public function clear(){
        $this->user_id = 0;
        $this->resetFilters();
    }
}
