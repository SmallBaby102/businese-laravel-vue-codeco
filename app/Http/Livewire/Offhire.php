<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\OffhireImport;
use App\Models\Inventory;
use App\Models\LineMaster;
class Offhire extends Component
{
    use WithFileUploads;
    public $file,$shipping,$result,$lines,$ship;
    protected $message = [],$data = [];
    public function render()
    {
        return view('livewire.offhire');
    }
    public function upload(){
        $off = (new OffhireImport)->toArray($this->file);
        $line = Inventory::where('container_no','=',$off[0][0]['container_no'])
                        ->where('size','=',$off[0][0]['size'])
                        ->where('container_type','=',$off[0][0]['type'])
                        ->where('status','=',$off[0][0]['status'])
                        ->first();
        $container = [];
        if($line !== null){
            foreach ($off as $key => $value) {
                foreach ($value as $k => $v) {
                    if ($v['container_no'] !== null) {
                        if (Inventory::where('container_no','=',$v['container_no'])->where('shipping_line','=',$line->shipping_line)->where('size','=',$v['size'])->where('container_type','=',$v['type'])->where('status','=',$v['status'])->first()) {
                            if (in_array($v['container_no'],$container)) {
                                $this->result = 1;
                                $this->message[] = $v['container_no'] . ' Duplicate Container Number';
                            } else {
                                $container[] = $v['container_no'];
                                $this->data[] = ['container_no' => $v['container_no'],'size' => $v['size'], 'type' => $v['type'], 'status' => $v['status']]; 
                            }
                        } else {
                            $this->result = 1;
                            $this->message[] = $v['container_no'].' This Container Not Exsit In Inventory Or This Shipping Line Is Defferent from Other Or Size , Type , Status Not Match From Inventory';
                        }
                    }
                }
            }
        }else{
            $this->result = 1;
            $this->message = [$off[0][0]['container_no'].' Not Found In Inventory'];
        }
        if ($this->result == 0) {
            $this->shipping = $line->shipping_line;
            $this->ship = LineMaster::all();
        }

    }
}
