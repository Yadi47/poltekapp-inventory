@extends('oee')

@section('title', $page_title)

@section('content')
<div class="row ">
    <div class="col-xl-12">
        <div class="white_card mb_30 shadow ">
            <div class="white_card_header">
                <div class="row align-items-center justify-content-between flex-wrap">
                    <div class="col-lg-4 ">
                        <div class="main-title">
                            <h3 class="m-0">Filter Alarm</h3>
                        </div>
                    </div>
                    <div class="col-lg-4 text-right d-flex justify-content-end">
                        <select class="nice_Select2 max-width-220" onchange="selectType(event)" id="type_interval">
                            <option value="daily">Daily</option>
                            <option value="monthly">Monthly</option>
                        </select>
                        
                        <input type="month" class="hilang" name="interval" id="interval_month"
                            value="{{date('Y-m-d')}}">
                        <input type="date" name="interval" id="interval_date" value="{{date('Y-m')}}">
                        <button class="button btn-sm btn-primary" onclick="getApiTrending()">SUBMIT</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row ">
    <div class="col-lg-12">
        <div class="white_card mb_30 shadow pt-4">
            <div class="white_card_body">
                <div class="QA_section">
                    <div class="white_box_tittle list_header">
                        <h4>{{$page_title}}</h4>
                    </div>
                    
                    <div class="QA_table mb_30">
                        <!-- table-responsive -->
                        <table class="table lms_table_active3 ">
                            <thead>
                                <tr>
                                    <th scope="col">NO</th>
                                    <th scope="col">DATETIME</th>
                                    <th scope="col">MACHINE NAME</th>
                                    <th scope="col">ALARM NAME</th>
                                    <!-- <th scope="col">ABNORMAL</th> -->
                                    <th scope="col">TEXT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($alarms as $alarm)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$alarm->datetime}}</td>
                                    <td>{{$alarm->alarmMaster->machine->ident}}</td>
                                    <td>{{$alarm->alarmMaster->alarm_name}}</td>
                                    <!-- <td>{{$alarm->abnormal}}</td> -->
                                    <td>{{$alarm->text}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.flash.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/jszip.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/pdfmake.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/vfs_fonts.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.html5.min.js"></script>
<script src="{{asset('assets')}}/vendors/datatable/js/buttons.print.min.js"></script>
<script src="{{asset('assets/js/sweetalert2@9.js')}}"></script>

<script>
    // if ($('.lms_table_active3').length) {
       var table =  $('.lms_table_active3').DataTable({
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
                    paging: true,
                    dom: 'Bfrtip',
                    buttons: ['csv', 'excel']
                });
    // }

    let type_interval = $('#type_interval').val();

    function selectType(e) {
        let type = $(e.target).find("option:selected").val();
        if (type === 'daily') {
            $('#interval_date').removeClass('hilang');
            $('#interval_month').addClass('hilang');
        } else if (type === 'monthly') {
            $('#interval_date').addClass('hilang');
            $('#interval_month').removeClass('hilang');
        }
    }

    const getApiTrending = async () => {
        let date;
        let type = $('#type_interval').val();

        if (type === 'daily') {
            date = $('#interval_date').val();
        } else if (type === 'monthly') {
            date = $('#interval_month').val();
        } else {
            date = `{{date('Y-m-d')}}`
        }
        console.log(date)

        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        axios.get(`{{url('/')}}` + '/oee/alarm-list?date='+date)
            .then(async function (response) {
                Swal.fire(
                    'Success',
                    'Data Loaded Successfully  !',
                    'success'
                ).then((result) => {
                    // --REDRAW TABLE
                    table.clear();
                    $.each(response.data, function (i, key) {
                        table.row.add([
                            i + 1,
                            response.data[i].datetime,
                            response.data[i].ident,
                            response.data[i].alarm_name,
                            // response.data[i].abnormal,
                            response.data[i].text,
                        ])
                    });
                            // console.log(response.data[0].alarmMaster);
                    table.draw();
                })

               

            })
            .catch(function (error) {
                Swal.fire(
                    'Failde',
                    'Fail Load data  !',
                    'warning'
                ).then((result) => {
                    // location.reload();
                })
            });
    };

</script>
@endpush
