<!-- <hr style="background-color: blue;"> -->
<form action="{{ route('store-incoming-api') }}" method="POST">
    @csrf
    <div class="card-body">
        <div class="form-group">
            <label for="product_incoming">Product Incoming</label>
            <input type="number" min="0" value="" id="product_incoming" class="form-control" name="product_incoming">
        </div>

        <div class="form-group">
            <label for="employee_id">PIC</label>
            <select class="form-control " name="employee_id" id="employee_id">
                <option disabled selected>Choose PIC</option>
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}"
                        {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->employee_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="machine_id">Machine</label>
            <select class="form-control" name="machine_id" id="machine_id">
                <option disabled selected>Choose Machine</option>
                @foreach ($machines as $machine)
                    <option value="{{ $machine->id }}"
                        {{ old('machine_id') == $machine->id ? 'selected' : '' }}>
                        {{ $machine->machine_name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description">{{ old('description') }}</textarea>
        </div>
    </div>
</form> 