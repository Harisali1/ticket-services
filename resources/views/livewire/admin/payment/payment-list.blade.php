<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">{{__('messages.payment_list')}}</h1>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.payment.create') }}" class="btn btn-dark">
                + {{__('messages.create_payment')}}
            </a>

            <!-- Filter button triggers offcanvas -->
            <!-- <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                  <path d="M1.5 1.5a.5.5 0 0 1 .5-.5h12a.5.5 0 0 1 .4.8L10 7.7v5.6a.5.5 0 0 1-.757.429L7 12.101l-2.243 1.628A.5.5 0 0 1 4 12.3V7.7L1.1 2.3a.5.5 0 0 1 .4-.8z"/>
                </svg>
            </button> -->
        </div>
    </div>
<div class="row mb-4">
        <div class="col-md-2">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">{{__('messages.reserved_amount')}}</div>
                    <div class="fw-bold fs-5 text-primary">
                        {{ number_format(auth()->user()->total_amount) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">{{__('messages.ticketed_amount')}}</div>
                    <div class="fw-bold fs-5 text-secondary">
                        {{ number_format(auth()->user()->ticketed_amount) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">{{__('messages.remaining_amount')}}</div>
                    <div class="fw-bold fs-5 text-danger">
                        {{ number_format(auth()->user()->remaining_amount+auth()->user()->on_approval_amount) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">{{__('messages.paid_amount')}}</div>
                    <div class="fw-bold fs-5 text-success">
                        {{ number_format(auth()->user()->paid_amount) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <div class="text-muted small">{{__('messages.on_approval_amount')}}</div>
                    <div class="fw-bold fs-5 text-warning">
                        {{ number_format(auth()->user()->on_approval_amount) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
            <tr>
                <th>{{__('messages.slip_no')}} #</th>
                <th>{{__('messages.image')}}</th>
                <th>{{__('messages.paid_amount')}}</th>
                <th>{{__('messages.paid_by')}}</th>
                <th>{{__('messages.paid_at')}}</th>
                <th>{{__('messages.approved_by')}}</th>
                <th>{{__('messages.approved_at')}}</th>
            </tr>
            </thead>

            <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->slip_no }}</td>
                    <td>
                         <img src="{{ $payment->image 
                                ? asset('storage/'.$payment->image) 
                                : asset('images/logo-placeholder.png') }}"
                                alt="logo"
                                class="rounded-circle border"
                                style="width:45px;height:45px;object-fit:contain;">
                    </td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ (isset($payment->user)) ? $payment->user->name : '' }}</td>
                    <td>{{ $payment->paid_at }}</td>
                    <td>{{ (isset($payment->admin->name)) ? $payment->admin->name : '' }}</td>
                    <td>{{ $payment->approved_at }}</td>
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

</div>

