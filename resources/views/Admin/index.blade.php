@extends('Admin.layout')
@section('content')
    <div class="col-lg-6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="text-center">Vos Espaces</h2>
                    @include('Admin.Lists.place')
                </div>
                <div class="col-lg-12">
                    <a href="{{route('form.place')}}" class="btn btn-block btn-primary"><strong><h4 >Nouveau +</h4></strong></a>
                </div>
            </div>
        </div>
    </div>
@endsection()