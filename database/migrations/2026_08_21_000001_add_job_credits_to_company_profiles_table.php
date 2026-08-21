<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->unsignedInteger('job_credits')->default(500)->after('approval_status');
            $table->unsignedInteger('total_job_credits_used')->default(0)->after('job_credits');
            $table->timestamp('subscribed_at')->nullable()->after('total_job_credits_used');
            $table->string('subscription_plan')->nullable()->after('subscribed_at');
        });
    }

    public function down(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'job_credits',
                'total_job_credits_used',
                'subscribed_at',
                'subscription_plan',
            ]);
        });
    }
};
