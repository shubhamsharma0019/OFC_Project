<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->text('rejection_reason')
                ->nullable()
                ->after('approval_status');
        });

        Schema::table('training_partner_profiles', function (Blueprint $table) {
            $table->text('rejection_reason')
                ->nullable()
                ->after('approval_status');
        });
    }

    public function down(): void
    {
        Schema::table('company_profiles', function (Blueprint $table) {
            $table->dropColumn('rejection_reason');
        });

        Schema::table('training_partner_profiles', function (Blueprint $table) {
            $table->dropColumn('rejection_reason');
        });
    }
};