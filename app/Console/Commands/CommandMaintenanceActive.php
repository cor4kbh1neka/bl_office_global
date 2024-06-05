<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CommandMaintenanceActive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:command-maintenance-active';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $url = env('DOMAIN') . '/content/sts/1';
        $data3 = [
            'stsmtncnc' => '1'
        ];
        $response = Http::withHeaders([
            'x-customblhdrs' => env('XCUSTOMBLHDRS')
        ])->put($url, $data3);
        $response = $response->json();

        if ($response['status'] == 'success') {
            $data2 = [
                "Username" => env('AGENTID'),
                "Status" => "active",
                "CompanyKey" => env('COMPANY_KEY'),
                "ServerId" => env('SERVERID')
            ];
            $url = env('BODOMAIN') . '/web-root/restricted/agent/update-agent-status.aspx';

            $response = Http::withHeaders([
                'Content-Type' => 'application/json; charset=UTF-8',
            ])->post($url, $data2);

            // $this->info('Response JSON: ' . json_encode($response->json(), JSON_PRETTY_PRINT));
            return 0;
        }

        $this->info('Condition not met. No POST request made.');
        return 0;
    }
}
