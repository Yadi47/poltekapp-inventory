<!-- <hr style="background-color: blue;"> -->
<form action="{{ route('store-effeciency') }}" method="POST">
    @csrf

    <div class="card-body">
        <div class="form-group">
            <label for="date">DATE</label>
            <input type="date" value="" class="form-control @error('date') is-invalid @enderror" name="date" id="date">

            @error('date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="trouble">TROUBLE</label>
            <input type="text" value="" class="form-control @error('trouble') is-invalid @enderror" name="trouble" id="trouble" placeholder="Input Trouble...">

            @error('trouble')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="cause">CAUSE</label>
            <input type="text" value="" class="form-control @error('cause') is-invalid @enderror" name="cause" id="cause" placeholder="Input Cause...">

            @error('cause')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="action">ACTION</label>
            <input type="text" value="" class="form-control @error('action') is-invalid @enderror" name="action" id="action" placeholder="Input Action...">

            @error('action')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">STATUS</label>
            <input type="text" value="" class="form-control @error('status') is-invalid @enderror" name="status" id="status" placeholder="Input Status...">

            @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</form> 
