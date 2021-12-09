<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OpenWAClient\OpenWAClient as OpenWAClient;

class BlastWa implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $excel_data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($excel_data)
    {
        $this->excel_data = $excel_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $openwa = new OpenWAClient("http://localhost:8080");

        foreach ($this->excel_data as $customer) 
        {
            $pesan          = $this->hardCodeText($customer[0],$customer[2]);
            $nomer_penerima = $customer[1];
            $sent           = $openwa->Send()->Text()->text($pesan, $nomer_penerima);

            if($sent->isSuccess())
            {
                break;
            }

            sleep(5);            
        }
          
    }

    private function hardCodeText($name,$city)
    {
        return 'Selamat malam kak '.$name.', Perkenalkan kami dari Al Barr Snack (riftin) seller camilan asli Indonesia dari shopee, Sebelumnya saya ucapkan terimakasih kak, karena pernah berbelanja ditoko kami melalui platform shopee. Hari ini juga merupakan promo puncak shopee 12-12, banyak diskon gratis ongkir yg kakak dapat pakai untuk berbelanja camilan di toko kami, kami juga menawarkan promo dibeberapa produk kami diskon up to 32%. klik tautan berikut ya kak, untuk berbelanja kembali ditoko kami : 
        shopee.co.id/riftin';
    }
}
