@extends('layouts.admin.app')

@section('title',__('messages.landing_page_image_settings'))

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('assets/admin/css/croppie.css')}}" rel="stylesheet">
    <style>
        .flex-item{
            padding: 10px;
            flex: 20%;
        }

        /* Responsive layout - makes a one column-layout instead of a two-column layout */
        @media (max-width: 768px) {
            .flex-item{
                flex: 50%;
            }
        }

        @media (max-width: 480px) {
            .flex-item{
                flex: 100%;
            }
        }
    </style>
@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('messages.dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{__('messages.landing_page_settings')}}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-header-title">{{__('messages.landing_page_settings')}}</h1>
        <!-- Nav Scroller -->
        <div class="js-nav-scroller hs-nav-scroller-horizontal">
            <!-- Nav -->
            <ul class="nav nav-tabs page-header-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.business-settings.landing-page-settings', 'index')}}">{{__('messages.text')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.business-settings.landing-page-settings', 'links')}}"  aria-disabled="true">{{__('messages.button_links')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.business-settings.landing-page-settings', 'speciality')}}"  aria-disabled="true">{{__('messages.speciality')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('admin.business-settings.landing-page-settings', 'testimonial')}}"  aria-disabled="true">{{__('messages.testimonial')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.business-settings.landing-page-settings', 'image')}}"  aria-disabled="true">{{__('messages.image')}}</a>
                </li>
            </ul>
            <!-- End Nav -->
        </div>
        <!-- End Nav Scroller -->
    </div>
        <!-- End Page Header -->
    <!-- Page Heading -->

    <div class="card my-2">
        <div class="card-body">
            <form action="{{route('admin.business-settings.landing-page-settings', 'image')}}" method="POST" enctype="multipart/form-data">
            @php($landing_page_images = \App\Models\BusinessSetting::where(['key'=>'landing_page_images'])->first())
            @php($landing_page_images = isset($landing_page_images->value)?json_decode($landing_page_images->value, true):null)

                @csrf

                <div class="form-group">
                    <label class="input-label" >{{__('messages.top_content_image')}}<small style="color: red">* ( {{__('messages.size')}}: 772 X 899 px )</small></label>
                    <div class="custom-file">
                        <input type="file" name="top_content_image" id="customFileEg1" class="custom-file-input"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                        <label class="custom-file-label" for="customFileEg1">{{__('messages.choose')}} {{__('messages.file')}}</label>
                    </div>

                    <center id="image-viewer-section" class="pt-2">
                        <img style="height: 200px;border: 1px solid; border-radius: 10px;" id="viewer"
                                src="{{asset('assets/landing')}}/image/{{isset($landing_page_images)?$landing_page_images['top_content_image']:'double_screen_image.png'}}" 
                                onerror="this.src='{{asset('assets/admin/img/400x400/img2.jpg')}}'"
                                alt=""/>
                    </center>
                </div>

                <div class="form-group">
                    <label class="input-label" >{{__('messages.about_us_image')}}<small style="color: red">* ( {{__('messages.size')}}: 1241 X 1755 px )</small></label>
                    <div class="custom-file">
                        <input type="file" name="about_us_image" id="customFileEg2" class="custom-file-input"
                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*" required>
                        <label class="custom-file-label" for="customFileEg2">{{__('messages.choose')}} {{__('messages.file')}}</label>
                    </div>

                    <center id="image-viewer-section2" class="pt-2">
                        <img style="height: 200px;border: 1px solid; border-radius: 10px;" id="viewer2"
                                src="{{asset('assets/landing')}}/image/{{isset($landing_page_images)?$landing_page_images['about_us_image']:'about_us_image.png'}}"
                                onerror="this.src='{{asset('assets/admin/img/400x400/img2.jpg')}}'"
                                alt=""/>
                    </center>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="{{__('messages.submit')}}">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script_2')
    <script>
        function readURL(input, viewer) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#'+viewer).attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this, 'viewer');
            $('#image-viewer-section').show(1000);
        });


        $("#customFileEg2").change(function () {
            readURL(this ,'viewer2');
            $('#image-viewer-section2').show(1000);
        });

    </script>
@endpush
