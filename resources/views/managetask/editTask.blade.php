<form action="{{ route('managetask.updateTask') }}" method="post" id="editTask" enctype="multipart/form-data">
    @csrf
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="row">
                <input name="id_edit" type="hidden" value="{{ $data->id }}" class="form-control" id="id_edit">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Task Title<span class="text-danger">*</span></label>
                        <input name="title" type="text" class="form-control" value="{{ $data->title }}"
                            id="title" placeholder="Enter Task Title">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Task Due Date:<span class="text-danger">*</span></label>
                        <div class="input-group date" id="edit_due_date" data-target-input="nearest">
                            <input type="text" name="due_date" value="{{ $data->due_date }}"
                                class="form-control datetimepicker-input" data-target="#edit_due_date"
                                placeholder="Select Due Date" />
                            <div class="input-group-append" data-target="#edit_due_date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Task Description<span class="text-danger">*</span></label>
                        <textarea name="description" rows="4" class="form-control" id="description" placeholder="Enter Task Description">{{ $data->description }}</textarea>
                    </div>
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label>Assigned to<span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" style="width: 100%;" name="user_id" id="user_id">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $data->user_id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Task Priority<span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" style="width: 100%;" name="priority" id="priority">
                            <option value="High" {{ $data->priority == 'High' ? 'selected' : '' }}>High</option>
                            <option value="Medium" {{ $data->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="Low" {{ $data->priority == 'Low' ? 'selected' : '' }}>Low</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(function() {
        $('#editTask').validate({
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
        $('#edit_due_date').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>
