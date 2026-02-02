@extends('Admin.layouts.main')

@section('styles')
    <style>
    /* Force table to fit container */
    .pnr-table {
        table-layout: fixed;
        width: 100%;
        font-size: 14px;
    }

    .pnr-table th,
    .pnr-table td {
        white-space: normal;
        word-wrap: break-word;
        padding: 6px;
        vertical-align: middle;
    }

    .pnr-table th {
        text-align: center;
    }

    .pnr-table td {
        text-align: center;
    }
    .table-height{
        height: 100vh;
    }


</style>


@endsection

@section('content')
    @livewire('admin.pnr.pnr-list')
@endsection

@section('scripts')
<script>
    
    function putOnSaleAndCancel(id, type, message) {
        
        let swalOptions = {
            title: "Are you sure?",
            text: message,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            reverseButtons: true
        };

        // 👇 Show input ONLY for cancel
        if (type === 'cancel') {
            swalOptions.input = 'text';
            swalOptions.inputPlaceholder = 'Enter cancel reason';
            swalOptions.inputValidator = (value) => {
                if (!value) {
                    return 'Cancel reason is required';
                }
            };
        }

        Swal.fire(swalOptions).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({
                    title: "Processing...",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('admin.pnr.sale.cancel') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        id: id,
                        type: type,
                        reason: type === 'cancel' ? result.value : null
                    },
                    success: function (res) {
                        Swal.fire("Success", res.message, "success")
                            .then(() => {
                                window.location.href = "{{ route('admin.pnr.index') }}";
                            });
                    },
                    error: function (xhr) {
                        Swal.fire(
                            "Error",
                            xhr.responseJSON?.message || "Something went wrong",
                            "error"
                        );
                    }
                });
            }
        });
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

</script>
@endsection




