@extends('include.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="row">
                        <div class="col-sm-12">
                            <ol class="breadcrumb float-sm-left">
                                <button type="button" class="btn btn-block bg-gradient-primary text-white form-control"
                                    data-inline="true" data-toggle="modal" onclick="add()" data-target="#addModal">
                                    <i class="fa fa-plus icon-white"></i> Add Task
                                </button>
                            </ol>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Task Management</h3>
                                    </div>
                                    <div class="card-body" style="overflow-x: auto; padding: 15px;">
                                        <table id="manageUser" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sr.No.</th>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Assigned To</th>
                                                    <th>Status</th>
                                                    <th>Priority</th>
                                                    <th>Assigned by</th>
                                                    <th>Created On</th>
                                                    <th>Due Date</th>
                                                    <th>Start Date</th>
                                                    <th>Completed On</th>

                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                @if (!empty($results))
                                                    @php $i = 1; @endphp
                                                    @foreach ($results as $result)
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $result['title'] }}</td>
                                                            <td>{{ $result['description'] }}</td>
                                                            <td>{{ $result['user_name'] }}</td>
                                                            <td>{{ $result['status'] }}</td>
                                                            <td>{{ $result['priority'] }}</td>
                                                            <td>{{ $result['created_by'] }}</td>
                                                            <td>{{ $result['created_at'] }}</td>
                                                            <td>{{ $result['due_date'] }}</td>
                                                            <td>{{ $result['task_date'] }}</td>
                                                            <td>{{ $result['completed_at'] }}</td>
                                                            <td>
                                                                @if (auth()->user()->role == 'Admin' ||
                                                                        (auth()->user()->role == 'User' && auth()->user()->name == $result['created_by']))
                                                                    <a onclick="editTask('{{ $result['id'] }}')"
                                                                        href="#" class="btn btn-primary btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#modal-default-lg-edit">
                                                                        <i class="fa fa-edit" style="padding: 2px"></i>
                                                                    </a>
                                                                    <a onclick="deleteTask('{{ $result['id'] }}')"
                                                                        href="#" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash" style="padding: 2px"></i>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @php $i++; @endphp
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function add(id) {
            $.ajax({
                type: "get",
                url: "{{ route('managetask.addTask') }}",
                data: {
                    "id": id
                },
                success: function(data) {
                    console.log(data.url);
                    $("#addModal").modal('show');
                    $('#addbody').html(data.html);
                }
            });
        }

        function editTask(id) {
            $.ajax({
                type: "get",
                url: "{{ route('managetask.editTask') }}",
                data: {
                    "id": id
                },
                success: function(data) {
                    console.log(data.url);
                    $("#editModal").modal('show');
                    $('#editbody').html(data.html);
                }
            });
        }

        function deleteTask(id) {
            var result = confirm('Do you want to delete the Task ?');
            if (result) {
                $.ajax({
                    url: "{{ route('managetask.deleteTask') }}",
                    type: 'GET',
                    data: {
                        "id": id
                    },
                    success: function(response) {
                        console.log(response.status);
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            setTimeout(() => {
                                location.reload(true);
                            }, 2000);
                        }
                        if (response.status === 'error') {
                            toastr.error(response.message);
                        }
                    }
                });
            }
        }
    </script>
    <script type="text/javascript">
        $(function() {
            var table = $('#manageUser').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv'
                ],
            });
        });
    </script>


    <div id="addModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title">Enter Task Details Here:-</h4>
                    <button type="button" style="color: #ffffff" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="card-body" id="addbody"></div>
            </div>
        </div>
    </div>

    <div id="editModal" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title">Modify Task Details Here:-</h4>
                    <button type="button" style="color: #ffffff" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                </div>
                <div class="card-body" id="editbody"></div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}", "Validation Error", {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 5000
                    });
                @endforeach
            @endif
        });
    </script>
@endsection
