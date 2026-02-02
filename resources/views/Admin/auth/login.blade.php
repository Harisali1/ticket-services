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

<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg border-t-4 border-gray-600 relative">

        <!-- Language Flags (top-right) -->
        <div class="absolute top-4 right-4 flex gap-2">
            <a href="{{ route('language.switch', 'en') }}" class="language-flag" title="English">
                        <img src="https://flagcdn.com/w20/gb.png" alt="English">
                    </a>
                    <a href="{{ route('language.switch', 'it') }}" class="language-flag" title="Italian">
                        <img src="https://flagcdn.com/w20/it.png" alt="Italian">
                    </a>
                    <a href="{{ route('language.switch', 'fr') }}" class="language-flag" title="French">
                        <img src="https://flagcdn.com/w20/fr.png" alt="French">
                    </a>
        </div>

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img 
                src="{{ asset('images/logo.jpg') }}"
                alt="Logo"
                class="w-20 h-20 rounded-full border shadow-sm"
            >
        </div>

        <!-- Heading -->
        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">
                {{__('messages.welcome_back')}}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{__('messages.sign_in_to_your_account')}}
            </p>
        </div>

        <!-- Form -->
        <form id="myform">

            <!-- Email -->
            <div class="mb-4">
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="{{__('messages.email_address')}}"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400"
                >
            </div>

            <!-- Password -->
            <div class="mb-4 relative">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="{{__('messages.password')}}"
                    class="w-full border border-gray-300 rounded-md px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400"
                >

                <!-- Eye Icon -->
                <div class="absolute right-3 top-2.5 text-gray-500 cursor-pointer">
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
            <div class="flex justify-between items-center mb-6 text-sm text-gray-600">
                <a href="{{ route('register') }}" class="hover:underline">
                    {{__('messages.become_an_agent')}}
                </a>
                <a href="{{ route('password.request') }}" class="hover:underline">
                    {{__('messages.forgot_password')}}?
                </a>
            </div>

            <!-- Button -->
            <button 
                class="w-full bg-gray-900 text-white py-2.5 rounded-md text-sm font-medium hover:bg-gray-700 transition">
                {{__('messages.sign_in')}}
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-500 mt-6">
            {{__('messages.need_help')}}?
            <a href="#" class="underline hover:text-gray-700">
                {{__('messages.contact_admin')}}
            </a>
        </p>
    </div>
</div>

</body>



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
            success: function(response, textStatus, xhr) {
                let statusCode = xhr.status; // 200, 401, etc.

                if (statusCode === 204) {
                    window.location.href = '{{ route("admin.dashboard") }}';
                } else {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "error",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                Swal.close();
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: xhr.responseJSON.message,
                    showConfirmButton: false,
                    timer: 2500
                });
            }
        });
    });

</script>
</html>
