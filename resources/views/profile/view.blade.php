@extends('include.master')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary card-outline">
                            <div class="card-header text-center">
                                <h5 class="card-title">User Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-3">
                                    @if (isset($user->photo) && $user->photo)
                                        <img src="{{ asset($user->photo) }}" alt="User Avatar" class="img-circle img-fluid"
                                            style="width: 100px; height: 100px;">
                                    @else
                                        <i class="nav-icon fas fa-user" style="font-size: 3rem; color: black;"></i>
                                    @endif
                                </div>

                                <table class="table table-bordered">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $user->email ?? 'No Email Available' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <td>{{ $user->role }}</td>
                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <td>
                                            <button type="button" class="btn btn-primary" id="changePasswordBtn">Change
                                                Password</button>
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <!-- Password Change Form (Hidden initially) -->
                                <div id="passwordChangeForm" style="display: none;">
                                    <div>
                                        <label><span class="text-danger"> :- Password must contain at least one uppercase
                                                letter, one lowercase letter, one symbol, and one number</span></label>
                                    </div><br>
                                    <form action="{{ route('changePassword') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="password">New Password</label>
                                            <input type="password" name="password" id="password" class="form-control"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirm Password</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                class="form-control" required>
                                            <small id="passwordMatchMessage" class="text-danger"
                                                style="display: none;">Passwords do not match!</small>
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-primary" id="submitButton" disabled>Update
                                                Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-primary card-outline">
                            <div class="card-header text-center">
                                <h5 class="card-title">Contact Information</h5>
                            </div>
                            <div class="card-body">
                                @if ($user->contact)
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Address Line 1</th>
                                            <td>
                                                {{ $user->contact->address1 ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Address Line 2</th>
                                            <td>
                                                {{ $user->contact->address2 ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Address Line 3</th>
                                            <td>
                                                {{ $user->contact->address3 ?? '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $user->contact->phone ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Mobile</th>
                                            <td>{{ $user->contact->mobile ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Country</th>
                                            <td>{{ $user->contact->country->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Country Code</th>
                                            <td>{{ $user->contact->country->code ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>ISD Code</th>
                                            <td>{{ $user->contact->country->isd_code ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Postcode</th>
                                            <td>{{ $user->contact->postcode ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                @else
                                    <div class="alert alert-danger text-center">
                                        No contact information available
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle password form
        document.getElementById('changePasswordBtn').addEventListener('click', function() {
            var form = document.getElementById('passwordChangeForm');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        });

        // Real-time password match validation
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const passwordMatchMessage = document.getElementById('passwordMatchMessage');
        const submitButton = document.getElementById('submitButton');

        confirmPasswordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            if (!passwordPattern.test(password)) {
                passwordMatchMessage.textContent = "Password must meet the required criteria.";
                passwordMatchMessage.style.display = 'block';
                submitButton.disabled = true;
            } else if (password !== confirmPassword) {
                passwordMatchMessage.textContent = "Passwords do not match!";
                passwordMatchMessage.style.display = 'block';
                submitButton.disabled = true;
            } else {
                passwordMatchMessage.style.display = 'none';
                submitButton.disabled = false;
            }
        });

        // Display Toastr notifications for Laravel validation errors
        $(document).ready(function() {
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}", "Validation Error", {
                        closeButton: true,
                        progressBar: true,
                        timeOut: 1000,
                        onHidden: function() {
                            location.reload();
                        }
                    });
                @endforeach
            @endif
        });
    </script>
@endsection
