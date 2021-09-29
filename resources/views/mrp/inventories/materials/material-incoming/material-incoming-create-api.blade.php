<form action="{{ route('store-material-incoming-api') }}" method="post">
    @csrf
    <div class="form-group">
        <label for="">Quantity</label>
        <input type="number" min="0" value="{{ old('material_incoming') }}" id="material_incoming" class="form-control" name="material_incoming">
    </div>

    <div class="form-group">
        <label for="">Lot Material</label>
        <input  type="text" maxlength="8" value="{{ old('lot_material') }}" id="lot_material" class="form-control" name="lot_material">
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
        <label for="">Tanggal Masuk Conveyor</label>
        <input type="date" id="tanggal_masuk_conveyor"  class="form-control" name="tanggal_masuk_conveyor" autocomplete="off">
    </div>
    
    <div class="form-group">
        <label for="">Description <small>(Optional)</small></label>
        <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
    </div>
</form>