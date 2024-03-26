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
        Schema::create('contents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('contenteable_id');
            $table->uuid('contenteable_type');
            $table->integer('order')->default(1);
            $table->string('component');
            $table->boolean('visible')->default(true);
            $table->json('content')->nullable();
            $table->timestamps();

            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
