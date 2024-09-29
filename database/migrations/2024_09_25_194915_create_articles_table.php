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
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("background")->nullable();
            $table->string("title")->unique();
            $table->string("slug")->unique();
            $table->string("author")->nullable();
            $table->longText("content")->nullable();
            $table->integer("positive_reaction")->default(0);
            $table->string("status", 1)->default('C');
            $table->boolean("in_carrousel")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
