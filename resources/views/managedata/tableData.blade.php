<div class="card card-{{ $colour }}">
    <div class="card-header">
        <h3 class="card-title">Task Dashboard</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-body">
                        <table id="manageData" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>S.No.</th>
                                    @if (Auth::user()->role == 'Admin')
                                        <th>Assigned To</th>
                                    @endif
                                    <th>Title</th>
                                    <th>Created On</th>

                                    @if (in_array($id, [1, 2, 3]))
                                        <th>Start Date</th>
                                    @endif

                                    @if ($id == 3)
                                        <th>Due Date</th>
                                    @endif

                                    @if ($id == 1)
                                        <th>Completed At</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @if (!empty($results))
                                    @php $i = 1; @endphp
                                    @foreach ($results as $result)
                                        <tr>
                                            <td>
                                                <a onclick="viewDetails('{{ $result['id'] }}')" href="#"
                                                    class="btn btn-{{ $colour }} btn-sm" data-toggle="modal"
                                                    data-target="#viewModal"><i class="fa fa-eye"
                                                        style="padding: 2px"></i></a>
                                            </td>
                                            <td>{{ $i }}</td>

                                            @if (Auth::user()->role == 'Admin')
                                                <td>{{ $result['user_name'] }}</td>
                                            @endif

                                            <td>{{ $result['title'] }}</td>
                                            <td>{{ $result['created_at'] }}</td>

                                            @if (in_array($id, [1, 2, 3]))
                                                <td>{{ $result['task_date'] }}</td>
                                            @endif

                                            @if ($id == 3)
                                                <td>{{ $result['due_date'] }}</td>
                                            @endif

                                            @if ($id == 1)
                                                <td>{{ $result['completed_at'] }}</td>
                                            @endif

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

<div id="viewModal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h4 class="modal-title">Task Details:-</h4>
                <button type="button" style="color: #ffffff" class="close" data-dismiss="modal"
                    aria-hidden="true">&times;</button>
            </div>
            <div class="card-body" id="viewbody">
            </div>
        </div>
    </div>
</div>

<script>
    function viewDetails(id) {
        $.ajax({
            type: "get",
            url: "{{ route('managedata.view') }}",
            data: {
                "id": id
            },
            success: function(data) {
                console.log(data.html);
                if (data.status) {
                    $('#viewModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }, 'show');
                    $('#viewbody').html(data.html);
                } else {
                    toastr.error(data.html);
                }

            }
        });
    };
</script>

<script type="text/javascript">
    $(function() {
        var table = $('#manageData').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv'
            ],
        });
    });
</script>
