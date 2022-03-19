<div>
    
    <?php
    
        if($result > 0 ){
            ?>
            <script>
                swal('{{$message}}', {
                    icon: "error",
                });

            </script>
            <?php
        }
        
    ?>
    <div class="card text-left">
      <div class="card-body">
        <div class="form-group row">
            <div class="col-2">
                <label for="datepicker">Select Start Date</label>
                <input class="form-control" wire:model='select_date' type="date" name="" id="datepicker">
            </div>
            <div class="col-2">
                <button class="btn btn-info mt-4" wire:click='search'>Search</button>
                <div wire:loading wire:target="search" class="spinner-border text-primary mt-4" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
      </div>
    </div>
    <div class="card text-left">
      <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Rows/Cells</th>
                    @foreach ($container_type as $item)
                    <th>{{$item->size.$item->type}}</th>
                    @endforeach
                    <th>Total</th>
                    <th>Total Tues</th>   
                </tr>
            </thead>
            <tbody>
                
                @foreach ($shipping as $item)
                    <th>{{$item->client_name}}</th>
                    @if ($data !== null)
                        @if (in_array($item->client_name,$client))
                            @php
                                $total = 0;
                                $size_20 = 0;
                                $size_40 = 0;
                                for($i = 0; $i < count($size); $i++){
                                    if (array_key_exists($type[$i],$data[$item->client_name][$size[$i]])) {
                                        echo "<th>".$data[$item->client_name][$size[$i]][$type[$i]]."</th>";
                                        $total += $data[$item->client_name][$size[$i]][$type[$i]];
                                        if ($size[$i] == 40) {
                                            $size_40++;
                                        }else{
                                            $size_20++;
                                        }
                                    }else{
                                        echo "<th>0</th>";
                                    }
                                }
                                $tues = $size_40 * 2;
                                echo "<th>".$total."</th>";
                                echo "<th>".$size_20 + $tues."</th>";
                            @endphp
                        @endif
                    @endif
                @endforeach
            </tbody>
        </table>
        {{-- <div class="row">{{$data->links()}}</div> --}}
      </div>
    </div>

    
</div>
