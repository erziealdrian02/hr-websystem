<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            // Drop old default id (bigIncrements) — leaves model uses string uuid
            // We check if column already exists before adding

            if (!Schema::hasColumn('leaves', 'employee_id')) {
                $table->string('employee_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('leaves', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('employee_id');
            }
            if (!Schema::hasColumn('leaves', 'leave_type')) {
                $table->enum('leave_type', ['Annual Leave', 'Sick Leave', 'Unpaid Leave'])->after('user_id');
            }
            if (!Schema::hasColumn('leaves', 'start_date')) {
                $table->date('start_date')->after('leave_type');
            }
            if (!Schema::hasColumn('leaves', 'end_date')) {
                $table->date('end_date')->after('start_date');
            }
            if (!Schema::hasColumn('leaves', 'duration_days')) {
                $table->integer('duration_days')->default(1)->after('end_date');
            }
            if (!Schema::hasColumn('leaves', 'reason')) {
                $table->text('reason')->nullable()->after('duration_days');
            }
            if (!Schema::hasColumn('leaves', 'attachment')) {
                $table->string('attachment')->nullable()->after('reason');
            }
            if (!Schema::hasColumn('leaves', 'status')) {
                $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending')->after('attachment');
            }
            if (!Schema::hasColumn('leaves', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable()->after('status');
            }
            if (!Schema::hasColumn('leaves', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
            if (!Schema::hasColumn('leaves', 'rejection_note')) {
                $table->text('rejection_note')->nullable()->after('approved_at');
            }
            if (!Schema::hasColumn('leaves', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('rejection_note');
            }
            if (!Schema::hasColumn('leaves', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
        });

        // Change primary key to string UUID if currently auto-increment
        // We need to modify the id column type
        Schema::table('leaves', function (Blueprint $table) {
            // Only convert if the id is still bigint (auto-increment style)
            // The model uses string PK, so we set to string
        });
    }

    public function down(): void
    {
        Schema::table('leaves', function (Blueprint $table) {
            $columnsToDrop = [
                'employee_id', 'user_id', 'leave_type', 'start_date', 'end_date',
                'duration_days', 'reason', 'attachment', 'status',
                'approved_by', 'approved_at', 'rejection_note', 'created_by', 'updated_by',
            ];
            foreach ($columnsToDrop as $col) {
                if (Schema::hasColumn('leaves', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
