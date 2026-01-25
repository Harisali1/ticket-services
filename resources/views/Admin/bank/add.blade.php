@extends('Admin.layouts.main')

@section('styles')
<style>
    body {
        background: #f1f3f5;
    }
    table th {
        width: 30%;
        background: #f8f9fa;
    }
</style>
@endsection

@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.bank.index') }}" class="text-decoration-none text-secondary">
                &larr;
            </a>
            <h1 class="h4 mb-0">Create Bank Details</h1>
        </div>
    </div>

    <hr>

    <!-- Table Form -->
    <div class="card p-4">
        <form id="bank-form">

            <table class="table table-bordered align-middle">
                <tbody>

                    <tr>
                        <th>Bank Name *</th>
                        <td>
                            <input type="text" name="bank_name" id="bank_name"
                                   class="form-control"
                                   placeholder="Enter Bank Name">
                        </td>
                    </tr>

                    <tr>
                        <th>Account Title *</th>
                        <td>
                            <input type="text" name="ac_title" id="ac_title"
                                   class="form-control"
                                   placeholder="Enter Account Title">
                        </td>
                    </tr>

                    <tr>
                        <th>Swift Code *</th>
                        <td>
                            <input type="text" name="swift_code" id="swift_code"
                                   class="form-control"
                                   placeholder="Enter Swift Code">
                        </td>
                    </tr>

                    <tr>
                        <th>IBAN *</th>
                        <td>
                            <input type="text" name="iban" id="iban"
                                   class="form-control"
                                   placeholder="Enter IBAN">
                        </td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td>
                            <select name="status" id="status" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </td>
                    </tr>

                </tbody>
            </table>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('admin.bank.index') }}" class="btn btn-outline-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-dark">
                    Save
                </button>
            </div>

        </form>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.getElementById('bank-form').addEventListener('submit', function (e) {
    e.preventDefault();

    function error(msg) {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: msg,
            showConfirmButton: false,
            timer: 2500
        });
    }

    const data = {
        bank_name: bank_name.value.trim(),
        ac_title: ac_title.value.trim(),
        swift_code: swift_code.value.trim(),
        iban: iban.value.trim(),
        status: status.value
    };

    const rules = [
        ['bank_name', 'Bank name is required'],
        ['ac_title', 'Account title is required'],
        ['swift_code', 'Swift Code is required'],
        ['iban', 'IBAN is required']
    ];

    for (const [field, message] of rules) {
        if (!data[field]) {
            error(message);
            return;
        }
    }

    Swal.fire({
        title: 'Saving...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: "{{ route('admin.bank.store') }}",
        type: "POST",
        data: $('#bank-form').serialize(),
        dataType: "json",
        success: function (res) {
            Swal.close();
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: res.message,
                showConfirmButton: true
            });
            window.location.href = "{{ route('admin.bank.create') }}";
        },
        error: function (xhr) {
            Swal.close();
            error(xhr.responseJSON?.message || 'Something went wrong');
        }
    });
});
</script>
@endsection
