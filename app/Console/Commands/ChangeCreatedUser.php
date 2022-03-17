<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Modules\Pemasukan\Entities\TransaksiOffline\TransaksiOffline;

class ChangeCreatedUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'createduser:transaksioffline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merubah Tranasksi Offline created_by';

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
        $datas = TransaksiOffline::all();

        try {

            DB::beginTransaction();   

            if($datas !=null){
                foreach ($datas as $data) {
                    $data->user_created = 1;
                    $data->save();
                }
            }

            DB::commit();

        } catch (\Throwable $th) {
            dd($th);

            DB::rollBack();
        }

        return 0;
    }
}
