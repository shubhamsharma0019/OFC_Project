<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fresher_profiles', function (Blueprint $table) {
            $table->unsignedInteger('direct_mode_credits')->default(250)->after('profile_completion');
            $table->unsignedInteger('total_direct_mode_credits_used')->default(0)->after('direct_mode_credits');
            $table->timestamp('direct_mode_subscribed_at')->nullable()->after('total_direct_mode_credits_used');
            $table->string('direct_mode_subscription_plan')->nullable()->after('direct_mode_subscribed_at');
        });
    }

    public function down(): void
    {
        Schema::table('fresher_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'direct_mode_credits',
                'total_direct_mode_credits_used',
                'direct_mode_subscribed_at',
                'direct_mode_subscription_plan',
            ]);
        });
    }
};
