<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Payment List</h1>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.payment.create') }}" class="btn btn-dark">
                + Create Payment
            </a>

            <!-- Filter button triggers offcanvas -->
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterSidebar">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-funnel" viewBox="0 0 16 16">
                  <path d="M1.5 1.5a.5.5 0 0 1 .5-.5h12a.5.5 0 0 1 .4.8L10 7.7v5.6a.5.5 0 0 1-.757.429L7 12.101l-2.243 1.628A.5.5 0 0 1 4 12.3V7.7L1.1 2.3a.5.5 0 0 1 .4-.8z"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
            <tr>
                <th>Booking No #</th>
                <th>Booking Amount</th>
                <th>Paid Amount</th>
                <th>Partial Paid Amount</th>
                <th>Paid By</th>
                <th>Paid At</th>
                <th>Approved By</th>
                <th>Approved At</th>
            </tr>
            </thead>

            <tbody>
            @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->booking_no }}</td>
                    <td>{{ $payment->total_amount }}</td>
                    <td>{{ ($payment->payment_status == 3) ? $payment->total_amount : 0}}</td>
                    <td>{{ $payment->partial_pay_amount }}</td>
                    <td>{{ (isset($payment->payable->name)) ? $payment->payable->name : '' }}</td>
                    <td>{{ $payment->paid_at }}</td>
                    <td>
                        {{ (isset($payment->approve->name)) ? $payment->approve->name : 'Pending For Approval' }}
                    </td>
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

