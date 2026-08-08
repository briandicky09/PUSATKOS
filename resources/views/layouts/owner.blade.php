@extends('layouts.app')

@section('content')
<div class="ts-page-wrapper ts-has-bokeh-bg" id="page-top">

    @include('partials.owner-navbar')

    @include('partials.alert')

    @yield('owner-content')

    @include('partials.footer')

</div>
@endsection
