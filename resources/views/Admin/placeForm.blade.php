@extends('Admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('Admin.Forms.place')
        </div>
    </div>
@endsection()
@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxwYBQWs7Kt0_r9-vTAvZ2ywfaCip4KAM&callback=initMap"
            async defer></script>
@endsection
