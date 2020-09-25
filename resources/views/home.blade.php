@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <homepage start_date="{{$start_date}}" end_date="{{$end_date}}" :employee="{{$employee}}"></homepage>
        </div>
    </div>
</div>
@endsection
