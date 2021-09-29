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
        @foreach ($material_sortirs as $material_sortir)
        {{-- {{ dd($material_sortir->inventoryMaterialList) }} --}}
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{$material_sortir->inventoryMaterialList->material->material_name ?? 'N/A'}}</td>
        <td>{{$material_sortir->inventoryMaterialList->material->part_number ?? 'N/A'}}</td>
        <td>{{$material_sortir->qty_ok}}</td>
        <td>{{$material_sortir->date}}</td>
        <td>{{$material_sortir->employee->employee_name}}</td>
        <td>{{$material_sortir->description}}</td>
        
    </tr>
    @endforeach

    </tbody>
</table>