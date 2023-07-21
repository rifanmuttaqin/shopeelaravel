<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class setIsActiveData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:active';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set All Data to Active';

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
     * @return int
     */
    public function handle()
    {
         // Mengambil seluruh tabel dari database
         $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

         foreach ($tables as $table) {
                // Mengambil daftar kolom untuk setiap tabel
                $columns = DB::getSchemaBuilder()->getColumnListing($table);

                // Pengecekan apakah ada kolom dengan nama "status_active"
                $hasStatusActive = in_array('status_aktif', $columns);

                if($hasStatusActive)
                {
                    DB::table($table)->update(['status_aktif' => 1]);
                }
         }

        return 0;
    }

}
