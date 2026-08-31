<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('company_resume_assignments', function (Blueprint $table) {
            if (! Schema::hasColumn('company_resume_assignments', 'company_joined_at')) {
                $table->timestamp('company_joined_at')->nullable()->after('interview_time');
            }

            if (! Schema::hasColumn('company_resume_assignments', 'fresher_joined_at')) {
                $table->timestamp('fresher_joined_at')->nullable()->after('company_joined_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('company_resume_assignments', function (Blueprint $table) {
            foreach (['fresher_joined_at', 'company_joined_at'] as $column) {
                if (Schema::hasColumn('company_resume_assignments', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
