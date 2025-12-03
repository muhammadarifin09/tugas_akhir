<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MidtransReconcile extends Command
{
    protected $signature = 'midtrans:reconcile';
    protected $description = 'Sync pending transactions from Midtrans';

    public function handle()
    {
        $this->info("Running reconciliation...");
        return Command::SUCCESS;
    }
}
