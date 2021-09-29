
    <table class="table display responsive nowrap datatable2 table-bordered" id=""> 
        <thead class="thead-dark">
            <th width="2%">No</th>
            <th>Array Index</th> 
            <th>Text</th>
        </thead>
        <tbody>
            @foreach ($alarmMaster->alarms  as $alarm)
                <tr>
                <td>{{$loop->iteration}}</td>
                    <td>{{$alarm->index_array}}</td>
                    <td>{{$alarm->text}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>