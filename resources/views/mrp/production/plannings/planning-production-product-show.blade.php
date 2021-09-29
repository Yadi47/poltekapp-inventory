
    <table class="table display responsive nowrap datatable2 table-bordered" id=""> 
        <thead class="thead-dark">
            <th width="2%">No</th>
            <th>Product</th> 
            <th>Part Number</th>
            <th>BOM</th>
            <th>Quantity</th>
        </thead>
        {{-- <tbody> {{dd($planning->product->bom->bom_name)}} --}}
            @foreach ($prod as $product)
            {{-- {{dd($product)}} --}}
                <tr>
                <td>{{$loop->iteration}}</td> 
                <td>{{$product->part_name}} </td>
                <td>{{$product->part_number}}</td> 
                <td>{{$product->bom_name}}</td> 
                <td>{{$product->quantity}}</td>

                </tr>
            @endforeach
        </tbody>
    </table>