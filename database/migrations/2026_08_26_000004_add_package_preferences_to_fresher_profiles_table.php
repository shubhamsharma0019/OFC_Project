<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fresher_profiles', function (Blueprint $table) {
            $table->decimal('preferred_min_package_lpa', 8, 2)->nullable()->after('skills');
            $table->decimal('preferred_max_package_lpa', 8, 2)->nullable()->after('preferred_min_package_lpa');
        });
    }

    public function down(): void
    {
        Schema::table('fresher_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'preferred_min_package_lpa',
                'preferred_max_package_lpa',
            ]);
        });
    }
};
