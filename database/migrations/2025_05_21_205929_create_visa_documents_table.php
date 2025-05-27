    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateVisaDocumentsTable extends Migration
    {
        public function up()
        {
            Schema::create('visa_documents', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->id();

                $table->unsignedBigInteger('candidate_id')->index();
                $table->foreign('candidate_id')->references('id')->on('users')->onDelete('cascade');

                $table->unsignedBigInteger('contract_id')->index();
                $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');

                $table->json('passport_scan');
                $table->json('national_id');

                $table->string('passport_photo');
                $table->string('education_certificates');
                $table->string('experience_certificate')->nullable();
                $table->string('police_clearance');
                $table->string('medical_certificate');
                $table->string('visa_application_form');
                $table->string('offer_letter');
                $table->string('resume_cv');
                $table->string('declaration_consent');
                $table->string('noc')->nullable();

                $table->enum('status', ['submitted','inreview','approved','rejected'])
                    ->default('submitted')
                    ->comment('Global status');

                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('visa_documents');
        }
    }
