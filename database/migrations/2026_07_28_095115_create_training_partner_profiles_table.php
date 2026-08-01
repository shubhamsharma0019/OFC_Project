<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('training_partner_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('institute_name', 200);

            $table->string('institute_logo')->nullable();

            $table->string('email')->nullable();

            $table->string('phone', 20)->nullable();

            $table->string('location', 200)->nullable();

            $table->string('website')->nullable();

            $table->text('about_institute')->nullable();

            $table->string('verification_document')->nullable();

            $table->enum('approval_status', [
                'pending',
                'approved',
                'rejected',
                'blocked',
            ])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_partner_profiles');
    }
};