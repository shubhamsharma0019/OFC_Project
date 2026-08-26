<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE payments MODIFY course_enrollment_id BIGINT UNSIGNED NULL');

        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained('users')
                ->nullOnDelete();

            $table->string('purpose', 80)
                ->default('course_enrollment')
                ->after('course_enrollment_id');

            $table->string('plan', 80)
                ->nullable()
                ->after('purpose');

            $table->string('currency', 3)
                ->default('INR')
                ->after('amount');

            $table->string('razorpay_order_id')
                ->nullable()
                ->unique()
                ->after('transaction_id');

            $table->string('razorpay_payment_id')
                ->nullable()
                ->unique()
                ->after('razorpay_order_id');

            $table->string('razorpay_signature')
                ->nullable()
                ->after('razorpay_payment_id');

            $table->string('payment_method', 80)
                ->nullable()
                ->after('payment_status');

            $table->text('failure_reason')
                ->nullable()
                ->after('payment_method');

            $table->json('metadata')
                ->nullable()
                ->after('failure_reason');

            $table->timestamp('paid_at')
                ->nullable()
                ->after('payment_date');

            $table->index(['user_id', 'purpose']);
            $table->index(['payment_status', 'purpose']);
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'purpose']);
            $table->dropIndex(['payment_status', 'purpose']);
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'purpose',
                'plan',
                'currency',
                'razorpay_order_id',
                'razorpay_payment_id',
                'razorpay_signature',
                'payment_method',
                'failure_reason',
                'metadata',
                'paid_at',
            ]);
        });

        DB::statement('ALTER TABLE payments MODIFY course_enrollment_id BIGINT UNSIGNED NOT NULL');
    }
};
