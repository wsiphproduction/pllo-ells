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
        Schema::create('policy_reforms', function (Blueprint $table) {
            $table->id();
            $table->string('member_id')->nullable();
            $table->string('title')->nullable();
            $table->string('category')->nullable();
            $table->longText('description')->nullable();
            $table->string('photo')->nullable();
            $table->integer('like')->default(0);
            $table->integer('dislike')->default(0);
            $table->integer('target_votes')->default(0);
            $table->date('until')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_reforms');
    }
};
