 
    <table class="table display responsive nowrap datatable2 table-bordered" id=""> 
        <thead class="thead-dark">
            <th width="2%">No</th>
            <th>Process</th> 
            <th>Process Time</th>
        </thead>
        <tbody>
            @foreach ($planning->process as $proces)
                <tr>
                <td>{{$loop->iteration}}</td>
                    <td>{{$proces->process_name}} </td>
                    <td>{{$proces->process_time}}</td>

                </tr>
            @endforeach
        </tbody>
    </table>