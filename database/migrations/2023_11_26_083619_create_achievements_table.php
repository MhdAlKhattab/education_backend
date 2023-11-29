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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('supervisor_name');
            $table->string('achievement_name');
            $table->string('day');
            $table->date('date');
            $table->string('semester');
            $table->string('section');
            $table->string('section_type');
            $table->string('proof');
            $table->integer('attendees_number');
            $table->string('target_group');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
