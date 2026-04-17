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
        Schema::create('bbs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 50);
            $table->text('content');
            $table->float('price');
            $table->foreignId('user_id')->constrained()
            ->onDelete('cascade');
            $table->timestamps();
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bbs');
    }
};
