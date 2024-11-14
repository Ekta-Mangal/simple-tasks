<form action="{{ route('manageuser.postadd') }}" method="post" id="addUser" enctype="multipart/form-data">
    @csrf
    <div class="card card-primary card-outline">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">User Name<span class="text-danger">*</span></label>
                        <input name="name" type="name" class="form-control" id="name"
                            placeholder="Enter User Name">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">User Email ID<span class="text-danger">*</span></label>
                        <input name="email" type="email" class="form-control" id="email"
                            placeholder="Enter User Email ID">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>User Role<span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" style="width: 100%;" name="role" id="role">
                            <option value="">Select User Role</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">User Password<span class="text-danger">*</span></label>
                        <input name="password" type="password" class="form-control" id="password"
                            placeholder="Enter User Password">
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
        $('#addUser').validate({
            rules: {
                role: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                name: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 6,
                    // Password must contain at least 1 uppercase letter, 1 symbol, 1 lowercase letter, and 1 number
                    pattern: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/
                },
            },
            messages: {
                password: {
                    pattern: "Password must contain at least one uppercase letter, one lowercase letter, one symbol, and one number."
                }
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
