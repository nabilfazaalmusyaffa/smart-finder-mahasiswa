<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('group_conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_group_post_id')->nullable()->constrained('community_posts')->onDelete('set null');
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
        });

        Schema::create('group_conversation_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_conversation_id')->constrained('group_conversations')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('role')->default('member');
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
            $table->unique(['group_conversation_id', 'user_id']);
        });

        Schema::create('group_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_conversation_id')->constrained('group_conversations')->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('attachment_name')->nullable();
            $table->string('attachment_type')->nullable();
            $table->string('attachment_mime')->nullable();
            $table->unsignedBigInteger('attachment_size')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_messages');
        Schema::dropIfExists('group_conversation_members');
        Schema::dropIfExists('group_conversations');
    }
};
