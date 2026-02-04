<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin\Booking;

class CancelTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:cancel-ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Canceled Today Ticket';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startDate = date('Y-m-d 00:00:00');
        $endDate = date('Y-m-d 23:59:59');
        
        $todayBookings = Booking::whereBetween('created_at',[$startDate,$endDate])->where('status', 1)->get();

        foreach($todayBookings as $booking){

        }

        $booking = Booking::find($booking->id);
                $user = auth()->user();
                $updatedTotalAmount = $user->total_amount-$booking->total_amount;
                User::find($user->id)->update([
                    'total_amount' => $updatedTotalAmount
                ]);
        dd($todayBookings);
    }
}
