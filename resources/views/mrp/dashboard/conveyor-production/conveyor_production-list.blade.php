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
            <th scope="col">Machine</th> 
            <th scope="col">Qty Out</th> 
            <th scope="col">PIC</th>
            <th scope="col">Shift</th>
        </tr>
    </thead>
    <tbody>
        
         @foreach ($material_outs as $material_out)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$material_out->inventoryMaterialList->material->material_name ?? "N/A"}}</td>
        <td>{{$material_out->inventoryMaterialList->material->part_number ?? "N/A"}}</td>
        <td>{{$material_out->machine->machine_name ?? "N/A"}}</td>
        <td>{{$material_out->material_outgoing ?? "N/A"}}</td>
        <td>{{$material_out->employee->employee_name ?? "N/A"}}</td>
        <td>{{$material_out->employee->shift->shift_name ?? "N/A"}}</td>
        
    </tr>
    @endforeach
    </tbody>
</table>

