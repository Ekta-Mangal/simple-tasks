divdivdiv<form action="{{ route('manageuser.update') }}" method="post" id="editUser" enctype="multipart/form-data">
    @csrf
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="row">
                <input name="id_edit" type="hidden" value="{{ $data->id }}" class="form-control" id="id_edit">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">User Name<span class="text-danger">*</span></label>
                        <input name="name" type="name" class="form-control" value="{{ $data->name }}"
                            id="name" placeholder="Enter User Name">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">User Email<span class="text-danger">*</span></label>
                        <input name="email" type="email" class="form-control" value="{{ $data->email }}"
                            id="email" placeholder="Enter User Email">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>User Role<span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" style="width: 100%;" name="role" id="role">
                            <option value="Admin" {{ $data->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="User" {{ $data->role == 'User' ? 'selected' : '' }}>User
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">User Password<span class="text-danger">*</span></label>
                        <input name="password" type="password" class="form-control" id="password"
                            placeholder="Leave Blank For Old Password">
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
        $('#editUser').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                name: {
                    required: true
                },
                role: {
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
    });
</script>

<script>
    $(function() {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });
</script>
