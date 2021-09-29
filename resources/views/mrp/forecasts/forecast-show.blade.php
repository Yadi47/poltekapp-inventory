 
    <table class="table display responsive nowrap datatable2 table-bordered" id=""> 
        <thead class="thead-dark">
            <th width="2%">No</th>
            <th>DOCK CD</th> 
        </thead>
        <tbody>
            @foreach ($forecast->customer->customerDocs as $detail_dock)
                <tr>
                <td>{{$loop->iteration}}</td>
                    <td>{{$detail_dock->dock_cd}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>