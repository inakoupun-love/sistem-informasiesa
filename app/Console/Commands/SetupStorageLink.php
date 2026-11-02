<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class SetupStorageLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup complete storage link system with folder creation';

    protected $files;

    /**
     * Create a new command instance.
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Starting Storage Link Setup...\n');

        try {
            // Step 1: Create storage directories
            $this->info('Step 1: Creating storage directories...');
            $this->createStorageDirectories();
            $this->info('✓ Storage directories created\n');

            // Step 2: Create public storage link
            $this->info('Step 2: Creating symbolic link...');
            $this->createSymbolicLink();
            $this->info('✓ Symbolic link created\n');

            // Step 3: Verify setup
            $this->info('Step 3: Verifying setup...');
            $this->verifySetup();
            $this->info('✓ Setup verified\n');

            $this->info('✅ Storage Link Setup Complete!');
            $this->info('You can now upload files. Uploaded files will be accessible at: /storage/');

            return SymfonyCommand::SUCCESS;
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return SymfonyCommand::FAILURE;
        }
    }

    /**
     * Create necessary storage directories
     */
    protected function createStorageDirectories(): void
    {
        $directories = [
            'storage/app/private',
            'storage/app/public',
            'storage/app/public/bansos',
            'storage/app/public/laporan',
            'storage/app/public/pengajuan',
            'storage/app/public/uploads',
            'storage/logs',
            'storage/framework/cache',
            'storage/framework/sessions',
            'storage/framework/views',
        ];

        foreach ($directories as $directory) {
            $path = base_path($directory);
            if (!$this->files->isDirectory($path)) {
                $this->files->makeDirectory($path, 0755, true, true);
                $this->line("  Created: $directory");
            } else {
                $this->line("  Already exists: $directory");
            }
        }
    }

    /**
     * Create symbolic link
     */
    protected function createSymbolicLink(): void
    {
        // Call the built-in storage:link command
        $exitCode = Artisan::call('storage:link');

        if ($exitCode !== 0) {
            throw new \Exception('Failed to create symbolic link. You may need to run this with administrator privileges.');
        }
    }

    /**
     * Verify setup
     */
    protected function verifySetup(): void
    {
        $publicStoragePath = public_path('storage');
        $storagePath = storage_path('app/public');

        // Check if symbolic link exists
        if (!is_link($publicStoragePath)) {
            throw new \Exception('Symbolic link not created at ' . $publicStoragePath);
        }

        // Check if storage/app/public exists
        if (!$this->files->isDirectory($storagePath)) {
            throw new \Exception('Storage directory not found at ' . $storagePath);
        }

        // Check if we can write to storage
        if (!is_writable($storagePath)) {
            throw new \Exception('Storage directory is not writable: ' . $storagePath);
        }

        $this->line("  ✓ Symbolic link exists: public/storage");
        $this->line("  ✓ Storage directory exists and is writable");
        $this->line("  ✓ APP_URL: " . config('app.url'));
    }
}
