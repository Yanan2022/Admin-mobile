@extends('layouts.admin.app')

@section('title',$restaurant->name."'s Foods")

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('assets/admin/css/croppie.css')}}" rel="stylesheet">

@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('messages.dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('messages.vendor_view')}}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div class="row">
            <div class="col-6">
                <h1 class="page-header-title">{{$restaurant->name}}</h1>
            </div>
            <div class="col-6">
                <a href="{{route('admin.vendor.edit',[$restaurant->id])}}" class="btn btn-primary float-right">
                    <i class="tio-edit"></i> {{__('messages.edit')}} {{__('messages.restaurant')}}
                </a>
            </div>
        </div>
        <!-- Nav Scroller -->
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <span class="hs-nav-scroller-arrow-prev" style="display: none;">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                    <i class="tio-chevron-left"></i>
                </a>
            </span>

            <span class="hs-nav-scroller-arrow-next" style="display: none;">
                <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                    <i class="tio-chevron-right"></i>
                </a>
            </span>

            <!-- Nav -->
            <ul class="nav nav-tabs page-header-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', $restaurant->id)}}">{{__('messages.restaurant')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'order'])}}"  aria-disabled="true">{{__('messages.order')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'product'])}}"  aria-disabled="true">{{__('messages.food')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'discount'])}}"  aria-disabled="true">{{__('messages.discount')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'settings'])}}"  aria-disabled="true">{{__('messages.settings')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'transaction'])}}"  aria-disabled="true">{{__('messages.transaction')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.vendor.view', ['restaurant'=>$restaurant->id, 'tab'=> 'reviews'])}}"  aria-disabled="true">{{__('messages.reviews')}}</a>
                </li>
            </ul>
            <!-- End Nav -->
        </div>
        <!-- End Nav Scroller -->
    </div>
        <!-- End Page Header -->
    <!-- Page Heading -->
    <div class="tab-content">
        <div class="tab-pane fade show active" id="product">
            <div class="row pt-2">
                <div class="col-md-12">
                    <div class="card h-100">
                        <div class="card-header">
                            {{__('messages.products')}} {{$restaurant->foods->count()}}
                            
                            <a href="{{route('admin.food.add-new')}}" class="btn btn-primary pull-right"><i
                                        class="tio-add-circle"></i> {{__('messages.add')}} {{__('messages.new')}} {{__('messages.food')}}</a>
                        </div>
                        <div class="table-responsive datatable-custom">
                            <table id="columnSearchDatatable"
                                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                    data-hs-datatables-options='{
                                        "order": [],
                                        "orderCellsTop": true,
                                        "paging": false
                                    }'>
                                <thead class="thead-light">
                                    <tr>
                                        <th>{{__('messages.#')}}</th>
                                        <th style="width: 20%">{{__('messages.name')}}</th>
                                        <th style="width: 20%">{{__('messages.type')}}</th>
                                        <th>{{__('messages.price')}}</th>
                                        <th>{{__('messages.status')}}</th>
                                        <th>{{__('messages.action')}}</th>
                                    </tr>
                                </thead>

                                <tbody id="set-rows">
                                @php($foods = \App\Models\Food::withoutGlobalScope(\App\Scopes\RestaurantScope::class)->where('restaurant_id', $restaurant->id)->latest()->paginate(25))
                                @foreach($foods as $key=>$food)
                                    {{--<tr>
                                        <td>{{$key+1}}</td>
                                        <td>
                                            <span class="d-block font-size-sm text-body">
                                                    <a href="{{route('admin.food.view',[$food['id']])}}">
                                                    {{$food['name']}}
                                                    </a>
                                            </span>
                                        </td>
                                        <td>
                                            <div style="height: 100px; width: 100px; overflow-x: hidden;overflow-y: hidden">
                                                <img src="{{asset('storage/app/public/product')}}/{{$food['image']}}" style="width: 100px"
                                                        onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'">
                                            </div>
                                        </td>
                                        <td>
                                        {{$food->restaurant->name}}
                                        </td>
                                        <td>
                                            @if($food['status']==1)
                                                <div style="padding: 10px;border: 1px solid;cursor: pointer"
                                                        onclick="location.href='{{route('admin.food.status',[$food['id'],0])}}'">
                                                    <span class="legend-indicator bg-success"></span>{{__('messages.active')}}
                                                </div>
                                            @else
                                                <div style="padding: 10px;border: 1px solid;cursor: pointer"
                                                        onclick="location.href='{{route('admin.food.status',[$food['id'],1])}}'">
                                                    <span class="legend-indicator bg-danger"></span>{{__('messages.disabled')}}
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{\App\CentralLogics\Helpers::format_currency($food['price'])}}</td>
                                        <td>
                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <i class="tio-settings"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item"
                                                        href="{{route('admin.food.edit',[$food['id']])}}">{{__('messages.edit')}}</a>
                                                    <a class="dropdown-item" href="javascript:"
                                                        onclick="form_alert('food-{{$food['id']}}','Want to delete this item ?')">{{__('messages.delete')}}</a>
                                                    <form action="{{route('admin.food.delete',[$food['id']])}}"
                                                            method="post" id="food-{{$food['id']}}">
                                                        @csrf @method('delete')
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- End Dropdown -->
                                        </td>
                                    </tr>--}}
                                    <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        <a class="media align-items-center" href="{{route('admin.food.view',[$food['id']])}}">
                                            <img class="avatar avatar-lg mr-3" src="{{asset('storage/app/public/product')}}/{{$food['image']}}" 
                                                 onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'" alt="{{$food->name}} image">
                                            <div class="media-body">
                                                <h5 class="text-hover-primary mb-0">{{$food['name']}}</h5>
                                            </div>
                                        </a>
                                    </td>
                                    <td>
                                    {{$food->category}}
                                    </td>
                                    <td>{{\App\CentralLogics\Helpers::format_currency($food['price'])}}</td>
                                    <td>
                                        <label class="toggle-switch toggle-switch-sm" for="stocksCheckbox{{$food->id}}">
                                            <input type="checkbox" onclick="location.href='{{route('admin.food.status',[$food['id'],$food->status?0:1])}}'"class="toggle-switch-input" id="stocksCheckbox{{$food->id}}" {{$food->status?'checked':''}}>
                                            <span class="toggle-switch-label">
                                                <span class="toggle-switch-indicator"></span>
                                            </span>
                                        </label>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-white"
                                            href="{{route('admin.food.edit',[$food['id']])}}" title="{{__('messages.edit')}} {{__('messages.food')}}"><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-white" href="javascript:"
                                            onclick="form_alert('food-{{$food['id']}}','Want to delete this item ?')" title="{{__('messages.delete')}} {{__('messages.food')}}"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="{{route('admin.food.delete',[$food['id']])}}"
                                                method="post" id="food-{{$food['id']}}">
                                            @csrf @method('delete')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <div class="page-area">
                                <table>
                                    <tfoot class="border-top">
                                    {!! $foods->links() !!}
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script_2')
    <!-- Page level plugins -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
    <script>
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('change', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });

        $('#search-form').on('submit', function () {
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.food.search')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('#set-rows').html(data.view);
                    $('.page-area').hide();
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        });
    </script>
@endpush
