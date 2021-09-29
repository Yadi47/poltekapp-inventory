<style>
    .table {
        overflow: auto !important;
    }

</style>
<table class="table lms_table_active3" id=""> 
    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">Part Name</th>
            <th scope="col">Part Number</th>
            <th scope="col">Qty</th>
            <th scope="col">Date</th>
            <th scope="col">PIC</th>
            <th scope="col">Description</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($product_sortirs as $product)
        {{-- {{ dd($material_sortir->inventoryMaterialList) }} --}}
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{$product->inventoryProductList->product->part_name}}</td>
        <td>{{$product->inventoryProductList->product->part_number}}</td>
        <td>{{$product->qty_ok}}</td>
        <td>{{$product->date}}</td>
        <td>{{$product->employee->employee_name}}</td>
        <td>{{$product->description}}</td>
        
    </tr>
    @endforeach

    </tbody>
</table>