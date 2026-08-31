<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('fresher_profiles', 'preferred_job_category')) {
            Schema::table('fresher_profiles', function (Blueprint $table) {
                $table->string('preferred_job_category', 150)->nullable()->after('skills');
            });
        }

        if (! Schema::hasColumn('assessment_questions', 'job_category')) {
            Schema::table('assessment_questions', function (Blueprint $table) {
                $table->string('job_category', 150)->nullable()->after('category');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('assessment_questions', 'job_category')) {
            Schema::table('assessment_questions', function (Blueprint $table) {
                $table->dropColumn('job_category');
            });
        }

        if (Schema::hasColumn('fresher_profiles', 'preferred_job_category')) {
            Schema::table('fresher_profiles', function (Blueprint $table) {
                $table->dropColumn('preferred_job_category');
            });
        }
    }
};
