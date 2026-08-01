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
        Schema::create('fresher_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('profile_photo')->nullable();

            $table->string('phone', 20)->nullable();

            $table->string('city', 100)->nullable();

            $table->string('qualification', 150)->nullable();

            $table->string('college_name', 200)->nullable();

            $table->year('passing_year')->nullable();

            $table->text('skills')->nullable();

            $table->string('resume')->nullable();

            $table->unsignedTinyInteger('profile_completion')
                ->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fresher_profiles');
    }
};