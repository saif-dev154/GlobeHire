<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
$table->unsignedBigInteger('interview_id');
$table->foreign('interview_id')->references('id')->on('interviews')->onDelete('cascade');

// Additional fields
$table->unsignedBigInteger('employer_id');
$table->date('start_date');
$table->string('salary');
$table->string('working_hours')->nullable();
$table->string('leave_entitlement')->nullable();
$table->text('termination_terms')->nullable();
$table->string('notice_period')->nullable();
$table->string('jurisdiction')->nullable();
$table->date('deadline');
$table->date('contract_date');
$table->text('body');
$table->string('signature_path')->nullable();
$table->enum('status', ['created', 'signed', 'approved','rejected'])->default('created');
$table->string('remarks')->nullable();


$table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
}
