            <div class=" mb_30 ">
                
                    <div class="table-responsive" style="padding-bottom:10px;" id="style-1">
                        <table class="report table-bordered"
                            style="font-size: 11px; table-layout: auto !important;">
                            <tbody>
                                <tr>
                                    <td width="100px" class="text-center" style="font-size:12px;font-weight: 800">Name</td>
                                    <td width="100px" class="text-center" style="font-size:12px;font-weight: 800">Part No.</td>
                                    <td width="100px" class="text-center" style="font-size:12px;font-weight: 800">Pieces/Box</td>
                                    {!! $head_date !!}
                                    
                                </tr>
                                @foreach ($column as $data)
                                {{-- {{ dd($column) }} --}}
                                <tr>
                                    <td>{{$data['bom_name']}}</td>
                                    <td>{{$data['part_number']}}</td>
                                    <td>{{$data['price'] }}</td>
                                    {{-- <td>{{ $data['sum_value']['qty_material'] }}</td> --}}
                                    {{-- <td>{{($data['price'] * $data['qty_material'])}}</td> --}}
                                    {!! $body_date!!}  

                                </tr>
                            @endforeach
                            
                            </tbody>
                        </table>

                        
                    </div>
                    <br>

                </div>