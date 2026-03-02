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
        Schema::create('about_list_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('about_list_id')->constrained();
            $table->string('locale')->index();
            $table->string('title')->nullable();
            $table->string('content');
            $table->unique(['about_list_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_list_translations');
    }
};
