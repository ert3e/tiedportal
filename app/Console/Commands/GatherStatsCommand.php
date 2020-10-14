<?php

namespace App\Console\Commands;

use App\Models\Statistic;
use Carbon\Carbon;
use \Xero;
use Illuminate\Console\Command;

class GatherStatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:gather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gathers daily rolling stats from Xero accounting system';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('memory_limit','2G');

        for( $i = 52; $i >= 0; $i-- ) {

            $now = Carbon::now();
            $now->subWeek($i);

            $from = clone $now;
            $from->subMonths(12);

            // Total stats
            $total_stats = Xero::invoiceStats($from, $now);
            $total_expenses = Xero::expenseStats($from, $now);

            // Monthly stats
            $from = clone $now;
            $from->startOfMonth();
            $to = clone $from;
            $to->endOfMonth();

            $stats = Xero::invoiceStats($from, $to);
            $expenses = Xero::expenseStats($from, $to);

            $this->info('Gather stats from ' . $from->format('d/m/Y') . ' to ' . $to->format('d/m/Y'));
            
            Statistic::create([
                'date'              => $now,
                'total_invoices'    => $total_stats['count'],
                'total_value'       => $total_stats['total'],
                'total_expenses'    => $total_expenses,
                'expenses'          => $expenses,
                'invoices'          => $stats['count'],
                'value'             => $stats['total']
            ]);

            $this->info('Stats gathered for ' . $now->format('m/Y'));
        }

        return;

        $now = Carbon::now();
        $from = clone $now;
        $from->subMonths(12);

        $stats = Xero::invoiceStats($from, $now);
        
        Statistic::create([
            'date'              => $now,
            'total_invoices'    => $stats['count'],
            'total_value'       => $stats['total']
        ]);
    }
}
