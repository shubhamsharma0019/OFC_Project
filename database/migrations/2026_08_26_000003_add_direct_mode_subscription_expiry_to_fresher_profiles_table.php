<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fresher_profiles', function (Blueprint $table) {
            $table->timestamp('direct_mode_subscription_expires_at')
                ->nullable()
                ->after('direct_mode_subscription_plan');
        });
    }

    public function down(): void
    {
        Schema::table('fresher_profiles', function (Blueprint $table) {
            $table->dropColumn('direct_mode_subscription_expires_at');
        });
    }
};
