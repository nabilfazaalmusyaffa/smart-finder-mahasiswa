<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('community_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('category'); // diskusi, qa, materi, study_group, event
            $table->string('topic')->nullable();
            $table->string('title');
            $table->text('body');
            $table->string('attachment')->nullable();
            $table->dateTime('event_date')->nullable();
            $table->string('group_schedule')->nullable();
            $table->timestamps();
        });

        Schema::create('community_post_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('community_posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['post_id', 'user_id']);
        });

        Schema::create('community_post_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('community_posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('comment');
            $table->timestamps();
        });

        Schema::create('saved_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('community_posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->unique(['post_id', 'user_id']);
        });

        Schema::create('study_group_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('community_posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('joined');
            $table->timestamps();
            $table->unique(['post_id', 'user_id']);
        });

        Schema::create('event_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('community_posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('joined');
            $table->timestamps();
            $table->unique(['post_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_participants');
        Schema::dropIfExists('study_group_members');
        Schema::dropIfExists('saved_posts');
        Schema::dropIfExists('community_post_comments');
        Schema::dropIfExists('community_post_likes');
        Schema::dropIfExists('community_posts');
    }
};
