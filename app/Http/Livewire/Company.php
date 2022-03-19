<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CompanyDetail;
class Company extends Component
{
    public $company_detail;
    public $company_name;
    public $data;
    public function render()
    {
        $this->data = CompanyDetail::find(1);
        $this->company_detail = $this->data->company_detail;
        $this->company_name = $this->data->company_name;
        return view('livewire.company');
    }
    public function store(){
        
        $this->validate([
            'company_name' => 'required',
            'company_detail' => 'required',
           ]);
           $model = CompanyDetail::findOrfail(1);
           $model->company_name = $this->company_name;
           $model->company_detail = $this->company_detail;
           $model->save();
           session()->flash('success','Company Detail Updated Successfully');
    }
}
