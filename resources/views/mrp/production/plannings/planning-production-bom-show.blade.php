 
    <table class="table display responsive nowrap datatable2 table-bordered" id=""> 
        <thead class="thead-dark">
            <th width="2%">No</th>
            <th>BOM Code</th> 
            <th>BOM Name</th> 
        </thead>
        <tbody>
            @foreach ($planning_boms->boms as $bom)
                <tr>
                <td>{{$loop->iteration}}</td>
                    <td>{{$bom->bom_code}}</td>
                    <td>{{ $bom->bom_name }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>