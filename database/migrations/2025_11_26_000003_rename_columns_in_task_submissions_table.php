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
        Schema::table('task_submissions', function (Blueprint $table) {
            $table->renameColumn('submission', 'answer');
            $table->renameColumn('image_path', 'file_path');
            $table->timestamp('submitted_at')->nullable()->after('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_submissions', function (Blueprint $table) {
            $table->renameColumn('answer', 'submission');
            $table->renameColumn('file_path', 'image_path');
            $table->dropColumn('submitted_at');
        });
    }
};
