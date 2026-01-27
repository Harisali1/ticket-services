<?php

namespace App\Exports;

use App\Models\Admin\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $filters;
    protected $user;

    public function __construct($filters, $user)
    {
        $this->filters = $filters;
        $this->user    = $user;
    }

    public function query()
    {
        return Booking::query()
            ->with(['pnr', 'customers', 'payable'])
            ->when($this->user->user_type_id != 1, fn ($q) =>
                $q->where('created_by', $this->user->id)
            )->when($this->filters['pnr_no'], fn ($q) =>
                $q->whereHas('pnr', fn ($pnr) =>
                    $pnr->where('pnr_no', 'like', '%' . $this->filters['pnr_no'] . '%')
                )
            )
            ->when($this->filters['booking_no'], fn ($q) =>
                $q->where('booking_no', 'like', '%' . $this->filters['booking_no'] . '%')
            )
            ->when($this->filters['status'] !== '', fn ($q) =>
                $q->where('status', $this->filters['status'])
            )
            ->when($this->filters['from'], fn ($q) =>
                $q->whereDate('created_at', '>=', $this->filters['from'])
            )
            ->when($this->filters['to'], fn ($q) =>
                $q->whereDate('created_at', '<=', $this->filters['to'])
            )
            ->latest();
    }

    public function headings(): array
    {
        return [
            'Booking No',
            'PNR No',
            'Customer Name',
            'Passport No',
            'Seat No',
            'Departure Date',
            'Arrival Date',
            'Paid By',
            'Paid At',
            'Status',
        ];
    }

    public function map($booking): array
    {
        $rows = [];

        foreach ($booking->customers as $customer) {
            $rows[] = [
                $booking->booking_no,
                $booking->pnr?->pnr_no,
                $customer->name,
                $customer->passport_no,
                $customer->seat_no,
                $booking->pnr?->departure_date,
                $booking->pnr?->arrival_date,
                optional($booking->payable)->name,
                $booking->paid_at,
                $booking->status->label(),
            ];
        }

        return $rows;
    }
}

