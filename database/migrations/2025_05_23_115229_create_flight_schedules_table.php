<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlightSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('flight_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visa_document_id')
                  ->constrained('visa_documents')
                  ->onDelete('cascade');

            $table->string('airline');
            $table->string('flight_number')->nullable();
            $table->string('departure_airport');
            $table->string('arrival_airport');
            $table->dateTime('departure_datetime');
            $table->dateTime('arrival_datetime');

            $table->string('ticket_path');
            $table->string('sponsorship_letter_path');

            $table->enum('travel_status', [
                'scheduled',
                'departed',
                'arrived',
                'cancelled',
                'rescheduled',
            ])->default('scheduled');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('flight_schedules');
    }
}
