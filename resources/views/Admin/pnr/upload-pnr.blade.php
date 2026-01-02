@extends('Admin.layouts.main')

@section('styles')
    <style>
    .select2-container .select2-selection--single {
        height: 38px;
    }
    .select2-selection__rendered {
        line-height: 34px!important;
    }
    .select2-selection__arrow {
        height: 38px;
    }
    </style>
@endsection
@section('content')
<div class="container">

    <hr>
    <!-- Content -->
    <div class="card p-4">

        <!-- Form -->
        <form id="pnr-form" enctype="multipart/form-data">
            <h5 class="mb-3">Upload Pnr</h5>
            <!-- Upload Section -->
            <div class="mt-5">
                <h6 class="fw-semibold text-secondary mb-3">
                    Upload PNR Document
                </h6>

                <div id="pnr-dropzone"
                     class="border border-2 border-dashed rounded p-4 bg-white d-flex align-items-center justify-content-between cursor-pointer">

                    <div class="d-flex align-items-center gap-3">
                        <div class="border rounded d-flex align-items-center justify-content-center fs-4"
                             style="width:48px;height:48px;">
                            📄
                        </div>

                        <div>
                            <p id="pnr-filename" class="mb-1 text-muted">
                                Click or drop file here
                            </p>
                            <small class="text-muted">
                                CSV file only (Max 5MB)
                            </small>
                        </div>
                    </div>

                    <button type="button"
                            id="pnr-remove"
                            class="btn btn-link text-danger fs-4 d-none">
                        🗑
                    </button>

                    <input type="file"
                            id="pnr_file"
                            name="pnr_file"
                            class="d-none"
                            accept=".csv,text/csv">

                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="d-flex justify-content-end gap-3 mt-5">
                <button type="button" class="btn btn-outline-secondary">
                    Cancel
                </button>
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

    document.addEventListener("DOMContentLoaded", function () {
        const dropzone = document.getElementById('pnr-dropzone');
        const fileInput = document.getElementById('pnr_file');
        const fileName  = document.getElementById('pnr-filename');
        const removeBtn = document.getElementById('pnr-remove');
        const allowedTypes = [
                'text/csv',
                'application/vnd.ms-excel' // some browsers use this for csv
            ];


        dropzone.addEventListener('click', () => fileInput.click());
        fileInput.addEventListener('change', function () {
            if (!this.files.length) return;
            const file = this.files[0];
            if (!allowedTypes.includes(file.type) && !file.name.toLowerCase().endsWith('.csv')) {
                showError('Only CSV files are allowed');
                this.value = '';
                return;
            }


            if (file.size > 5242880) { // 5MB
                showError('Max file size is 5MB');
                this.value = '';
                return;
            }

            fileName.textContent = file.name;
            removeBtn.classList.remove('hidden');
        });

        /* ============================
        Drag & Drop
        ============================ */
        dropzone.addEventListener('dragover', e => {
            e.preventDefault();
            dropzone.classList.add('border-black');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-black');
        });

        dropzone.addEventListener('drop', e => {
            e.preventDefault();
            dropzone.classList.remove('border-black');

            const file = e.dataTransfer.files[0];
            fileInput.files = e.dataTransfer.files;
            fileInput.dispatchEvent(new Event('change'));
        });

        /* ============================
        Remove File
        ============================ */
        removeBtn.addEventListener('click', e => {
            e.stopPropagation();
            fileInput.value = '';
            fileName.textContent = 'Click or drop file here';
            removeBtn.classList.add('hidden');
        });

    });

    document.getElementById("pnr-form").addEventListener("submit", function (e) {
        e.preventDefault();

    // Collect form values
        const formData = {
            pnr_file: document.getElementById("pnr_file").files[0] ?? null,
        };

        // Validation rules
        const validations = [
            { field: "pnr_file", message: "PNR document is required", test: v => v !== null },

            // File size ≤ 5MB
            { 
                field: "pnr_file",
                message: "File size must be under 5MB",
                test: v => !v || v.size <= 5242880
            },

            // File type validation
            {
                field: "pnr_file",
                message: "Invalid file format (CSV only)",
                test: v => !v || /\.csv$/i.test(v.name)
            }

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

        const newFormData = new FormData();
        newFormData.append("pnr_file", formData.pnr_file);

        // Submit form normally after validation
        $.ajax({
            url: "{{ route('admin.pnr.upload.submit') }}",
            type: "POST",
            data: newFormData,
            processData: false, // IMPORTANT
            contentType: false, // IMPORTANT
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
                        window.location.href = "{{ route('admin.pnr.index') }}";
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
</script>

@endsection




