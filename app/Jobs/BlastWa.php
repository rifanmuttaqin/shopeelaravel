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
    private $setting_service;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($excel_data, $setting_service)
    {
        $this->excel_data = $excel_data;
        $this->setting_service = $setting_service;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $openwa = new OpenWAClient($this->setting_service->getSetting()->ip_server_wa);

        foreach ($this->excel_data as $customer) 
        {
            $pesan          = $this->hardCodeText($customer[0]);
            $nomer_penerima = $customer[1];
            $sent           = $openwa->Send()->Text()->text($pesan, $nomer_penerima);

            if($sent->isSuccess())
            {
                // break;
            }

            sleep(5);            
        }
          
    }

    private function hardCodeText($name)
    {
        return $this->setting_service->formatNoteByName($this->setting_service->getSetting()->wa_message,$name);
    }
}
