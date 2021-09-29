@extends('index')
@section('content')
<div class="row ">
    <div class="col-xl-6">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div>
                        <form action="{{route('access-management.role-store')}}" method="post" id="unsearch">
                            @csrf
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" value="{{old('name')}}"
                                    class="form-control @error('name') is-invalid @enderror" name="name">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                
                                <button class="btn btn-sm btn-info" type="button" id="checkAll">Check All</button>
                                <button class="btn btn-sm btn-dark" type="button" id="uncheckAll">Unheck All</button>
                                 @error('permissions')
                                <span class="d-block text-danger">{{ $message }}</span>
                                @enderror
                                <div class="QA_table mb_30">
                                <table id="permissionTable" class="table table-hover no-border">
                                    <thead>
                                        <tr class="text-uppercase bg-lightest">
                                            <th style="min-width: 265px"><span class="text-dark">Name</span></th>
                                            <th style="min-width: 80px" class="text-center"><span class="text-dark">Check</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission)
                                        <tr class="row-permission">										
                                            <td class="text-start">
                                                <span class="text-dark">
                                                    {{ $permission->name }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="demo-checkbox">
                                                    <input name="permissions[]" type="checkbox" value="{{$permission->id}}" {{ in_array($permission->id, old('permissions') ?? []) ? 'checked' : '' }} class="filled-in">
                                                    <label for="" style="height: 0px; min-width: 0;"></label>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                               
                            </div>
                            <a href="{{ route('access-management.role-list') }}">
                                <button type="button" class="btn btn-warning btn-sm">Back</button>
                            </a>
                            <button class="btn btn-success btn-sm">Save</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<!-- datatable CSS -->
<link rel="stylesheet" href="{{asset('assets')}}/css/datatables.min.css" />
<style>
    .table tr {
        cursor: pointer;
    }

    .table-hover-custom>tbody>tr:hover {
        background-color: #d1cfcfda !important;
    }

</style>
@endpush
@push('js')
<script src="{{asset('assets')}}/js/datatables.min.js"></script>
<script>
    $("#unsearch").on("submit", function() {
        $('#permissionTable').DataTable().search('').draw();
        // return false;
    });

    $(function() {
        $('#permissionTable').DataTable({
            "scrollY": "350px",
            "scrollCollapse": true,
            "paging": false,
            info: false,
        });
    });
</script>
<script>
    $('.row-permission').click(function () {
        let data = $(this).find('td input:checkbox');
        console.log(data.prop('checked', !data.is(':checked')));
    });
    $('#checkAll').click(function (e) {
            let find = $('#permissionTable').find('tr td input:checkbox').prop('checked', true);
        });

    $('#uncheckAll').click(function (e) {
        let find = $('#permissionTable').find('tr td input:checkbox').prop('checked', false);
    });
</script>
@endpush
