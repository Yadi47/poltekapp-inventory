@extends('mrp')

@section('title', $page_title)

@section('content')

<style>
    .document {
        width: 100%;
        height: 18rem;
        padding-right: .5rem;
        margin-bottom: 1rem;
    }

    /* CSS REPORT  */
    .report {
        table-layout: fixed;
    }

    .report td {
        padding: 1px 5px;
    }
    .date-head {
        font-size: 9px;
        font-weight: bold;
        text-align: center;
        width: 50px;
        /* padding: 2px 7px !important; */
    }

    table.table-bordered>tbody>tr>td {
        border: 1px solid #84757F !important;
    }

    /* SCROLL STYLE */
    /*
                                                 *  STYLE 1
                                                 */
    #style-1::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        background-color: #F5F5F5;

    }

    #style-1::-webkit-scrollbar {
        width: 12px;
        background-color: #F5F5F5;
    }

    #style-1::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        background-color: #555;
    }

</style>

<div class="row">
    <div class="col-lg-6">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div class="white_box_tittle list_header">
                        <h4>Date Picker Bom Export</h4>
                    </div>
                    <div>
                        <form action="{{ route('mrp.report.report_bom-list') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="">Start Date</label>
                                        <input autocomplete="off"
                                            class="datepicker-here form-control digits @error('start_date') is-invalid @enderror"
                                            type="text" data-language="en" data-min-view="months" data-view="months"
                                            data-date-format="MM yyyy" name="start_date">
                                        @error('start_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success btn-group-lg">
                                            <i class="fas fa-cog fa-lg"></i>
                                            Generate
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (isset($status))
<div class="col-xl-12">
    <div class="white_card mb_30 shadow pt-1">
        <div class="white_card_body" style="padding: 5px 10px 15px 15px !important;">
            <div class="QA_section">
                <div class="white_box_tittle list_header">
                    <h4>{{ $page_title }}</h4>

                    <div class="box_right d-flex lms_block">
                        <a href="{{ route('mrp.report.report_bom-export', $start_date) }}">
                            <div class="btn btn-success ml-10 btn-sm">
                                <i class="fas fa-file-excel"></i>
                                Excel
                            </div>
                        </a>
                        {{-- <a href="">
                            <div class="btn btn-danger ml-10 btn-sm">
                                <i class="fas fa-file-pdf"></i>
                                PDF
                            </div>
                        </a> --}}
                        
                    </div>
                </div>
                @if (Session::has('message'))
                    <div class="alert  {{ Session::get('alert-class', 'alert-info') }} d-flex align-items-center justify-content-between"
                        role="alert">
                        <div class="alert-text">
                            <p>{{ Session::get('message') }}</p>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="ti-close  f_s_14"></i>
                        </button>
                    </div>
                @endif
                <div class=" mb_30 ">
                
                    <div class="table-responsive" style="padding-bottom:10px;" id="style-1">
                        <table class="report table-bordered"
                            style="font-size: 11px; table-layout: auto !important;">
                            <tbody>
                                <tr>
                                    <td width="100px" class="text-center" style="font-size:12px;font-weight: 800">Name</td>
                                    <td width="100px" class="text-center" style="font-size:12px;font-weight: 800">Part No.</td>
                                    <td width="100px" class="text-center" style="font-size:12px;font-weight: 800">Pieces/Box</td>
                                    {!! $head_date !!}
                                    
                                </tr>
                                {{-- {{ dd($column)}} --}}
                                @foreach ($column as $data)
                                <tr>
                                    <td>{{$data['bom_name']}}</td>
                                    <td>{{$data['part_number']}}</td>
                                    <td>{{$data['price'] }}</td>
                                    {{-- <td>{{ $data['sum_value']['qty_material'] }}</td> --}}
                                    {{-- <td>{{($data['price'] * $data['qty_material'])}}</td> --}}
                                    {!! $body_date!!}  

                                </tr>
                            @endforeach
                            
                            </tbody>
                        </table>

                        
                    </div>
                    <br>

                </div>

            </div>
        </div>
    </div>
</div>
</div>
@endif
@endsection


                    {{-- <div class="mb_30">
                        <div class="row">
                                <div class="table-responsive" style="padding-bottom:10px;" id="style-1">
                                    <table class="report table-bordered" style="font-size: 11px;">
                                        <tbody>
                                            <tr>
                                                <td width="100px" class="text-center" style="font-size:15px;font-weight: 800">Name</td>
                                                <td width="100px" class="text-center" style="font-size:15px;font-weight: 800">Part No.</td>
                                                <td width="100px" class="text-center" style="font-size:15px;font-weight: 800">Pieces/Box</td>
                                                <td>21/1</td>
                                                <td>2</td>
                                                <td>3</td>
                                                <td>4</td>
                                                <td>5</td>
                                                <td>6</td>
                                                <td>7</td>
                                                <td>8</td>
                                                <td>9</td>
                                                <td>10</td>
                                                <td>11</td>
                                                <td>12</td>
                                                <td>13</td>
                                                <td>14</td>
                                                <td>15</td>
                                                <td>16</td>
                                                <td>17</td>
                                                <td>18</td>
                                                <td>19</td>
                                                <td>20</td>
                                                <td>21</td>
                                                <td>22</td>
                                                <td>23</td>
                                                <td>24</td>
                                                <td>25</td>
                                                <td>26</td>
                                                <td>27</td>
                                                <td>28</td>
                                                <td>29</td>
                                                <td>30</td>
                                            </tr>
                                            <tr>
                                                <td>BODY</td>
                                                <td>15708-75010-11id</td>
                                                <td>1.500</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                            </tr>
                                            <tr>
                                                <td>PULG</td>
                                                <td>15798-36011id</td>
                                                <td>10.000</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                            </tr>
                                            <tr>
                                                <td>SPRING</td>
                                                <td>90501-75010id</td>
                                                <td>5000</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                            </tr>
                                            <tr>
                                                <td>PIPE</td>
                                                <td>15708-75020-20id</td>
                                                <td>1.500</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                            </tr>
                                            <tr>
                                                <td>PLATE</td>
                                                <td>13516-75040-36id</td>
                                                <td>1.000</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                                <td>697.689</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> --}}
                            
   

 

@push('css')
<!-- datatable CSS -->
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/responsive.dataTables.min.css" />
<link rel="stylesheet" href="{{asset('assets')}}/vendors/datatable/css/buttons.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('assets') }}/vendors/datepicker/date-picker.css">
@endpush
@push('js')

<script src="{{asset('assets')}}/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/dataTables.buttons.min.js"></script>

<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.js"></script>
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.en.js"></script>
<script src="{{ asset('assets') }}/vendors/datepicker/datepicker.custom.js"></script>
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

    function detailMaterial(id) {
        $.confirm({
            title: 'Detail Material',
            theme : 'material',
            backgroundDismiss: true, // this will just close the modal
            content: 'url:bom-show/detail/'+id,
            onContentReady: function () {
                var self = this;
                // this.setContentPrepend('<div>Prepended text</div>');
                // setTimeout(function () {
                //     self.setContentAppend('<div>Appended text after 2 seconds</div>');
                // }, 2000);
            },
            columnClass: 'medium',
        });
    }
  
    var urlDelete = `{{route('mrp.bom-delete')}}`
    function deleteData(event,id,textData){
        event.preventDefault();
        $.confirm({
            title: 'Are you sure for delete data ?',
            content: textData,
            buttons: {
                confirm:   {
                    btnClass: 'btn-red',
                    keys: ['enter'],
                    action: function(){
                        axios.delete(urlDelete,{params:{id:id,text:textData}})
                            .then(function (response) {
                                // handle success
                                location.reload();
                            })
                            .catch(function (error) {
                                // handle error
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });

                    }
                },
                cancel:  {
                    btnClass: 'btn-dark',
                    keys: ['esc'],
                    
                },
                
            }
        });
    }
</script>
@endpush