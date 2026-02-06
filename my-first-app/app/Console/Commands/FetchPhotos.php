<?php

namespace App\Console\Commands;

use App\Services\PhotoService;
use Illuminate\Console\Command;

class FetchPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-photos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch photos from JSONPlaceholder API and store them in the database';

    /**
     * @var PhotoService
     */
    protected $photoService;

    /**
     * Create a new command instance.
     *
     * @param PhotoService $photoService
     */
    public function __construct(PhotoService $photoService)
    {
        parent::__construct();
        $this->photoService = $photoService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to fetch photos from API...');
        $this->newLine();

        $progressBar = $this->output->createProgressBar();
        $progressBar->start();

        $result = $this->photoService->fetchAndStorePhotos();

        $progressBar->finish();
        $this->newLine(2);

        if ($result['success']) {
            $this->info('✓ Success!');
            $this->info("Fetched: {$result['count']} photos");
            $this->info("Total in database: {$result['total']} photos");
            return Command::SUCCESS;
        } else {
            $this->error('✗ Failed to fetch photos');
            $this->error("Reason: {$result['message']}");
            return Command::FAILURE;
        }
    }
}
