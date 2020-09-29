@extends('layouts.app')
@section('styles')
    <link href="{{ asset('plugins\daterangepicker\daterangepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins\select2\dist\css\select2.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins\select2\dist\css\select2-bootstrap.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Setting</div>
                <div class="card-body">
                    <form action="{{route('setting.update')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="">Top Limit Temperature</label>
                            <input type="text" name="top_limit" class="form-control" value="{{$setting->top_limit}}" required />
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary btn-submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{asset('plugins\daterangepicker\jquery.daterangepicker.min.js')}}"></script>
    <script src="{{asset('plugins\select2\dist\js\select2.min.js')}}"></script>
    <script>
        $(document).ready(function(){

        });
    </script>
@endsection
