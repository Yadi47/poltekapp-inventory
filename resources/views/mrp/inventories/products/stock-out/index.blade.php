@extends('mrp')

@section('title', $page_title)
@section('content')
    <style>
        .info-box-icon {
            border-radius: 5px;
            align-items: center;
            display: flex;
            padding: 5px;
            font-size: 2.5rem;
            justify-content: center;
        }

        .info-box-text {
            display: block;
            font-size: 21px;
            margin-top: .776rem;
            margin-left: .776rem;
        }

    </style>

<div class="row ">
    

    <div class="col-lg-3 col-md-6" onclick="location.href='{{ route('mrp.product-out-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-info h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/in-stock.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark tx-sm-16-force">Stock Out Delivery</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6" onclick="location.href='{{ route('mrp.product-sortir-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-success h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/out-of-stock.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark tx-sm-16-force">Stock Out Recheck</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</div>
@endsection

@push('css')
    <!-- datatable CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/responsive.dataTables.min.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatable/css/buttons.dataTables.min.css" />
@endpush
@push('js')

    <script src="{{ asset('assets') }}/vendors/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatable/js/dataTables.buttons.min.js"></script>

    {{-- SEARCH --}}
    <script>
        const dictionary = ['product', 'material', 'report'];
        const searchInput = document.getElementById("search");

        searchInput.addEventListener("keyup", (e) => {
            dictionary.forEach(element => {
                let id = '#' + element;
                $(id).addClass('hidden')
            });

            const inputText = e.target.value.toLowerCase();
            let filtered = dictionary.filter((data) => {
                return data.indexOf(inputText.toLowerCase()) !== -1;
            });

            filtered.forEach(element => {
                let id = '#' + element;
                $(id).removeClass('hidden')
            });
            console.log(filtered)
        });

    </script>


@endpush
