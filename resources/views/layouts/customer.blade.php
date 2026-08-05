@extends('layouts.app')

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    @include('partials.navbar')

    @include('partials.alert')

    <section class="pt-5 mt-5 pb-5" style="margin-top: 90px;">
        <div class="container">
            <div class="row">

                <!--Sidebar Customer-->
                <div class="col-lg-3">
                    @include('partials.customer-sidebar')
                </div>

                <!--Content-->
                <div class="col-lg-9">
                    @yield('customer-content')
                </div>

            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>

    @include('partials.footer', ['noMarginFooter' => true])

</div>
@endsection
