 
    <table class="table display responsive nowrap datatable2 table-bordered" id=""> 
        <thead class="thead-dark">
            <th width="2%">No</th>
            <th>Machine Code</th> 
            <th>Machine Name</th>
        </thead>
        <tbody>
            @foreach ($process_machine->processMachines as $machine)
                <tr>
                <td>{{$loop->iteration}}</td>
                    <td>{{$machine->machine_code}}</td>
                    <td>{{$machine->machine_name}}</td>

                </tr>
            @endforeach
        </tbody>
    </table>