<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TrainMarketBasket extends Command
{
    protected $signature = 'pos:train-market-basket';
    protected $description = 'Melatih algoritma FP-Growth untuk rekomendasi cross-selling via Serverless API';

    public function handle()
    {
        $this->info('Memulai proses training FP-Growth via API...');
        
        $apiUrl = env('PYTHON_API_URL', url('/api/python')) . '/train';
        
        try {
            $response = Http::timeout(300)->post($apiUrl);
            
            if ($response->successful()) {
                $this->info('Berhasil:');
                $this->line(json_encode($response->json(), JSON_PRETTY_PRINT));
            } else {
                $this->error('Gagal menjalankan training AI. Status: ' . $response->status());
                $this->error($response->body());
            }
        } catch (\Exception $exception) {
            $this->error('Gagal menghubungi API:');
            $this->error($exception->getMessage());
        }
    }
}
