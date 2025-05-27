<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewsTable extends Migration
{
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('application_id');
            $table->unsignedBigInteger('agent_id');

            // Interview details
            $table->date('interview_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('meeting_link');

            // Status with default value
            $table->enum('status', ['pending', 'pass', 'fail','postponed'])->default('pending');

            // Optional remarks from agent/interviewer
            $table->text('remarks')->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('application_id')
                  ->references('id')->on('applications')
                  ->onDelete('cascade');

            $table->foreign('agent_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('interviews');
    }
}
