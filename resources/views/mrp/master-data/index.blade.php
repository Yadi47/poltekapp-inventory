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
  .info-box-text{
    display: block;
    font-size: 21px;
    margin-top: .776rem;
    margin-left: .776rem;
  }

  .box-body {
        padding: 1rem;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        border-radius: 10px; 
    }
    
    .card {
        cursor: pointer;
        transition: all 0.7s;
    }

    .card:hover {
        transform: scale(1.07) !important;
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 5px 8px rgba(0, 0, 0, .06);
    }

    .mt-30 {
        margin-top: 30px;
    }

    .me-15 {
        margin-right: 15px !important; 
    }

    .h-50 {
        height: 50px !important; 
    }  

    .w-50 {
        width: 50px !important; 
    }

    .l-h-50 {
        line-height: 3.0714285714rem!important; 
    }

    .rounded { 
        border-radius: .25rem !important;
    }

    @media (max-width: 767px) {
        .small-box {
            text-align: center; 
            }
            .small-box .icon {
            display: none; 
            }
            .small-box p {
            font-size: 0.8571rem; 
            } 
        }
        .box {
            position: relative;
            margin-bottom: 1.5rem;
            width: 100%;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 0px;
            -webkit-transition: .5s;
            transition: .5s;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-shadow: 0 0 30px 0 rgba(82, 63, 105, 0.05);
            box-shadow: 0 0 30px 0 rgba(82, 63, 105, 0.05); 
        }
    }
</style>

<div class="row ">
 

    
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3" id="unit" onclick="location.href='{{ route('mrp.unit-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-light h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/unit.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 18px;">Unit</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3" id="shift" onclick="location.href='{{ route('mrp.shift-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-success h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/shift.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 18px;">Shift</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    

  

    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3" id="employee" onclick="location.href='{{ route('mrp.employee-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-info h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/employee.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 18px;">Employee</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3" id="customer" onclick="location.href='{{ route('mrp.customer-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-light h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/user.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 18px;">Customer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3" id="supplier" onclick="location.href='{{ route('mrp.supplier-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-warning h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/supplier.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 18px;">Supplier</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3" id="material" onclick="location.href='{{ route('mrp.material-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-light h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/material.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 18px;">Material</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-3" id="product" onclick="location.href='{{ route('mrp.product-list')}}'">
        <div class="box card">
            <div class="box-body">
                <div class="d-flex align-items-center">
                    <div class="me-15 bg-warning h-50 w-50 l-h-50 rounded text-center">
                        <img src="{{ asset('img/product.svg') }}" style="height: 30px" alt="">
                    </div>
                    <div class="d-flex flex-column tx-xs-medium">
                        <span class="text-dark font-weight-bold" style="font-size: 18px;">Product</span>
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

{{-- SEARCH --}}
<script>
const dictionary = ['place', 'unit', 'problem', 'counter', 'vehicle', 'shift','employee','customer','supplier','material','bom','product','machine','process'];
const searchInput = document.getElementById("search"); 

searchInput.addEventListener("keyup", (e) => {
    dictionary.forEach(element => {
        let id = '#'+element;
        $(id).addClass('hidden')
    });

    const inputText = e.target.value.toLowerCase();
    let filtered = dictionary.filter((data) => {
        return data.indexOf(inputText.toLowerCase()) !== -1;
    }); 

    filtered.forEach(element => {
        let id = '#'+element;
        $(id).removeClass('hidden')
    });
    console.log(filtered)
});
</script>
@endpush
