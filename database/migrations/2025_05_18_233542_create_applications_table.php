<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('candidate_id');
            $table->unsignedBigInteger('assigned_agent_id')->nullable();

            // Review workflow status
            $table->enum('status', ['pending','in_review','approved','rejected','shortlisted'])
                  ->default('pending');

            $table->string('remarks')->nullable();
            // Candidate‐supplied data
            $table->json('skills');
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['male','female','other']);
            $table->string('nationality');
            $table->string('email');
            $table->string('phone', 20);
            $table->text('address');
            $table->string('country');

            // Education
            $table->string('highest_degree');
            $table->string('institution');
            $table->string('field_of_study');
            $table->date('graduation_date')->nullable();

            // Experience
            $table->integer('years_experience')->unsigned();
            $table->string('last_employer')->nullable();
            $table->string('last_position')->nullable();
            $table->string('employment_duration')->nullable();

            // Additional
            $table->text('cover_letter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('portfolio')->nullable();

            // File paths
            $table->string('resume_path');
            $table->json('other_docs_paths')->nullable();

            $table->timestamps();

            // Indexes & FKs
            $table->foreign('job_id')
                  ->references('id')->on('jobs')
                  ->onDelete('cascade');

            $table->foreign('candidate_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('assigned_agent_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
