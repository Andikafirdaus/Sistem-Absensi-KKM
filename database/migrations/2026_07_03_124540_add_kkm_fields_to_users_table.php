<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('jabatan')->nullable()->after('name');
            $table->string('divisi')->nullable()->after('jabatan');
            $table->string('jurusan')->nullable()->after('divisi');
            $table->string('angkatan')->nullable()->after('jurusan');
            $table->string('nomor_hp')->nullable()->after('angkatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'divisi', 'jurusan', 'angkatan', 'nomor_hp']);
        });
    }
};
