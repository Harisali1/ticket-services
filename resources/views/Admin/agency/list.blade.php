@extends('Admin.layouts.main')

@section('styles')
<style>
    .stat-card:hover {
        cursor: pointer;
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.08);
    }
    .stat-card {
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.08);
    }

    .table tbody tr:hover {
        background-color: #f9fafb;
    }
    .table-height{
        height: 100vh;
    }
    .delete-button{
        cursor: pointer;
    }
</style>
@endsection

@section('content')
    @livewire('admin.agency.agency-list')
@endsection

@section('scripts')
<script>
    document.addEventListener('open-password-modal', () => {
        const modal = new bootstrap.Modal(document.getElementById('passwordModal'));
        modal.show();
    });

    function deleteAgency(id){

        let url = "{{ route('admin.agency.destroy', ':id') }}";
        url = url.replace(':id', id);   

        Swal.fire({
            title: "Are you sure?",
            text: 'Do you want to delete this Agency?',
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({
                    title: "Processing...",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: url,
                    type: "GET",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        if(res.code == 2){
                            Swal.fire(
                                "Warning",
                                res.message,
                                "error"
                            );
                        }else{
                            Swal.fire("Success", res.message, "success");
                            window.location.href = "{{ route('admin.agency.index') }}";
                        }
                        
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
</script>

@endsection




