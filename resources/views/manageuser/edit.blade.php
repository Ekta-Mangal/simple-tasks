<form action="{{ route('manageuser.update') }}" method="post" id="editUser" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Card 1: User Basic Details -->
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">Basic Details</h5>
                </div>
                <div class="card-body">
                    <input name="id_edit" type="hidden" value="{{ $data->id }}" class="form-control"
                        id="id_edit">
                    <div class="form-group">
                        <label for="name">User Name<span class="text-danger">*</span></label>
                        <input name="name" type="text" class="form-control" value="{{ $data->name }}"
                            id="name" placeholder="Enter User Name">
                    </div>
                    <div class="form-group">
                        <label for="email">User Email ID<span class="text-danger">*</span></label>
                        <input name="email" type="email" class="form-control" value="{{ $data->email }}"
                            id="email" placeholder="Enter User Email ID">
                    </div>
                    <div class="form-group">
                        <label>User Role<span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" style="width: 100%;" name="role" id="role">
                            <option value="Admin" {{ $data->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="User" {{ $data->role == 'User' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password">User Password</label>
                        <input name="password" type="password" class="form-control" id="password"
                            placeholder="Leave Blank For Old Password">
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: User Contact Details -->
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title">Contact Details</h5>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="phone">Phone Number<span class="text-danger">*</span></label>
                            <input name="phone" type="text" class="form-control"
                                value="{{ $contactDetails->phone }}" id="phone" placeholder="Enter Phone Number">
                        </div>
                        <div class="col-md-6">
                            <label for="mobile">Mobile Number</label>
                            <input name="mobile" type="text" class="form-control"
                                value="{{ $contactDetails->mobile }}" id="mobile" placeholder="Enter Mobile Number">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="address1">Address Line 1<span class="text-danger">*</span></label>
                            <textarea name="address1" class="form-control" id="address1" placeholder="Enter Address Line 1">{{ $contactDetails->address1 }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="address2">Address Line 2<span class="text-danger">*</span></label>
                            <textarea name="address2" class="form-control" id="address2" placeholder="Enter Address Line 2">{{ $contactDetails->address2 }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="address3">Address Line 3</label>
                            <textarea name="address3" class="form-control" id="address3" placeholder="Enter Address Line 3">{{ $contactDetails->address3 }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="postcode">Post Code<span class="text-danger">*</span></label>
                            <input name="postcode" type="text" class="form-control"
                                value="{{ $contactDetails->postcode }}" id="postcode" placeholder="Enter Post Code">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Country<span class="text-danger">*</span></label>
                        <select class="form-control select2bs4" style="width: 100%;" name="country" id="country">
                            <option value="">Select Country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}"
                                    {{ $contactDetails->country_id == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="text-center mt-3">
        <button name="submit" type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

<script>
    $(function() {
        $('#editUser').validate({
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
                country: {
                    required: true
                },
                postcode: {
                    required: true
                },
                address1: {
                    required: true
                },
                address2: {
                    required: true
                },
                phone: {
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

    $(function() {
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });
    });
</script>
