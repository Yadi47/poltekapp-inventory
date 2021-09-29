 
   
    <table class="table display responsive nowrap datatable2 table-bordered" id=""> 
        <thead class="thead-dark">
            <th width="2%">No</th>
            <th>Material</th> 
            <th>Unit</th>
            <th>Quantity</th>   
        </thead>
        <tbody>
            
            @foreach ($bom->materialUnits() as $materialUnit)
                <tr>
                <td>{{$loop->iteration}}</td>
                    <td>{{$materialUnit['inventory_material' ?? '']}}</td>
                    <td>{{$materialUnit['unit'] ?? ''}}</td>
                    <td>{{$materialUnit['qty_material']}}</td>

                </tr>
            @endforeach
        </tbody>
    </table>