<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Payment List</h1>

        <!-- <div class="d-flex gap-2">
            <a href="{{ route('admin.notification.create') }}" class="btn btn-dark">
                + Create Notification
            </a>

            <button class="btn btn-outline-secondary" type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#filterSidebar">
                Filter
            </button>
        </div> -->
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
            <tr>
                <th width="40">
                    <input type="checkbox" id="checkAll">
                </th>
                <th>Booking No #</th>
                <th>Amount</th>
                <th>Paid By</th>
                <th>Paid At</th>
            </tr>
            </thead>

            <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>
                        <input type="checkbox"
                               class="row-check"
                               value="{{ $payment->booking_id }}"
                               data-amount="{{ $payment->amount }}">
                    </td>

                    <td>{{ $payment->booking->booking_no }}</td>
                    <td>{{ $payment->amount }}</td>

                    <td>
                        {{ $payment->paid_by }}
                    </td>

                    <td>{{ $payment->created_at->format('m/d/Y h:i a') }}</td>

                   
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        No Payments Found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $payments->links() }}

    <!-- FORM -->
    <form id="payment-form" enctype="multipart/form-data">

        <input type="hidden" name="booking_ids" id="booking_ids">

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Total Amount</label>
                <input type="text"
                       name="amount"
                       id="totalAmount"
                       class="form-control"
                       readonly>
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

<!-- JS -->
<script>
    const checkAll = document.getElementById('checkAll');
    const rowChecks = document.querySelectorAll('.row-check');
    const totalAmount = document.getElementById('totalAmount');
    const bookingIdsInput = document.getElementById('booking_ids');

    function updateTotals() {
        let total = 0;
        let ids = [];

        rowChecks.forEach(cb => {
            if (cb.checked) {
                total += parseFloat(cb.dataset.amount);
                ids.push(cb.value);
            }
        });

        totalAmount.value = total;
        bookingIdsInput.value = JSON.stringify(ids);
    }

    checkAll.addEventListener('change', function () {
        rowChecks.forEach(cb => cb.checked = this.checked);
        updateTotals();
    });

    rowChecks.forEach(cb => {
        cb.addEventListener('change', function () {
            checkAll.checked = [...rowChecks].every(c => c.checked);
            updateTotals();
        });
    });

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
                    timer: 9000
                });
            };

            const amount   = document.getElementById("totalAmount").value.trim();
            const image   = document.getElementById("image").files[0] ?? null;

            if (!amount) { showError("Please select at least one booking"); return; }
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
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        icon: "success",
                        title: data.message,
                        showConfirmButton: true,
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('admin.payment.index') }}"; 
                        }
                    });
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
