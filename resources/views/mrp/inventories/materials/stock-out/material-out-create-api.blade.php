
<form action="{{ route('store-material-out-api') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="">Quantity Out</label>
        <input type="number" min="0" value="{{ old('material_outgoing') }}" id="material_outgoing" class="form-control" name="material_outgoing">
    </div>

    <div class="form-group">
        <label>PIC</label>
        <select class="form-control" name="employee_id" id="employee_id">
            <option disabled selected>Choose PIC</option>
            @foreach ($employees as $employee)
                <option value="{{ $employee->id }}"
                    {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                    {{ $employee->employee_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Machine</label>
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
        <label for="">Description <small>(Optional)</small></label>
        <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
    </div>
</form>