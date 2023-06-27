<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submission_matches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('submission_id');
            $table->unsignedBigInteger('question_id');
            $table->unsignedBigInteger('left_match_id');
            $table->unsignedBigInteger('right_match_id');

            // Foreign key constraints
            $table->foreign('submission_id')->references('id')->on('submissions')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('left_match_id')->references('id')->on('matches')->onDelete('cascade');
            $table->foreign('right_match_id')->references('id')->on('matches')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
};
