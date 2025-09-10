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
        Schema::create('test_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->string('name');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['draft', 'active', 'passed', 'failed'])->default('draft');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->enum('type', ['functional', 'regression', 'smoke', 'manual', 'e2e'])->default('manual');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_cases');
    }
};
