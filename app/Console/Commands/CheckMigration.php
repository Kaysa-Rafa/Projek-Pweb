<?php
// app/Console/Commands/CheckMigrations.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckMigrations extends Command
{
    protected $signature = 'migrate:check';
    protected $description = 'Check migration status';

    public function handle()
    {
        $this->info('Checking migrations...');
        
        // Check migrations table
        if (!Schema::hasTable('migrations')) {
            $this->error('Migrations table does not exist!');
            return Command::FAILURE;
        }
        
        $migrations = DB::table('migrations')->get();
        $this->info('Migrations found: ' . $migrations->count());
        
        foreach ($migrations as $migration) {
            $this->line("- {$migration->migration} (batch: {$migration->batch})");
        }
        
        return Command::SUCCESS;
    }
}