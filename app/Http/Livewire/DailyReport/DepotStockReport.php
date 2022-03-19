<?php

namespace App\Http\Livewire\DailyReport;

use Livewire\Component;
use App\Models\ContainerType;
use App\Models\LineMaster;
use App\Models\InContainer;
class DepotStockReport extends Component
{
    public $select_date,$shipping,$container_type;
    public $message;
    public $result = 0;
    public $data;
    public $size;
    public $type;
    public $client;
    public function render()
    {
        $this->shipping = LineMaster::all();
        $this->container_type = ContainerType::all();
        return view('livewire.daily-report.depot-stock-report');
    }
    public function search(){
        if ($this->select_date != null) {
            $data = InContainer::whereDate('created_at','=', $this->select_date)->get();
            $all_data = [];
            $new_size = [];
            $new_type = [];
            $client = [];
            $size = [];
            $type = [];
            foreach ($this->container_type as $c_detail) {
                $size[] = $c_detail->size;                
                $type[] = $c_detail->type;
            }
            foreach ($this->shipping as $ship) {
                foreach ($data as $con){
                    if ($ship->client_name == $con->shipping_line){
                       if (in_array($con->shipping_line,$client)) {
                           if (in_array($con->size,$new_size)) {
                                if (in_array($con->size.$con->container_type,$new_type)) {
                                    $all_data[$con->shipping_line][$con->size][$con->container_type]++;
                                }else{
                                    $new_type[] = $con->size.$con->container_type;
                                    $push = ["$con->container_type" => 1];
                                    $all_data[$con->shipping_line][$con->size] += $push;
                                }
                           }else{
                               $push = [
                                   "$con->size" => [
                                       "$con->container_type" => 1
                                   ]
                               ];
                               $new_size[] = $con->size;
                               $new_type[] = $con->size.$con->container_type;
                               $all_data[$con->shipping_line] += $push;
                           }
                       }else{
                        $new_size[] = $con->size;
                        $new_type[] = $con->size.$con->container_type;
                        $client[] = $con->shipping_line;
                        $all_data +=[
                            "$con->shipping_line" =>[
                                "$con->size" =>[
                                    "$con->container_type" => 1
                                ]
                            ]
                        ]; 
                       }
                    }
                }
            }
            $this->data = $all_data;
            $this->size = $size;
            $this->type = $type;
            $this->client = $client;
        }else{
            $this->result = 1;
            $this->message = 'please select start date and end date first';
        }
    }
}
