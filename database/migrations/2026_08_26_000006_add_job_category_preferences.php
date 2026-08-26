<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fresher_profiles', function (Blueprint $table) {
            $table->string('preferred_job_category', 150)->nullable()->after('skills');
        });

        Schema::table('assessment_questions', function (Blueprint $table) {
            $table->string('job_category', 150)->nullable()->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('assessment_questions', function (Blueprint $table) {
            $table->dropColumn('job_category');
        });

        Schema::table('fresher_profiles', function (Blueprint $table) {
            $table->dropColumn('preferred_job_category');
        });
    }
};
