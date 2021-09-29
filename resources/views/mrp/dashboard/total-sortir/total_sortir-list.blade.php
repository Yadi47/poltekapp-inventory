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
            <th scope="col">Qty Recheck</th> 
            <th scope="col">PIC</th>
            <th scope="col">Shift</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach ($material_sortirs as $material_sortir)
            
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{$material_sortir->inventoryMaterialList->material->material_name ?? "N/A"}}</td>
        <td>{{$material_sortir->inventoryMaterialList->material->part_number ?? "N/A"}}</td>
        <td>{{$material_sortir->qty_sortir ?? "N/A"}}</td>
        <td>{{$material_sortir->employee->employee_name ?? "N/A"}}</td>
        <td>{{$material_sortir->employee->shift->shift_name ?? "N/A"}}</td>
        
    </tr>
    @endforeach

    </tbody>
</table>