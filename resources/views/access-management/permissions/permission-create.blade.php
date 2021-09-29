@extends('index')
@section('content')
<div class="row ">
    <div class="col-xl-12">
            <div class="white_card mb_30 shadow pt-4">
                <div class="white_card_body">
                    <div class="QA_section">
                       <div>
                            
                           <form action="{{route('access-management.permission-store')}}" method="post" >
                            @csrf
                               <div class="form-group">
                                   <label for="name">Name</label>
                                   <input type="text" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" name="name" >
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                               </div>
                               <a href="{{ route('access-management.permission-list') }}">
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
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/buttons.dataTables.min.css" />
@endpush
@push('js')
<script src="{{asset('assets')}}/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>
<script>
    if ($('.lms_table_active3').length) {
        $('.lms_table_active3').DataTable({
            bLengthChange: false,
            "bDestroy": false,
            language: {
                search: "<i class='ti-search'></i>",
                searchPlaceholder: 'Quick Search',
                paginate: {
                    next: "<i class='ti-arrow-right'></i>",
                    previous: "<i class='ti-arrow-left'></i>"
                }
            },
            columnDefs: [{
                visible: false
            }],
            responsive: true,
            searching: true,
            info: true,
            paging: true
        });
    }

</script>
@endpush
