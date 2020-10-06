@extends('layouts.app')
@section('styles')
    <link href="{{ asset('plugins\daterangepicker\daterangepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins\select2\dist\css\select2.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins\select2\dist\css\select2-bootstrap.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Notifications</div>
                <div class="card-body">
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered">
                            <thead>
                                <th style="width: 50px">No</th>
                                <th>User</th>
                                <th>Date & Time</th>
                                <th>Notification</th>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td>{{$item->user->name ?? ''}} [{{$item->user->employee_id ?? ''}}]</td>
                                        <td>{{$item->temperature->datetime}}</td>
                                        <td>{{$item->message}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix mt-2">
                            <div class="float-left" style="margin: 0;">
                                <p>Total <strong style="color: red">{{ $data->total() }}</strong> Entries</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data->appends([])->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection
