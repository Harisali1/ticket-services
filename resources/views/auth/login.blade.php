<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign In</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('vendors/sweet_alert/sweetalert2.min.css') }}"  rel="stylesheet"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body class="bg-gray-100 font-sans">

    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white p-8 rounded-sm border-t-4 border-[#656565] shadow-md">

        <!-- Logo / Title -->
        <div class="text-center mb-8">
            <div class="inline-block bg-white px-8 py-3 rounded-xl shadow-md w-60">
                <h2 class="text-lg font-semibold">Airline</h2>
            </div>
        </div>

        <!-- Sign in title -->
        <h1 class="text-center text-2xl font-semibold text-gray-700 mb-6">Sign in</h1>

        <form id="myform">
            <!-- Email -->
            <div class="mb-4">
                <input type="email" id="email" name="email" placeholder="Email" class="w-full border border-gray-200 rounded-sm px-4 py-2 focus:outline-none focus:ring focus:ring-gray-100">
            </div>

            <!-- Password -->
            <div class="mb-4 relative">
                <input type="password" id="password" name="password" placeholder="Password" class="w-full border border-gray-200 rounded-sm px-4 py-2 focus:outline-none focus:ring focus:ring-gray-100">

                <!-- Eye Icon -->
                <div class="absolute right-3 top-2.5 text-gray-600 cursor-pointer">
                    <!-- Heroicon eye -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                        class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 
                            7.36 4.5 12 4.5c4.638 0 8.573 3.007 
                            9.963 7.178.07.207.07.431 0 .639C20.577 
                            16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" 
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>

            <!-- Links -->
            <div class="flex gap-3 justify-center mb-6 text-gray-600 text-sm">
                <a href="#" class="text-gray-600 underline">Forgot Password?</a>
            </div>

            <!-- Sign In button -->
            <button class="w-full bg-[#212121] text-white py-2 rounded-sm hover:bg-gray-500 transition">
                Sign In
            </button>
        </form> 
        <!-- Bottom help text -->
        <p class="text-center text-sm text-gray-600 mt-6">
            Need help? 
            <a href="#" class="text-gray-600 underline">Contact admin</a>
        </p>
    </div>
</div>

<script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendors/sweet_alert/sweetalert2.all.min.js') }}" ></script>


<script>
    document.getElementById("myform").addEventListener("submit", function(e) {
    e.preventDefault();
    let valid = true;
    // Show error in toast
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

    // Grab Values
    const formData = {
        email: document.getElementById("email").value.trim(),
        password: document.getElementById("password").value.trim(),
    };


    // Define validation rules
    const validations = [
        { field: "email", message: "Email is required", test: value => value !== "" },
        { field: "email", message: "Invalid email format", test: value => /^\S+@\S+\.\S+$/.test(value) },
        { field: "password", message: "Password is required", test: value => value !== "" },
    ];

    // Run validations
    for (const rule of validations) {
        if (!rule.test(formData[rule.field])) {
            showError(rule.message);
            valid = false;
            break; // Stop on first error
        }
    }

    if (!valid) return;

    // Continue form submission...


    // AJAX call
    Swal.fire({
        title: "Processing...",
        text: "Please wait",
        didOpen: () => Swal.showLoading()
    });

    var data = $('#myform').serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '<?php echo route('login'); ?>',
                method: 'POST',
                data:data,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function(){
                    $('.error-container').html('');
                },
                success: function(data) {
                        window.location.href = '<?php echo route('home') ?>'

                    // if(data && data.status == 0){
                    //     Swal.fire({
                    //         toast: true,
                    //         position: "top-end",
                    //         icon: "error",
                    //         title: 'hello',
                    //         showConfirmButton: false,
                    //         timer: 2500
                    //     });
                    // }
                    // if (data && data.status == 1) {
                    // } else {
                    //     var errors = (data.errors) ? data.errors : {};
                    //     if (Object.keys(errors).length > 0) {

                    //         var error_key = Object.keys(errors);
                    //         for (var i = 0; i < error_key.length; i++) {
                    //             var fieldName = error_key[i];
                    //             var errorMessage = errors[fieldName];
                    //             if ($('#' + fieldName).length) {
                    //                 var element = $('#' + fieldName);
                    //                 var element_error = `${errorMessage}`;
                    //                 element.next('.error-container').html(element_error);
                    //                 element.focus();
                    //             }
                    //         }
                    //     }

                    // }
                },
                error: function(xhr, textStatus, errorThrown) {
                    Swal.close();
                    // console.log()
                    // if (data.errors) {
                    //     // Extract first message
                    //     let firstError = Object.values(data.errors)[0][0];

                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "error",
                            title: xhr.responseJSON.message,
                            showConfirmButton: false,
                            timer: 2500
                        });

                    //     return;
                    // }
                }
            });
});

</script>
</body>
</html>
