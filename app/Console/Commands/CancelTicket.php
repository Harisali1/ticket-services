<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin\Booking;
use App\Models\User;
use App\Models\Admin\Seat;

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
        $startDate = date('Y-m-d 00:00:00', strtotime('-1 day'));
        $endDate = date('Y-m-d 23:59:59', strtotime('-1 day'));
        
        $todayBookings = Booking::whereBetween('created_at',[$startDate,$endDate])->where('status', 1)->get();

        foreach($todayBookings as $booking){
            $updatedTotalAmount = $booking->user->total_amount-$booking->total_amount;
            User::find($booking->user->id)->update([
                'total_amount' => $updatedTotalAmount
            ]);
            
            $booking->update([
                'status' => 5
            ]);

            Seat::where('pnr_id', $booking->pnr->id)
                ->where('is_reserved', 1)
                ->where('is_sale', 0)
                ->where('is_sold', 0)
                ->where('is_cancel', 0)
                ->limit($booking->seats)
                ->update([
                    'is_sale' => 1,
                    'is_reserved' => 0,
                ]);

        }
    }
}
