@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">User Management</div>
                <div class="card-body">
                    <form action="" method="post" class="form-inline">
                        @csrf
                        <input type="search" name="keyword" class="form-control form-control-sm mr-md-1 mt-2" style="min-width: 210px;" id="search_keyword" value="{{$keyword}}" placeholder="Keyword">                        
                        <button type="submit" class="btn btn-primary btn-sm mt-2 ml-2">Search</button>
                        @if (auth()->user()->role == 'super_admin')
                            <button type="button" id="btn_create_admin" class="btn btn-success btn-sm mt-2 ml-auto">Create Admin</button>
                        @endif
                    </form>
                    <div class="table-responsive mt-2">
                        <table class="table table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Username</th>
                                <th>Employee ID</th>
                                <th>Password Set</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td>{{ (($data->currentPage() - 1 ) * $data->perPage() ) + $loop->iteration }}</td>
                                        <td class="name">{{$item->name}}</td>
                                        <td class="role" data-value="{{$item->role}}">{{ucwords(str_replace('_', ' ', $item->role))}}</td>
                                        <td class="username">{{$item->username}}</td>
                                        <td class="employee_id">{{$item->employee_id}}</td>
                                        <td>
                                            @if ($item->password != '')
                                                <span class="badge badge-primary">Yes</span>
                                            @else
                                                <span class="badge badge-warning">No</span>
                                            @endif
                                        </td>
                                        <td class="py-2">
                                            <button type="button" class="btn btn-info btn-sm btn-edit" data-id="{{$item->id}}">Edit</button>
                                        </td>
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
                                    'keyword' => $keyword,
                                ])->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Admin</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{route('user.create_admin')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="">Password <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>  
        </div>
    </div>
</div>
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit User</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{route('user.update')}}" method="post">
                @csrf
                <input type="hidden" name="id" class="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="">Employee ID</label>
                        <input type="text" class="form-control employee_id" name="employee_id" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="">Password <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>  
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#btn_create_admin").click(function () {
                $("#addModal").modal();
            });

            $("#btn_reset").click(function () {
                $("#search_keyword").val('');
            });

            $(".btn-edit").click(function () {
                let id = $(this).data('id');
                let username = $(this).parents('tr').find('.username').text().trim();
                let name = $(this).parents('tr').find('.name').text().trim();
                let employee_id = $(this).parents('tr').find('.employee_id').text().trim();

                $("#editModal .id").val(id);
                $("#editModal .name").val(name);
                $("#editModal .username").val(username);
                $("#editModal .employee_id").val(employee_id);

                $("#editModal").modal();
            });
        });
    </script>
@endsection
