 
    <table class="table display responsive nowrap datatable2 table-bordered" id=""> 
        <thead class="thead-dark">
            <th width="2%">No</th>
            <th>Material</th>   
            <th>QTY</th>   
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($bom->materials as $material)
                <tr>
                <td>{{$no++}}</td>
                    <td>{{$material->material_name}}</td>
                    <td>{{$material->qty}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
     