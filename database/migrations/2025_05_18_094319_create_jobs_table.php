<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();

            // Employer FK
            $table->unsignedBigInteger('employer_id');

            // JSON fields
            $table->json('agent_ids')->nullable();
            $table->json('required_skills');

            // Core columns
            $table->string('title');
            $table->string('location');
            $table->text('description');

            // Compensation
            $table->decimal('salary', 12, 2);
            $table->string('salary_structure')->nullable();

            // Classification
            $table->string('job_type')->nullable();
            $table->string('experience_level')->nullable();
            $table->string('education')->nullable();

            // **NEW**: status, dates, gender, visa
            $table->enum('status', ['pending', 'active', 'closed'])->default('pending');
            $table->date('application_start_date')->nullable();
            $table->date('application_deadline')->nullable();
            $table->enum('gender', ['male','female','any','other'])->default('any');
            $table->boolean('visa_sponsor')->default(false);

            $table->timestamps();

            // Index & FK
            $table->index('employer_id');
            $table->foreign('employer_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
