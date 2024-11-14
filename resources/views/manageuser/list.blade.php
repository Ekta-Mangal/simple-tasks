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
                                    <i class="fa fa-plus icon-white"></i> Add User
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
                                        <h3 class="card-title">Manage Users List</h3>
                                    </div>
                                    <div class="card-body" style="overflow-x: auto; padding: 15px;">
                                        <table id="manageUser" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sr.No.</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="fw-semibold text-gray-600">
                                                @if (!empty($data))
                                                    @php $i = 1; @endphp
                                                    @foreach ($data as $result)
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $result['name'] }}</td>
                                                            <td>{{ $result['email'] }}</td>
                                                            <td>{{ $result['role'] }}</td>
                                                            <td>
                                                                <a onclick="editUser('{{ $result['id'] }}')" href="#"
                                                                    class="btn btn-primary btn-sm" data-toggle="modal"
                                                                    data-target="#modal-default-lg-edit">
                                                                    <i class="fa fa-edit" style="padding: 2px"></i>
                                                                </a>

                                                                @if ($result['id'] != Auth::user()->id)
                                                                    <a onclick="deleteUser('{{ $result['id'] }}')"
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
                url: "{{ route('manageuser.add') }}",
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

        function editUser(id) {
            $.ajax({
                type: "get",
                url: "{{ route('manageuser.edit') }}",
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

        function deleteUser(id) {
            var result = confirm('Do you want to delete the User');
            if (result) {
                $.ajax({
                    url: "{{ route('manageuser.delete') }}",
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
                    <h4 class="modal-title">Enter User Details Here:-</h4>
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
                    <h4 class="modal-title">Modify User Details Here:-</h4>
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
