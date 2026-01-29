<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Divine Travel</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/sweet_alert/sweetalert2.min.css') }}" rel="stylesheet"/>

    <style>
        html, body {
            height: 100%;
            overflow: hidden; /* 🔴 NO SCROLL */
            background: #f8fafc;
        }

        /* LEFT PANEL */
        .left-panel {
            background: linear-gradient(180deg, #0f172a, #1e293b);
            color: #fff;
        }

        .brand-btn {
            background: #fff;
            color: #0f172a;
            font-weight: 700;
            padding: 8px 30px;
            border-radius: 30px;
            border: none;
        }

        .left-content {
            max-width: 380px;
        }

        .left-content img {
            max-width: 240px;
        }

        /* RIGHT PANEL */
        .register-box {
            background: #fff;
            border-radius: 18px;
            padding: 28px 32px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.12);
            width: 100%;
            max-width: 520px;
        }

        .register-box h3 {
            font-weight: 700;
            color: #0f172a;
            font-size: 22px;
        }

        .form-control {
            height: 40px;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: none;
        }

        .signup-btn {
            height: 44px;
            border-radius: 10px;
            font-weight: 600;
            background: #2563eb;
            border: none;
            font-size: 15px;
        }

        .signup-btn:hover {
            background: #1d4ed8;
        }

        .terms {
            font-size: 13px;
        }

        @media(max-width: 991px) {
            html, body {
                overflow-y: auto;
            }
        }
    </style>
</head>

<body>

<div class="container-fluid h-100">
    <div class="row h-100">

        <!-- LEFT -->
        <div class="col-md-6 d-flex flex-column justify-content-between align-items-center py-5 left-panel">

            <button class="brand-btn mt-3">Divine Travel</button>

            <div class="text-center px-4">
                <img src="{{ asset('images/register.png') }}" class="img-fluid travel-image mb-4" alt="Travel">
                <h5 class="fw-semibold">{{ __('messages.your_journey_start_here')}}</h5>
                <p class="small text-light opacity-75">
                    Register to manage airline bookings, PNRs and payments
                </p>
            </div>

            <div class="d-flex gap-4 left-links">
                <a href="{{ route('login')}}">{{ __('messages.sign_in')}}</a>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-md-6 d-flex align-items-center justify-content-center px-3">

            <div class="register-box">
                <div class="d-flex justify-content-end mb-2 lang-switch">
                    <a href="{{ route('language.switch', 'en') }}" class="language-flag" title="English">
                        <img src="https://flagcdn.com/w20/gb.png" alt="English">
                    </a> &nbsp; | &nbsp; 
                    <a href="{{ route('language.switch', 'it') }}" class="language-flag" title="Italian">
                        <img src="https://flagcdn.com/w20/it.png" alt="Italian">
                    </a> &nbsp; | &nbsp;
                    <a href="{{ route('language.switch', 'fr') }}" class="language-flag" title="French">
                        <img src="https://flagcdn.com/w20/fr.png" alt="French">
                    </a>
                </div>
                <div class="col-md-12 text-center">
                    <img 
                        src="{{ asset('images/logo.jpg') }}"
                        alt="Logo"
                        style="width:80px;height:80px;"
                        class="rounded border"
                    >
                </div>
                <h3 class="text-center mb-3">{{ __('messages.create_account')}}</h3>

                <form id="registerForm">

                    <!-- ROW 1 -->
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text" name="name" id="name" class="form-control" placeholder="{{__('messages.name')}}">
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" id="email" class="form-control" placeholder="{{__('messages.email')}}">
                        </div>
                    </div>

                    <!-- ROW 2 -->
                    <div class="row g-2 mt-1">
                        <div class="col-md-6">
                            <input type="text" name="phone_no" id="phone_no" class="form-control" placeholder="{{__('messages.phone_no')}}">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="piv" id="piv" class="form-control" placeholder="{{__('messages.piva')}}">
                        </div>
                    </div>

                    <!-- ROW 3 -->
                    <div class="row g-2 mt-1">
                        <div class="col-md-6">
                            <input type="text" name="business_name" id="business_name" class="form-control" placeholder="{{__('messages.business_name')}}">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="business_address" id="business_address" class="form-control" placeholder="{{__('messages.business_address')}}">
                        </div>
                    </div>

                    <!-- ROW 4 -->
                    <div class="row g-2 mt-1">
                        <div class="col-md-6">
                            <input type="password" name="password" id="password" class="form-control" placeholder="{{__('messages.password')}}">
                        </div>
                        <div class="col-md-6">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{__('messages.confirm_password')}}">
                        </div>
                    </div>

                    <div class="form-check mt-2 terms">
                        <input class="form-check-input" type="checkbox" id="term-cond">
                        <label class="form-check-label">
                           {{ __('messages.i_agree_to')}}
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                {{ __('messages.terms_condition')}}
                            </a>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary signup-btn w-100 mt-3">
                        {{ __('messages.create_account')}}
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- TERMS & CONDITIONS MODAL -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg">

            <!-- Header -->
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="modal-title fw-bold text-dark">
                    Terms & Conditions
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 py-2" style="max-height: 60vh; overflow-y: auto;">
                <p class="text-muted small">
                    Welcome to <strong>Divine Travel</strong>. By creating an account, you agree to the following
                    terms and conditions. Please read them carefully.
                </p>

                <h6 class="fw-semibold mt-3">1. Account Registration</h6>
                <p class="small text-muted">
                    You must provide accurate and complete information during registration.
                    Your account will remain under approval until verified by our team.
                </p>

                <h6 class="fw-semibold mt-3">2. Use of Services</h6>
                <p class="small text-muted">
                    Our platform is intended for managing airline bookings, PNRs, and payments.
                    Any misuse, fraudulent activity, or violation may result in account suspension.
                </p>

                <h6 class="fw-semibold mt-3">3. Payments & Transactions</h6>
                <p class="small text-muted">
                    All transactions must comply with applicable laws and regulations.
                    Divine Travel is not responsible for delays caused by third-party providers.
                </p>

                <h6 class="fw-semibold mt-3">4. Data & Privacy</h6>
                <p class="small text-muted">
                    We respect your privacy and protect your data in accordance with our privacy policy.
                    Your information will not be shared without consent.
                </p>

                <h6 class="fw-semibold mt-3">5. Modifications</h6>
                <p class="small text-muted">
                    Divine Travel reserves the right to modify these terms at any time.
                    Continued use of the platform constitutes acceptance of updated terms.
                </p>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    Close
                </button>
                <button 
                    type="button" class="btn btn-primary rounded-pill px-4" data-bs-dismiss="modal"
                    onclick="acceptTerms()"
                >
                    I Agree
                </button>

            </div>

        </div>
    </div>
</div>


<!-- SCRIPTS (UNCHANGED) -->
<script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendors/sweet_alert/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script>
function acceptTerms() {
    document.getElementById('term-cond').checked = true;

    // Close modal
    const modal = bootstrap.Modal.getInstance(
        document.getElementById('exampleModal')
    );
    modal.hide();
}
</script>

<!-- 🔒 YOUR EXISTING AJAX CODE GOES HERE (AS IS) -->
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

    const formData = {
        name: $("#name").val().trim(),
        email: $("#email").val().trim(),
        phone_no: $("#phone_no").val().trim(),
        piv: $("#piv").val().trim(),
        business_name: $("#business_name").val().trim(),
        business_address: $("#business_address").val().trim(),
        password: $("#password").val().trim(),
        password_confirmation: $("#password_confirmation").val().trim(),
        term_cond: $("#term-cond").is(":checked")
    };

    const validations = [
        { f: "name", m: "Name is required" },
        { f: "email", m: "Email is required" },
        { f: "phone_no", m: "Phone number is required" },
        { f: "piv", m: "P.IVA is required" },
        { f: "business_name", m: "Business name is required" },
        { f: "business_address", m: "Business address is required" },
        { f: "password", m: "Password is required" },
        { f: "password_confirmation", m: "Confirm password is required" }
    ];

    for (let v of validations) {
        if (!formData[v.f]) {
            showError(v.m);
            valid = false;
            break;
        }
    }

    if (!valid) return;

    if (formData.password !== formData.password_confirmation) {
        showError("Passwords do not match");
        return;
    }

    if (!formData.term_cond) {
        showError("Please accept Terms & Conditions");
        return;
    }

    Swal.fire({
        title: "Processing...",
        didOpen: () => Swal.showLoading()
    });

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $.ajax({
        url: "{{ route('register') }}",
        type: "POST",
        data: $("#registerForm").serialize(),
        dataType: "json",
        success: function(res) {
            Swal.close();
            Swal.fire({
                icon: "success",
                text: "You have been successfully registered, and an email has been sent to you. Your account is currently under approval. Once it is approved, you will receive a confirmation email.",
                timer: 9000,
                showConfirmButton: false
            });
        },
        error: function(xhr) {
            Swal.close();
            showError(xhr.responseJSON?.message || "Something went wrong");
        }
    });
});
</script>
</body>
</html>
