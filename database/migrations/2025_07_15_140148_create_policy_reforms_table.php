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
            $table->string('member_id');
            $table->string('title');
            $table->string('category');
            $table->longText('description');
            $table->string('photo');
            $table->integer('like');
            $table->integer('dislike');
            $table->integer('target_votes');
            $table->date('until');
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
