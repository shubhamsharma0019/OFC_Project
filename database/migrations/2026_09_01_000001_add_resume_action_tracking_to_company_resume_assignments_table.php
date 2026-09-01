<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_resume_assignments', function (Blueprint $table) {
            if (! Schema::hasColumn('company_resume_assignments', 'resume_opened_at')) {
                $table->timestamp('resume_opened_at')->nullable()->after('fresher_joined_at');
            }

            if (! Schema::hasColumn('company_resume_assignments', 'resume_downloaded_at')) {
                $table->timestamp('resume_downloaded_at')->nullable()->after('resume_opened_at');
            }

            if (! Schema::hasColumn('company_resume_assignments', 'shortlisted_at')) {
                $table->timestamp('shortlisted_at')->nullable()->after('resume_downloaded_at');
            }

            if (! Schema::hasColumn('company_resume_assignments', 'interview_sent_at')) {
                $table->timestamp('interview_sent_at')->nullable()->after('shortlisted_at');
            }

            if (! Schema::hasColumn('company_resume_assignments', 'interview_completed_at')) {
                $table->timestamp('interview_completed_at')->nullable()->after('interview_sent_at');
            }

            if (! Schema::hasColumn('company_resume_assignments', 'final_status_sent_at')) {
                $table->timestamp('final_status_sent_at')->nullable()->after('interview_completed_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('company_resume_assignments', function (Blueprint $table) {
            foreach ([
                'final_status_sent_at',
                'interview_completed_at',
                'interview_sent_at',
                'shortlisted_at',
                'resume_downloaded_at',
                'resume_opened_at',
            ] as $column) {
                if (Schema::hasColumn('company_resume_assignments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
