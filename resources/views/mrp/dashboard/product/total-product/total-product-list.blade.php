
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
            <th scope="col">Qty Sortir</th> 
            <th scope="col">PIC</th>
            <th scope="col">Shift</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach ($product_sortirs as $product)
            
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{$product->inventoryProductList->product->part_name ?? "N/A"}}</td>
        <td>{{$product->inventoryProductList->product->part_number ?? "N/A"}}</td>
        <td>{{$product->qty_sortir ?? "N/A"}}</td>
        <td>{{$product->employee->employee_name ?? "N/A"}}</td>
        <td>{{$product->employee->shift->shift_name ?? "N/A"}}</td>
        
    </tr>
    @endforeach

    </tbody>
</table>

