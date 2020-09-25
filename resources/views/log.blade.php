@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Temperature Logs</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Date & Time</th>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Temperature</th>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td>{{$item->datetime}}</td>
                                        <td>{{$item->employee->code ?? ''}}</td>
                                        <td>{{$item->employee->name}}</td>
                                        <td>{{$item->temperature}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="clearfix mt-2">
                            <div class="float-left" style="margin: 0;">
                                <p>Total <strong style="color: red">{{ $data->total() }}</strong> Entries</p>
                            </div>
                            <div class="float-right" style="margin: 0;">
                                {!! $data->appends([
                                    'employee_id' => $employee_id,
                                    'date' => $date,
                                ])->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
