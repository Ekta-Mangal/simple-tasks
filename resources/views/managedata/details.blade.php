<form action="{{ route('managedata.update') }}" method="post" id="addDetails" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <input name="id_edit" type="hidden" value="{{ $data->id }}" class="form-control" id="id_edit">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Assigned To</label>
                                <input type="text" class="form-control" value="{{ $user_name }}" id="name"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="created_by">Assigned By</label>
                                <input type="text" class="form-control" value="{{ $creator_name }}" id="created_by"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="title">Task Title</label>
                                <input type="text" class="form-control" value="{{ $data->title }}" id="title"
                                    readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="description">Task Description</label>
                                <textarea class="form-control" id="description" rows="4" readonly>{{ $data->description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="priority">Task Priority</label>
                                <input type="text" class="form-control" value="{{ $data->priority }}" id="priority"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="created_at">Task Created On</label>
                                <input type="text" class="form-control" value="{{ $data->created_at }}"
                                    id="created_at" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="due_date">Task Due Date</label>
                                <input type="text" class="form-control" value="{{ $formatted_due_date }}"
                                    id="due_date" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="comments">Task Comments<span class="text-danger">*</span></label>
                                <textarea name="comments" class="form-control" id="comments" rows="4"
                                    placeholder="Enter Task Comments here if any...">{{ $data->comments ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Task Status</label>
                                <select class="form-control select2bs4" style="width: 100%;" name="status"
                                    id="status">
                                    <option value="">Select Task Status</option>
                                    <option value="todo" {{ $data->status == 'todo' ? 'selected' : '' }}>To Do
                                    </option>
                                    <option value="inprogress" {{ $data->status == 'inprogress' ? 'selected' : '' }}>In
                                        Progress</option>
                                    <option value="done" {{ $data->status == 'done' ? 'selected' : '' }}>Completed
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="task_date">Task Started On</label>
                                <div class="input-group date" id="task_date" data-target-input="nearest">
                                    <input type="text" name="task_date" class="form-control datetimepicker-input"
                                        data-target="#task_date" value="{{ $data->task_date ?? '' }}" />
                                    <div class="input-group-append" data-target="#task_date"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="completed_at">Task Completed On</label>
                                <div class="input-group date" id="completed_at" data-target-input="nearest">
                                    <input type="text" name="completed_at"
                                        class="form-control datetimepicker-input" data-target="#completed_at"
                                        value="{{ $data->completed_at ?? '' }}" />
                                    <div class="input-group-append" data-target="#completed_at"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $(function() {
        $('#addDetails').validate({
            rules: {
                status: {
                    required: true
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $('#completed_at').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            icons: {
                time: 'far fa-clock'
            },
            use24hours: true
        });

        $('#task_date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            icons: {
                time: 'far fa-clock'
            },
            use24hours: true
        });
    });
</script>
