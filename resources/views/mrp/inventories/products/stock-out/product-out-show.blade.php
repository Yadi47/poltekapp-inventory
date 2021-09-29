 
    <table class="table display responsive nowrap datatable2 table-bordered" id=""> 
        <thead class="thead-dark">
            <th width="2%">No</th>
            <th>Part Name</th>   
            <th>Part Number</th>   
            <th>Quantity</th>   
            <th>Unit</th>   
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            
            @foreach ($detail_product as $product)
                <tr>
                <td>{{$no++}}</td>
                    <td>{{$product->part_name}}</td>
                    <td>{{$product->part_number}}</td>
                    <td>{{$product->quantity}}</td>
                    <td>{{$product->unit}}</td>
                    {{-- <td>{{$product->inventoryShipment->inventoryProductList->product->part_name}}</td>
                    <td>{{$product->inventoryShipment->inventoryProductList->product->part_number}}</td>
                    <td>{{$product->quantity}}</td>
                    <td>{{$product->unit}}</td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
     