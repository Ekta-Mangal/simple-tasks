<form action="{{ route('managetask.postTask') }}" method="post" id="addTask" enctype="multipart/form-data">
    @csrf
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Task Title<span class="text-danger">*</span></label>
                        <input name="title" type="text" class="form-control" id="title"
                            placeholder="Enter Task Title Here...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Task Due Date:<span class="text-danger">*</span></label>
                        <div class="input-group date" id="due_date" data-target-input="nearest">
                            <input type="text" name="due_date" class="form-control datetimepicker-input"
                                data-target="#due_date" />
                            <div class="input-group-append" data-target="#due_date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Task Description<span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" id="description" rows="4"
                            placeholder="Enter Task Description Here..."></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Assigned To<span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" style="width: 100%;" name="user_id" id="user_id">
                            <option value="">Select Assigned To</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Task Priority<span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" style="width: 100%;" name="priority" id="priority">
                            <option value="">Select Task Priority</option>
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(function() {
        $('#addTask').validate({
            rules: {
                title: {
                    required: true
                },
                description: {
                    required: true
                },
                due_date: {
                    required: true
                },
                priority: {
                    required: true
                },
                user_id: {
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
        $('#due_date').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>
