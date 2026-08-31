<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_resume_assignments', function (Blueprint $table) {
            if (! Schema::hasColumn('company_resume_assignments', 'status')) {
                $table->string('status', 40)->default('assigned')->after('fresher_profile_id');
            }

            if (! Schema::hasColumn('company_resume_assignments', 'interview_link')) {
                $table->string('interview_link', 500)->nullable()->after('status');
            }

            if (! Schema::hasColumn('company_resume_assignments', 'interview_date')) {
                $table->date('interview_date')->nullable()->after('interview_link');
            }

            if (! Schema::hasColumn('company_resume_assignments', 'interview_time')) {
                $table->time('interview_time')->nullable()->after('interview_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('company_resume_assignments', function (Blueprint $table) {
            foreach (['interview_time', 'interview_date', 'interview_link', 'status'] as $column) {
                if (Schema::hasColumn('company_resume_assignments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
