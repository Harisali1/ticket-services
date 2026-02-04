<div class="container py-4">

    <!-- Per Page Selector -->
    <div class="mb-3">
        <select wire:model.live="perPage" class="form-select w-auto">
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>

    <!-- Table -->
    <div class="mb-4">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr><th>
                        <input type="checkbox" id="selectAll">
                    </th>
                    <th>{{__('messages.booking_no')}}</th>
                    <th>{{__('messages.total_amount')}}</th>
                    <th>{{__('messages.partial_pay_amount')}}</th>
                    <th>{{__('messages.payable_amount')}}</th>
                    <th>{{__('messages.paid_at')}}</th>
                    <th>{{__('messages.created_on')}}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingPayment as $payment)
                    <tr>
                        <td>
                            <input type="checkbox"
                                class="booking-checkbox"
                                value="{{ $payment->id }}"
                                data-payable="{{ $payment->total_amount - $payment->partial_pay_amount - $payment->admin_fee }}">
                        </td>
                        <td>{{ $payment->booking_no }}</td>
                        <td>{{ $payment->total_amount }}</td>
                        <td>{{ $payment->partial_pay_amount }}</td>
                        <td>{{ $payment->total_amount - $payment->partial_pay_amount - $payment->admin_fee }}</td>
                        <td>{{ $payment->paid_at }}</td>
                        <td>{{ $payment->created_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No payment found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div>
        {{ $pendingPayment->links() }}
    </div>
</div>


