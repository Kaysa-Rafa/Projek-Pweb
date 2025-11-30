<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            // Kita HAPUS bagian is_public dari sini agar tidak bentrok
            // Fokus hanya menambahkan kolom teknis file
            
            if (!Schema::hasColumn('resources', 'original_filename')) {
                $table->string('original_filename')->nullable()->after('file_path');
            }
            if (!Schema::hasColumn('resources', 'file_extension')) {
                $table->string('file_extension', 10)->nullable()->after('original_filename');
            }
            if (!Schema::hasColumn('resources', 'file_mime_type')) {
                $table->string('file_mime_type')->nullable()->after('file_extension');
            }
            
            // Perbaikan tipe data untuk SQLite (biarkan integer atau ubah ke bigInteger jika belum ada)
            if (!Schema::hasColumn('resources', 'file_size')) {
                $table->bigInteger('file_size')->default(0)->after('file_mime_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn(['original_filename', 'file_extension', 'file_mime_type', 'file_size']);
        });
    }
};