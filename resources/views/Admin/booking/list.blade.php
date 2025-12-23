@extends('Admin.layouts.main')

@section('styles')

@endsection

@section('content')
    @livewire('admin.pnr.pnr-list')
@endsection

@section('scripts')
<script>
    window.addEventListener('open-put-on-sale-modal', () => {
        new bootstrap.Modal(
            document.getElementById('putOnSaleModal')
        ).show();
    });

    window.addEventListener('open-cancel-current-sale-modal', () => {
        new bootstrap.Modal(
            document.getElementById('cancelCurrentSaleModal')
        ).show();
    });

    function closeAndRefresh() {
        $('#putOnSaleModal').modal('hide');
        $('#cancelCurrentSaleModal').modal('hide');
        setTimeout(function () {
            location.reload();
        }, 300);
    }

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

    document.getElementById("put-on-sale").addEventListener("submit", function (e) {
        e.preventDefault();
        // Collect form values
        const formData = {
            seats: document.getElementById("seats").value.trim(),
            price: document.getElementById("price").value.trim(),
        };
        // Validation rules
        const validations = [
            { field: "seats", message: "Seats field is required", test: v => v !== "" },
            { field: "price", message: "Price field is required", test: v => v !== "" }
        ];
        // Run validations
        for (const rule of validations) {
            if (!rule.test(formData[rule.field])) {
                showError(rule.message);
                return;
            }
        }
        // Show loading
        Swal.fire({
            title: "Processing...",
            text: "Please wait",
            didOpen: () => Swal.showLoading()
        });

        var data = $('#put-on-sale').serialize();
        $.ajax({
            url: "{{ route('admin.pnr.seats.store') }}",
            type: "POST",
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                Swal.close();
                window.location.href = "{{ route('admin.pnr.index') }}";
            },
            error: function (xhr) {
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

    document.getElementById("cancel-current-sale").addEventListener("submit", function (e) {
        e.preventDefault();
        // Collect form values
        const formData = {
            price: document.getElementById("comment").value.trim(),
        };
        // Validation rules
        const validations = [
            { field: "price", message: "Comment field is required", test: v => v !== "" }
        ];
        // Run validations
        for (const rule of validations) {
            if (!rule.test(formData[rule.field])) {
                showError(rule.message);
                return;
            }
        }
        // Show loading
        Swal.fire({
            title: "Processing...",
            text: "Please wait",
            didOpen: () => Swal.showLoading()
        });

        var data = $('#cancel-current-sale').serialize();
        $.ajax({
            url: "{{ route('admin.pnr.seats.cancel') }}",
            type: "POST",
            data: data,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                Swal.close();
                window.location.href = "{{ route('admin.pnr.index') }}";
            },
            error: function (xhr) {
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
@endsection




