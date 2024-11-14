@extends('include.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 id="todoCount">
                                    @if (isset($todoCount))
                                        {{ $todoCount }}
                                    @else
                                        0
                                    @endif
                                </h3>
                                <p>Tasks To Do</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-edit"></i>
                            </div>
                            <a href="#" class="small-box-footer" onclick="callTable('0')">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3 id="doneCount">
                                    @if (isset($doneCount))
                                        {{ $doneCount }}
                                    @else
                                        0
                                    @endif
                                </h3>
                                <p>Tasks Done</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-checkmark"></i>
                            </div>
                            <a href="#" class="small-box-footer" onclick="callTable('1')">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3 id="inprogressCount">
                                    @if (isset($inprogressCount))
                                        {{ $inprogressCount }}
                                    @else
                                        0
                                    @endif
                                </h3>
                                <p>Tasks In Progress</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-clock"></i>
                            </div>
                            <a href="#" class="small-box-footer" onclick="callTable('2')">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3 id="overdueCount">
                                    @if (isset($overdueCount))
                                        {{ $overdueCount }}
                                    @else
                                        0
                                    @endif
                                </h3>
                                <p>Tasks Over Due</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-alert"></i>
                            </div>
                            <a href="#" class="small-box-footer" onclick="callTable('3')">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12" id="tableData">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function callTable(id) {
            $.ajax({
                type: "get",
                url: "{{ route('gettabledata') }}",
                data: {
                    "id": id,
                },
                success: function(data) {
                    if (data.status) {
                        toastr.success(data.message);
                        $('#tableData').html(data.html);
                    } else {
                        toastr.error(data.message);
                        $('#tableData').html('');
                    }
                }
            });
        }
    </script>
@endsection
