<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

use App\Model\HistoryCetak\HistoryCetak;

class ClearHistoryCetak extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:history';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pembersihan History Cetak Setelah 3 Hari';

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
        $history_cetak = HistoryCetak::all();
        
        foreach ($history_cetak as $history) 
        {
           $minutes = abs(strtotime($history->created_at) - time()) / 60;

           if($minutes >= 4320)
           {
               $history->delete();
           }
        }
       
    }
}
