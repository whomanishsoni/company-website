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
        Schema::table('mail_inquiries', function (Blueprint $table) {
            Schema::table('mail_inquiries', function (Blueprint $table) {
                $table->boolean('is_trashed')->default(false)->after('is_read');
                $table->foreignId('parent_id')->nullable()->after('is_trashed')
                    ->constrained('mail_inquiries')->onDelete('cascade');
                $table->text('admin_reply')->nullable()->after('parent_id');
                $table->timestamp('replied_at')->nullable()->after('admin_reply');
                $table->softDeletes()->after('replied_at');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mail_inquiries', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['is_trashed', 'parent_id', 'admin_reply', 'replied_at', 'deleted_at']);
        });
    }
};
