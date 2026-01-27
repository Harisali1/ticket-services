@extends('Admin.layouts.main')

@section('styles')
<style>
    .b-action-btn {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        width: auto !important;
        white-space: nowrap;
    }
    .stat-card {
        transition: all 0.2s ease-in-out;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,.08);
    }

</style>
@endsection

@section('content')
    @livewire('admin.booking.booking-list')
@endsection

@section('scripts')
<script>
function initSelect2(id, url) {
        $(id).select2({
            dropdownParent: $('#filterSidebar'), // ⭐ IMPORTANT
            placeholder: 'Search Airline',
            allowClear: true,
            minimumInputLength: 2,
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: item.label
                        }))
                    };
                }
            }
        });
    }


   $(document).ready(function () {
        initSelect2('#airline_id', "{{ route('search.airline') }}");

    });
</script>

@endsection




