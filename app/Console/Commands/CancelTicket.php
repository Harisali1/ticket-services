<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        //
    }
}
