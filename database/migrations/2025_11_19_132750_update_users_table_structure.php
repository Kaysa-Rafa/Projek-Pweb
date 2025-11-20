<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update users table structure
        Schema::table('users', function (Blueprint $table) {
            // Tambah column username jika belum ada
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->unique()->after('name');
            }
            
            // Tambah column role jika belum ada
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('password');
            }
            
            // Pastikan email ada (seharusnya sudah ada dari migration default)
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->unique()->after('username');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Optional: bisa diisi rollback logic jika needed
        });
    }
};