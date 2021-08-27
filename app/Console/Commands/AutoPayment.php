<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\Charge;
use App\Services\ChargeService;


class AutoPayment extends Command
{
    protected $chargeSer;

    // public function __construct(ChargeService $chargeSer) {
    //     $this->chargeSer = $chargeSer;
    // }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:autoPayment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto monthly payment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ChargeService $chargeSer)
    {
        parent::__construct();
        $this->chargeSer = $chargeSer;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->chargeSer->chargeMonthlyPayment();
        return 0;
    }
}
