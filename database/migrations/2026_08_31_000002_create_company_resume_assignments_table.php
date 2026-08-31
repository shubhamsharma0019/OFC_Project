<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_resume_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fresher_profile_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['company_profile_id', 'fresher_profile_id'], 'company_resume_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_resume_assignments');
    }
};
