<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class TrainMarketBasket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pos:train-market-basket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Melatih algoritma FP-Growth untuk rekomendasi cross-selling';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses training FP-Growth...');
        
        $scriptPath = storage_path('app/scripts/fpgrowth_trainer.py');
        
        $process = new Process(['python', $scriptPath]);
        $process->setTimeout(300); // 5 menit
        
        try {
            $process->mustRun();
            $this->info('Berhasil:');
            $this->line($process->getOutput());
        } catch (ProcessFailedException $exception) {
            $this->error('Gagal menjalankan training AI:');
            $this->error($exception->getMessage());
        }
    }
}
