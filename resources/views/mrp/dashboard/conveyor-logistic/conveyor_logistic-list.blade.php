<style>
    /* .table {
        overflow: auto !important;
    } */

</style>
<div class="QA_table mb_30">
    <table class="table lms_table_active3" id=""> 
        <thead class="thead-dark">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Part Name</th>
                <th scope="col">Part Number</th>
                <th scope="col">Incoming</th> 
                {{-- <th scope="col">Sortir</th>  --}}
                <th scope="col">PIC</th>
                <th scope="col">Shift</th>
                <th scope="col">Tanggal Masuk Conveyor</th>
                {{-- <th scope="col">Part Name</th> --}}
            </tr>
        </thead>    
        <tbody>
            
             @foreach ($material_incomings as $material_incoming)
             {{-- {{ dd($material_incoming) }} --}}
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$material_incoming->inventoryMaterialList->material->material_name ?? "N/A"}}</td>
            <td>{{$material_incoming->inventoryMaterialList->material->part_number ?? "N/A"}}</td>
            <td>{{$material_incoming->material_incoming ?? "N/A"}}</td>
            {{-- <td>{{$material_incoming->sortir ?? "0"}}</td> --}}
            <td>{{$material_incoming->employee->employee_name ?? "N/A"}}</td>
            <td>{{$material_incoming->employee->shift->shift_name ?? "N/A"}}</td>
            <td>{{$material_incoming->tanggal_masuk_convetor ?? "N/A"}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
   