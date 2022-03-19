<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\InContainer;
use App\Models\OutContainer;
use App\Models\CompanyDetail;
use App\Models\Inventory;
use Carbon\Carbon;

class TotatlInOutExport implements 
    FromCollection,
    ShouldAutoSize, 
    WithEvents,
    WithTitle,
    Responsable
{
    use Exportable;
    private $month,$start,$end,$shipping,$out_cell = 0,$repaire_cell = 0,$out_bottum = 0,$in_bottum = 0,$repaire_bottum = 0;
    public function __construct(int $month,string $start,string $end,string $shipping)
    {       
        $this->month = $month;
        $this->start = $start;
        $this->end = $end;
        $this->shipping = $shipping;
    }

    // ALL THE WORK SHEET DATA START
    public function collection()
    {
        // ALL THE WORK SHEETS HEADER START

        $company_detail = CompanyDetail::find(1);
        $in_out_moves = [];
        $push = ['DIGILIYO TECHNOLOGIES'];
        $in_out_moves[] = $push;
        $push = [$company_detail->company_detail.' Contact/Email :'.$company_detail->email];
        $in_out_moves[] = $push;
        $push = [$company_detail->phone];
        $in_out_moves[] = $push;
        $push = [''];
        $end_date_pure = date('d-M-Y',strtotime($this->end));
        $in_out_moves[] = $push;  

        // ALL THE WORK SHEETS HEADER ENDED
           
        // TOTAL IN OUT MOVEMENT WORK SHEET START
        if ($this->month == 1) {
            $push = ['Customer : '.ucfirst(trans($this->shipping))];
            $in_out_moves[] = $push;
            $push = ['Storage Yard : DIGILIYO TECHNOLOGIES'];
            $in_out_moves[] = $push;

            $push = [''];
            $in_out_moves[] = $push;
            $push = [''];
            $in_out_moves[] = $push;

            $in = InContainer::select('container_no','size','container_type','consignee_party','transpoter','vehicle','import_do','in_date','port_from','container_remark')
                        ->whereDate('in_date','>=', $this->start)
                        ->whereDate('in_date','<=', $this->end)
                        ->where('shipping_line',$this->shipping)
                        ->get();
            $out = OutContainer::select('in_containers.container_no','in_containers.size','in_containers.container_type','in_containers.shipping_line','out_containers.out_transpoter'
                        ,'out_containers.out_vehicle','out_containers.export_do','in_containers.in_date','out_containers.out_date','out_containers.port_to','out_containers.remak_note')
                        ->leftJoin("in_containers", "in_containers.id", "=", "out_containers.in_container_id")
                        ->whereDate('out_containers.out_date','>=', $this->start)
                        ->whereDate('out_containers.out_date','<=', $this->end)
                        ->where('shipping_line',$this->shipping)
                        ->get();
            $repaire = Inventory::whereDate('in_date','>=', $this->start)
                        ->whereDate('in_date','<=', $this->end)
                        ->where('shipping_line',$this->shipping)
                        ->where('status','AV')
                        ->get();
                // IN CONTAINER TABLE START
                // dd(count($repaire));
            $push = ['IN CONTAINERS'];
            $in_out_moves[] = $push;
            $push = ['Sr.No.','CONTAINER NO','SIZE/TYPE','CONSIGNEE PARTY','TRANSPORTER','VEHICLE','DO NO','IN DATE','IN TIME','FROM','REMARK'];
            $in_out_moves[] = $push;
            for ($i=0; $i < count($in) ; $i++) { 
                $push = [$i + 1,$in[$i]->container_no,$in[$i]->size.$in[$i]->container_type, $in[$i]->consignee_party,$in[$i]->transpoter,$in[$i]->vehicle,$in[$i]->import_do,date('d-M-Y',strtotime($in[$i]->in_date)), date('h:i A',strtotime($in[$i]->in_date)),$in[$i]->port_from,$in[$i]->container_remark];
                $in_out_moves[] = $push;
            }
            $push = [''];
            $in_out_moves[] = $push;
            $push = [''];
            $in_out_moves[] = $push;

            // IN CONTAINER TABLE ENDED

            // OUT CONTAINER TABLE START
            $push = ['OUT CONTAINERS'];
            $in_out_moves[] = $push;
            $push = ["Sr.No.","CONTAINER NO","SIZE/TYPE","SHIPPER","TRANSPORTER","VEHICLE","DO NO", "IN DATE", "OUT DATE","OUT TIME","TO","REMARKS"];
            $in_out_moves[] = $push;
            for ($i=0; $i < count($out) ; $i++) { 
                $push = [$i + 1 ,$out[$i]->container_no,$out[$i]->size.$out[$i]->container_type, $out[$i]->shipping_line,$out[$i]->out_transpoter,$out[$i]->out_vehicle, $out[$i]->export_do, date('d-M-Y',strtotime($out[$i]->in_date)),date('d-M-Y',strtotime($out[$i]->out_date)) , date('h:i',strtotime($out[$i]->out_date)),$out[$i]->port_to,$out[$i]->remak_note];
                $in_out_moves[] = $push;
            }
            $push = [''];
            $in_out_moves[] = $push;
            $push = [''];
            $in_out_moves[] = $push;
            // OUT CONTAINER TABLE ENDED

            // REPAIRE COMPLETED TABLE START
            $push = ['REPAIRE COMPLETED'];
            $in_out_moves[] = $push;
            $push = ["Sr.No." ,"CONTAINER NO","SIZE/TYPE","IN DATE","APPROVAL DATE","VEHICLE","AV DATE","IMPORT DO","IN DATE","STATUS"];
            $in_out_moves[] = $push;

            for ($i=0; $i < count($repaire); $i++) { 
                $push = [$i + 1 ,$repaire[$i]->container_no,$repaire[$i]->size.$repaire[$i]->container_type,date('d-M-Y',strtotime($repaire[$i]->in_date)),date('d-M-Y',strtotime($repaire[$i]->approval_date)), $repaire[$i]->vehicle, date('d-M-Y',strtotime($repaire[$i]->av_date)), $repaire[$i]->import_do,date('d-M-Y',strtotime($repaire[$i]->in_date)) , $repaire[$i]->status];
                $in_out_moves[] = $push;
            }
            // REPAIRE COMPLETED TABLE ENDED
            return new collection(
                $in_out_moves
            );
            
        }
        // TOTAL IN OUT MOVEMENT WORK SHEET ENDED

        // INVENTORY WORKSHEET START
        if ($this->month == 2) {
            $invetory_data = Inventory::whereDate('in_date','<=', $this->end)
                                ->where('shipping_line',$this->shipping)
                                ->get();
            $push = [''=>'Customer :'.ucfirst(trans($this->shipping))];
            $in_out_moves[] = $push;
            $push = [''=>'Storage Yard : DIGILIYO TECHNOLOGIES'];
            $in_out_moves[] = $push;
            $push = [''=>'Report Inventory As On Date : '.$end_date_pure];
            $in_out_moves[] = $push;
            $push = [''=>''];
            $in_out_moves[] = $push;
            $push = [ 'Sr.No.','CONTAINER NO','SIZE/TYPE','GROSS WEIGHT','TARE WEIGHT','IN DATE','IN TIME','STATUS','CONTAINER IN REMARK','CONSIGNEE PARTY','TRANSPORTER','VEHICLE NO','ESTIMATE DATE','ESTIMATE AMOUNT','APPROVAL DATE','APPROVAL AMOUNT','AV DATE','NO OF DAYS IN DEPOT','NO OF DAYS FROM APPROVED DATE','PLACE IN','MFG DATE'];
            $in_out_moves[] = $push;

            for ($i=0; $i < count($invetory_data) ; $i++) { 
                $est_date = '';
                $est_amt = '';
                $app_date = '';
                $app_amt = '';
                $av_date = '';
                $no_of_days_app = '';
                if ($invetory_data[$i]->estimate_date !== null) {
                    $est_date = date('d-M-Y',strtotime($invetory_data[$i]->estimate_date));
                }
                if($invetory_data[$i]->estimate_amt !== null){
                    $est_amt = $invetory_data[$i]->estimate_amt;
                }
                if ($invetory_data[$i]->approval_date !== null) {
                    $app_date = date('d-M-Y',strtotime($invetory_data[$i]->approval_date));
                    $new_app = strtotime(Carbon::now()) - strtotime($invetory_data[$i]->approval_date);
                    $no_of_days_app = round($new_app / 86400);
                }
                if ($invetory_data[$i]->approval_amt !== null) {
                    $app_amt = $invetory_data[$i]->approval_amt;
                }
                if ($invetory_data[$i]->av_date !== null) {
                    $av_date = date('d-M-Y',strtotime($invetory_data[$i]->av_date));
                }
                $no_of_days_in = strtotime(Carbon::now()) - strtotime($invetory_data[$i]->in_date);
                $diff = round($no_of_days_in / 86400);
                $push = [$i + 1,$invetory_data[$i]->container_no,$invetory_data[$i]->size.$invetory_data[$i]->container_type,$invetory_data[$i]->max_gross,$invetory_data[$i]->tare,date('d-M-Y',strtotime($invetory_data[$i]->in_date)),date('h:i A',strtotime($invetory_data[$i]->in_date)),$invetory_data[$i]->status,$invetory_data[$i]->container_remark,$invetory_data[$i]->consignee_party,$invetory_data[$i]->transpoter,$invetory_data[$i]->vehicle,$est_date,$est_amt,$app_date,$app_amt,$av_date,$diff,$no_of_days_app,$invetory_data[$i]->place,date('d-M-Y',strtotime($invetory_data[$i]->mfg_date))];
                $in_out_moves[] = $push;
            }
            return new collection(
                $in_out_moves
            );
        }
        // INVENTORY WORKSHEET ENDED

        // STOCK MOVEMENT WORK SHEET START
        if ($this->month == 3) {
                $in_out_moves = [];
                $push = ['DIGILIYO TECHNOLOGIES'];
                $in_out_moves[] = $push;
                $push = [$company_detail->company_detail.' Contact/Email :'.$company_detail->email];
                $in_out_moves[] = $push;
                $push = [$company_detail->phone];
                $in_out_moves[] = $push;
                $push = [''];
                $in_out_moves[] = $push;
                $push = [''];
                $in_out_moves[] = $push;
                $push = ['STOCK STATEMENT AS ON DATE : '.$end_date_pure];
                $in_out_moves[] = $push;
                $push = [''];
                $in_out_moves[] = $push;
                $push = ['Size/Type','Opening','Turn IN','Turn OUT','Closing','AWAITING ESTIMATE','AWAITING APPROVAL','UNDER REPAIR','AVAILABLE','Total '];
                $in_out_moves[] = $push;
                $all_data = [];
                $size = [];
                $type = [];
                $num = 0;
                $in_out_summary = InContainer::leftJoin("out_containers", "out_containers.in_container_id", "=", "in_containers.id")
                                    ->where('in_containers.shipping_line',$this->shipping)
                                    ->whereDate('in_containers.in_date','>=',$this->start)
                                    ->whereDate('in_containers.in_date','<=',$this->end)
                                    ->get();
                for ($i=0; $i <count($in_out_summary) ; $i++) { 
                    $turnin = 0;
                    $turnout = 0;
                    $closing = 1;
                    $ae = 0;$ap = 0;$ur = 0;$av = 0;
                    if (date('Y-m-d',strtotime($in_out_summary[$i]->in_date)) == date('Y-m-d',strtotime(Carbon::now()))) {
                        $turnin = 1;
                    }
                    if (date('Y-m-d',strtotime($in_out_summary[$i]->out_date)) == date('Y-m-d',strtotime(Carbon::now()))) {
                        
                        $turnout = 1;
                    }
                    if($in_out_summary[$i]->out_date !== null){
                        $num++;
                        $closing = 0;
                    }
                    if ($in_out_summary[$i]->status == 'AE') {
                        $ae = 1;
                    }
                    if ($in_out_summary[$i]->status == 'AP') {
                        $ap = 1;
                    }
                    if ($in_out_summary[$i]->status == 'UR') {
                        $ur = 1;
                    }
                    if ($in_out_summary[$i]->status == 'AV') {
                        $av = 1;
                    }
                    if (in_array($in_out_summary[$i]->size,$size)) {
                        if (in_array($in_out_summary[$i]->size.'-'.$in_out_summary[$i]->container_type,$type)) {
                            $push = ['opening' => +1];
                            $opening = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['opening'] + 1;
                            $turn_in_inc = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['turnin'] + $turnin;
                            $turn_out_inc = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['turnout'] + $turnout;
                            $ae_inc = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['AE'] + $ae;
                            $ap_inc = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['AP'] + $ap;
                            $ur_inc = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['UR'] + $ur;
                            $av_inc = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['AV'] + $av;
                            $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['opening'] = $opening;
                            $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['turnin'] = $turn_in_inc;
                            $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['turnout'] = $turn_out_inc;
                            if($in_out_summary[$i]->out_date !== null){
                                $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['closing'] -= $closing;
                            } else {
                                $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['closing'] += $closing;
                            }
                            $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['total'] = $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['closing'];
                            $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['AE'] = $ae_inc;
                            $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['AP'] = $ap_inc;
                            $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['UR'] = $ur_inc;
                            $all_data[$in_out_summary[$i]->size][$in_out_summary[$i]->container_type]['AV'] = $av_inc;
                        }else{
                            $type[] = $in_out_summary[$i]->size.'-'.$in_out_summary[$i]->container_type;
                            $push = [$in_out_summary[$i]->container_type
                                        => ['opening' => 1,'turnin' => $turnin,'turnout' => $turnin,'closing' => $closing,'AE' => $ae,'AP' => $ap,'UR' => $ur,'AV' => $av,'total' => $closing]
                                    ];
                            $all_data[$in_out_summary[$i]->size] += $push;
                        }
                    }else{
                        $size[] = $in_out_summary[$i]->size;
                        $type[] = $in_out_summary[$i]->size.'-'.$in_out_summary[$i]->container_type;
                        $all_data += [$in_out_summary[$i]->size
                                        => [$in_out_summary[$i]->container_type
                                            => ['opening' => 1,'turnin' => $turnin,'turnout' => $turnout,'closing' => $closing,'AE' => $ae,'AP' => $ap,'UR' => $ur,'AV' => $av,'total' => $closing]
                                            ]
                                    ];
                    }
                }
            $all_total = ['opening' => 0,'turnin' => 0,'turnout' => 0,'closing' => 0,'AE' => 0,'AP' => 0,'UR' => 0,'AV' => 0,'total' => 0];
            
            foreach($all_data as $key => $val) { 
                foreach($val as $k => $v) { 
                    $all_total['opening'] += $all_data[$key][$k]['opening'];
                    $all_total['turnin'] +=  $all_data[$key][$k]['turnin'];
                    $all_total['turnout'] +=  $all_data[$key][$k]['turnout'];
                    $all_total['closing'] +=  $all_data[$key][$k]['closing'];
                    $all_total['AE'] +=  $all_data[$key][$k]['AE'];
                    $all_total['AP'] +=  $all_data[$key][$k]['AP'];
                    $all_total['UR'] +=  $all_data[$key][$k]['UR'];
                    $all_total['AV'] +=  $all_data[$key][$k]['AV'];
                    $all_total['total'] +=  $all_data[$key][$k]['total'];
                }
            }
            for ($i=0; $i < count($type) ; $i++) { 
                $both = explode('-',$type[$i]);
                $first = current($both);
                $second = end($both);
                $push = [$first.$second,$all_data[$first][$second]['opening'],$all_data[$first][$second]['turnin'],$all_data[$first][$second]['turnout'],$all_data[$first][$second]['closing'],$all_data[$first][$second]['AE'],$all_data[$first][$second]['AP'],$all_data[$first][$second]['UR'],$all_data[$first][$second]['AV'],$all_data[$first][$second]['total']];
                $in_out_moves[] = $push;
            }
            $last = ['Total', $all_total['opening'], $all_total['turnin'], $all_total['turnout'],$all_total['closing'],$all_total['AE'],$all_total['AP'],$all_total['UR'],$all_total['AV'],$all_total['total']];
            $in_out_moves[] = $last;
           
            return new collection(
                $in_out_moves
            ); 
        }
        // STOCK MOVEMENT WORK SHEET ENDED


        // IN DATA WORK SHEET START
        if ($this->month == 4) {
            $in_data =  InContainer::whereDate('in_date','<=', $this->end)
                                    ->where('shipping_line',$this->shipping)
                                    ->get();
            $push = ['In Movement AS ON DATE : '.$end_date_pure];
            $in_out_moves[] = $push;
            $push = [''];
            $in_out_moves[] = $push;
            $push = ['Sr.No.','CONTAINER NO' ,'SIZE/TYPE','CONSIGNEE PARTY','TRANSPORTER' ,'VEHICLE','DO NO','IN DATE','IN TIME','PORT FROM'];
            $in_out_moves[] = $push;
            for ($i=0; $i < count($in_data) ; $i++) { 
            $push = [$i + 1,$in_data[$i]->container_no,$in_data[$i]->size.$in_data[$i]->container_type,$in_data[$i]->consignee_party,$in_data[$i]->transpoter,$in_data[$i]->vehicle,$in_data[$i]->import_do,date('d-M-Y',strtotime($in_data[$i]->in_date)),date('h:i A',strtotime($in_data[$i]->in_date)),$in_data[$i]->port_from];
            $in_out_moves[] = $push;
            }
            return new collection(
                $in_out_moves
            );

        }
        // IN DATA WORK SHEET ENDED

        // OUT DATA WORK SHEET START

        else{
            $out_data = OutContainer::leftJoin("in_containers", "in_containers.id", "=", "out_containers.in_container_id")
                                    ->whereDate('out_containers.out_date','<=', $this->end)
                                    ->where('shipping_line',$this->shipping)
                                    ->get();
            $push = ['OUT Movement AS ON DATE : '.$end_date_pure];
            $in_out_moves[] = $push;
            $push = [''];
            $in_out_moves[] = $push;
            $push = ['Sr.No.','CONTAINER NO','SIZE/TYPE','SHIPPING LINE','TRANSPORTER','VEHICLE','DO NO','IN DATE','IN TIME' ,'OUT DATE','OUT TIME' ,'PORT TO','REMARK NOTE'];
            $in_out_moves[] = $push;
            for ($i=0; $i < count($out_data) ; $i++) { 
            $push = [ $i + 1,$out_data[$i]->container_no,$out_data[$i]->size.$out_data[$i]->container_type,$out_data[$i]->shipping_line,$out_data[$i]->out_transpoter,$out_data[$i]->out_vehicle,$out_data[$i]->export_do,date('d-M-Y',strtotime($out_data[$i]->in_date)),date('h:i A',strtotime($out_data[$i]->in_date)),date('d-M-Y',strtotime($out_data[$i]->out_date)),date('h:i A',strtotime($out_data[$i]->out_date)), $out_data[$i]->port_to,$out_data[$i]->remak_note];
            $in_out_moves[] = $push;
            }
            return new collection(
                $in_out_moves
            );
        }
        // IN DATA WORK SHEET ENDED
    }

    // ALL THE WORK SHEET DATA ENDED

    // ALL THE WORK SHEET STYLING AND SPACING START
    public function registerEvents(): array
    {
        $in = InContainer::whereDate('in_date','>=', $this->start)
                            ->whereDate('in_date','<=', $this->end)
                            ->where('shipping_line',$this->shipping)
                            ->get();
        $out = OutContainer::leftJoin("in_containers", "in_containers.id", "=", "out_containers.in_container_id")
                        ->whereDate('out_containers.out_date','>=', $this->start)
                        ->whereDate('out_containers.out_date','<=', $this->end)
                        ->where('shipping_line',$this->shipping)
                        ->get();
        $out_cell = count($in) + 14;
        $this->out_cell = 'A'.$out_cell.':L'.$out_cell;
        $repaire = Inventory::whereDate('in_date','>=', $this->start)
                        ->whereDate('in_date','<=', $this->end)
                        ->where('shipping_line',$this->shipping)
                        ->where('status','AV')
                        ->get();
        $re_cell = 4 + $out_cell + count($out);
        $this->repaire_cell = 'A'.$re_cell.':J'.$re_cell;
        $in_bottum = $out_cell - 3;
        $this->in_bottum =  'A'.$in_bottum.':K'.$in_bottum;
        $out_bottum = $re_cell - 3;
        $this->out_bottum =  'A'.$out_bottum.':L'.$out_bottum;
        $repaire_bottum = $re_cell + count($repaire) + 1;
        $this->repaire_bottum =  'A'.$repaire_bottum.':J'.$repaire_bottum;
        if ($this->month == 1) {
            return [
                AfterSheet::class => function(AfterSheet $event){

                    $event->sheet->mergeCells('A1:B1');
                    $event->sheet->mergeCells('A2:L2');
                    $event->sheet->mergeCells('A5:C5');
                    $event->sheet->mergeCells('A6:C6');
                    $event->sheet->getStyle('A10:K10')->applyFromArray([
                        'font' =>[
                            'bold' => true
                        ]
                    ])
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('c5f1fe');

                    $event->sheet->getStyle($this->out_cell)->applyFromArray([
                        'font' =>[
                            'bold' => true
                        ]
                    ])
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('c5f1fe');

                    $event->sheet->getStyle($this->in_bottum)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('c5f1fe');
                            
                    $event->sheet->getStyle($this->out_bottum)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('c5f1fe');

                    $event->sheet->getStyle($this->repaire_bottum)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('c5f1fe');

                    $event->sheet->getStyle($this->repaire_cell)->applyFromArray([
                        'font' =>[
                            'bold' => true
                        ]
                    ])
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('c5f1fe');

                }
            ];
        }
        if ($this->month == 2) {
            return [
                AfterSheet::class => function(AfterSheet $event){
                    $event->sheet->mergeCells('A1:B1');
                    $event->sheet->mergeCells('A2:J2');
                    $event->sheet->mergeCells('A6:C6');
                    $event->sheet->mergeCells('A5:C5');
                    $event->sheet->mergeCells('A7:D7');
                    $event->sheet->getStyle('A9:U9')->applyFromArray([
                        'font' =>[
                            'bold' => true
                        ]
                    ])
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('c5f1fe');
                }
            ];
        }
        if ($this->month == 3) {
            return [
                AfterSheet::class => function(AfterSheet $event){
                    $event->sheet->mergeCells('A1:c1');
                    $event->sheet->mergeCells('A2:M2');
                    $event->sheet->mergeCells('A6:E6');
                    $event->sheet->getStyle('A8:J8')->applyFromArray([
                        'font' =>[
                            'bold' => true
                        ]
                    ])
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('c5f1fe');

                }
            ];
        }
        if ($this->month == 4) {
            return [
                AfterSheet::class => function(AfterSheet $event){
                    $event->sheet->mergeCells('A1:B1');
                    $event->sheet->mergeCells('A2:M2');
                    $event->sheet->mergeCells('A5:C5');
                    $event->sheet->getStyle('A7:J7')->applyFromArray([
                        'font' =>[
                            'bold' => true
                        ]
                    ])
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('c5f1fe');
                }
            ];
        }
        if ($this->month == 5) {
            return [
                AfterSheet::class => function(AfterSheet $event){
                    $event->sheet->mergeCells('A1:B1');
                    $event->sheet->mergeCells('A2:M2');
                    $event->sheet->mergeCells('A5:D5');
                    $event->sheet->getStyle('A7:M7')->applyFromArray([
                        'font' =>[
                            'bold' => true
                        ]
                    ])
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('c5f1fe');
                }
            ];
        }
        
    }
    // ALL THE WORK SHEET STYLING AND SPACING ENDED

    // ALL THE WORK SHEET TITLE START
    public function title(): string
    {
        if ($this->month == 1) {
            return 'IN OUT MOVEMENT';
        }
        if ($this->month == 2) {
            return 'INVENTORY';
        }
        if ($this->month == 3) {
            return 'STOCK MOVEMENT';
        }
        if ($this->month == 4) {
            return 'IN DATA';
        }
        if ($this->month == 5) {
            return 'OUT DATA';
        }
    }

    // ALL THE WORK SHEET TITLE ENDED
}
