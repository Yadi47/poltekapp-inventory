 
    <table class="table display responsive nowrap datatable2 table-bordered" id=""> 
        <thead class="thead-dark">
            <th width="2%">No</th>
            <th>Customer Code</th> 
            <th>Customer Name</th> 
        </thead>
        <tbody>
            @foreach ($planning_customer->customers as $customer)
                <tr>
                <td>{{$loop->iteration}}</td>
                    <td>{{$customer->customer_code}}</td>
                    <td>{{ $customer->customer_name }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>