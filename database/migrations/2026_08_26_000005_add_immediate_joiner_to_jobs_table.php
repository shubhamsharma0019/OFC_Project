<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('jobs', 'immediate_joiner')) {
            return;
        }

        Schema::table('jobs', function (Blueprint $table) {
            $table->boolean('immediate_joiner')->default(false)->after('job_type');
        });
    }

    public function down(): void
    {
        if (! Schema::hasColumn('jobs', 'immediate_joiner')) {
            return;
        }

        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('immediate_joiner');
        });
    }
};
