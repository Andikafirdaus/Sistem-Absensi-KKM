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
        Schema::rename('work_hours', 'settings');
        
        Schema::table('settings', function (Blueprint $table) {
            $table->integer('qr_validity_minutes')->default(5)->after('late_tolerance');
            $table->string('org_name')->default('Absensi KKM')->after('qr_validity_minutes');
            $table->string('org_logo')->nullable()->after('org_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['qr_validity_minutes', 'org_name', 'org_logo']);
        });
        
        Schema::rename('settings', 'work_hours');
    }
};
