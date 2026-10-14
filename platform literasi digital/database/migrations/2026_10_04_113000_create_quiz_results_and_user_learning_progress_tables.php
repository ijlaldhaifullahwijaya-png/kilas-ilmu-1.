<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('quiz_id');
            $table->string('title');
            $table->string('subject');
            $table->unsignedSmallInteger('correct_answers');
            $table->unsignedSmallInteger('total_questions');
            $table->timestamps();

            $table->index(['user_id', 'created_at']);
            $table->index(['user_id', 'quiz_id']);
        });

        Schema::create('user_learning_progress', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained()->cascadeOnDelete();
            $table->unsignedInteger('current_streak')->default(0);
            $table->unsignedInteger('max_streak')->default(0);
            $table->date('last_active_date')->nullable();
            $table->date('daily_goal_date')->nullable();
            $table->unsignedInteger('daily_completed')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_learning_progress');
        Schema::dropIfExists('quiz_results');
    }
};
