@extends('Admin.layouts.main')

@section('styles')

@endsection

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Create Payment</h1>
    </div>

    


    <!-- FORM -->
    <form id="payment-form" enctype="multipart/form-data">

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Total Amount</label>
                <input type="text"
                       name="amount"
                       id="totalAmount"
                       value="{{ auth()->user()->remaining_amount }}"
                       class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label">Upload Image</label>
                <input type="file"
                       name="image"
                       id="image"
                       class="form-control">
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-dark w-100">
                    Submit
                </button>
            </div>
        </div>
    </form>

</div>
@endsection

@section('scripts')
<!-- JS -->
<script>

    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("payment-form");
        form.addEventListener("submit", function (e) {
            e.preventDefault();
            const showError = (message) => {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    icon: "error",
                    title: message,
                    showConfirmButton: false,
                    timer: 5000
                });
            };

            const amount   = document.getElementById("totalAmount").value.trim();
            const image   = document.getElementById("image").files[0] ?? null;

            if (!amount) { showError("amount is required"); return; }
            if (!image) { showError("image is required"); return; }

            const allowedTypes = ["image/jpeg", "image/png", "image/jpg", "application/pdf"];
            if (!allowedTypes.includes(image.type)) { showError("File must be JPG, PNG, or PDF"); return; }
            if (image.size > 2097152) { showError("image size must be less than 2MB"); return; }

            Swal.fire({
                title: "Processing...",
                text: "Please wait",
                didOpen: () => Swal.showLoading(),
                allowOutsideClick: false
            });

            const formData = new FormData(form);

            $.ajax({
                url: "{{ route('admin.payment.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    Swal.close();
                    if(data.code == 2){
                       showError(data.message); 
                    }else{
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "success",
                            title: data.message,
                            showConfirmButton: true,
                            confirmButtonText: "OK"
                        });
                        window.location.href = "{{ route('admin.payment.index') }}";
                    }
                    
                     
                },
                error: function (xhr) {
                    Swal.close();
                    let message = "Something went wrong";
                    if (xhr.responseJSON?.errors) {
                        message = Object.values(xhr.responseJSON.errors)[0][0];
                    } else if (xhr.responseJSON?.message) {
                        message = xhr.responseJSON.message;
                    }
                    showError(message);
                }
            });
        });
    });
</script>
@endsection
