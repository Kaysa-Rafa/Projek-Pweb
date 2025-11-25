<?php
// app/Console/Commands/CheckDatabase.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CheckDatabase extends Command
{
    protected $signature = 'db:check';
    protected $description = 'Check database tables and structure';

    public function handle()
    {
        $this->info('Checking database tables...');
        
        try {
            // Get all tables
            $tables = DB::select("SELECT name FROM sqlite_master WHERE type='table'");
            
            $this->info('Tables found: ' . count($tables));
            
            foreach ($tables as $table) {
                $this->line("- {$table->name}");
                
                // Check if users table exists and has data
                if ($table->name === 'users') {
                    $count = DB::table('users')->count();
                    $this->info("  Users count: {$count}");
                    
                    // Check columns
                    $columns = DB::select("PRAGMA table_info(users)");
                    $this->info("  Columns:");
                    foreach ($columns as $column) {
                        $this->line("    - {$column->name} ({$column->type})");
                    }
                }
            }
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}