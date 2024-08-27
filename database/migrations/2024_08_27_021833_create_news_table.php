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
        Schema::create('news', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->comment('The title of the news.');
            $table->longText('content')->comment('The content of the news.');
            $table->timestamp('published_at')->nullable()->comment('The date and time when the news is published.');
            $table->integer('view_count')->default(0)->comment('The number of views of the news.');
            $table->string('thumbnail')->nullable()->comment('The thumbnail of the news.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
