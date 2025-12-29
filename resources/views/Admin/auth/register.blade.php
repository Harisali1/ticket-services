<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Now</title>

    <!-- Bootstrap 5 -->
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/sweet_alert/sweetalert2.min.css') }}"  rel="stylesheet"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            height: 100vh;
        }
        
        .left-panel {
            background: #e0e0e0;
        }

        .airline-btn {
            background: #fff;
            border-radius: 8px;
            padding: 10px 40px;
            /* box-shadow: 0 4px 8px rgba(0,0,0,.1); */
            font-weight: 600;
        }

        .image-placeholder {
            width: 240px;
            height: 240px;
            background: #d0d0d0;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-placeholder i {
            font-size: 80px;
            color: #a0a0a0;
        }

        .form-control {
            height: 42px;
        }

        .password-eye {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }

        .signup-btn {
            background: #b3b3b3;
            color: #fff;
            height: 48px;
            border-radius: 6px;
        }

        .signup-btn:hover {
            background: #9e9e9e;
        }
    </style>
</head>
<body>

<div class="container-fluid h-100">
    <div class="row h-100">

        <!-- LEFT SIDE -->
        <div class="col-md-6 d-flex flex-column justify-content-between align-items-center py-5 left-panel">

            <div>
                <button class="airline-btn">Airline</button>
            </div>

            <div class="image-placeholder">
                <i class="bi bi-image"></i>
            </div>

            <div class="d-flex gap-4 small text-muted">
                <a href="#" class="text-decoration-none text-muted">Sign In</a>
                <a href="#" class="text-decoration-none text-muted">Need help?</a>
                <a href="#" class="text-decoration-none text-muted">Contact admin</a>
            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">

            <div class="w-75">
                <h3 class="text-center mb-4 fw-semibold">Register Now</h3>

                <form id="registerForm">

                    <input type="text" name="name" id="name" placeholder="Name" class="form-control mb-3">

                    <input type="email" name="email" id="email" placeholder="Email" class="form-control mb-3">

                    <input type="text" name="phone_no" id="phone_no" placeholder="Phone No." class="form-control mb-3">

                    <input type="text" name="piv" id="piv" placeholder="P.IVA" class="form-control mb-3">

                    <input type="text" name="business_name" id="business_name" placeholder="Business Name" class="form-control mb-3">

                    <input type="text" name="business_address" id="business_address" placeholder="Business Address" class="form-control mb-3">

                    <input type="password" name="password" id="password" placeholder="Password" class="form-control mb-3">

                    <input type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="Confirm Password" class="form-control mb-4">

                    <button type="submit" class="btn btn-dark w-100">Sign Up</button>
                </form>

            </div>

        </div>
    </div>
</div>
<script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendors/sweet_alert/sweetalert2.all.min.js') }}" ></script>
<script>
document.getElementById("registerForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let valid = true;

    function showError(message) {
        Swal.fire({
            toast: true,
            position: "top-end",
            icon: "error",
            title: message,
            showConfirmButton: false,
            timer: 2500
        });
    }

    // Grab values
    const formData = {
        name: document.getElementById("name").value.trim(),
        email: document.getElementById("email").value.trim(),
        phone: document.getElementById("phone_no").value.trim(),
        piv: document.getElementById("piv").value.trim(),
        business_name: document.getElementById("business_name").value.trim(),
        business_address: document.getElementById("business_address").value.trim(),
        password: document.getElementById("password").value.trim(),
        password_confirmation: document.getElementById("password_confirmation").value.trim(),
    };

    // Validation rules
    const validations = [
        { field: "name", message: "Name is required", test: v => v !== "" },
        { field: "email", message: "Email is required", test: v => v !== "" },
        { field: "email", message: "Invalid email format", test: v => /^\S+@\S+\.\S+$/.test(v) },
        { field: "phone_no", message: "Phone number is required", test: v => v !== "" },
        { field: "piv", message: "P.IVA is required", test: v => v !== "" },
        { field: "business_name", message: "Business name is required", test: v => v !== "" },
        { field: "business_address", message: "Business address is required", test: v => v !== "" },
        { field: "password", message: "Password is required", test: v => v !== "" },
        { field: "password_confirmation", message: "Confirm password is required", test: v => v !== "" },
        {
            field: "password_confirmation",
            message: "Passwords do not match",
            test: v => v === formData.password
        },
    ];

    for (const rule of validations) {
        if (!rule.test(formData[rule.field])) {
            showError(rule.message);
            valid = false;
            break;
        }
    }

    if (!valid) return;

    // Loader
    Swal.fire({
        title: "Processing...",
        text: "Please wait",
        didOpen: () => Swal.showLoading()
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "{{ route('register') }}",
        method: "POST",
        data: $('#registerForm').serialize(),
        dataType: "json",
        success: function(response) {
            Swal.close();
            window.location.href = "{{ route('admin.dashboard') }}";
        },
        error: function(xhr) {
            Swal.close();
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: "error",
                title: xhr.responseJSON.message ?? "Something went wrong",
                showConfirmButton: false,
                timer: 9500
            });
        }
    });

});
</script>

</body>
</html>
