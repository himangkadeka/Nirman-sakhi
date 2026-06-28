 <?php

use Dompdf\FrameDecorator\Table;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainWorkerDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.main_worker_documents', function (Blueprint $table) {
            $table->id();
            $table->string('worker_id')->unique();
            $table->string('application_no');
            $table->string('residential_proof')->nullable();
            $table->string('old_id_card')->nullable();
            $table->string('worker_bank_copy')->nullable();
            $table->string('pan_card')->nullable();
            $table->string('nominee_bank_copy')->nullable();
            $table->string('ration_card')->nullable();
            $table->string('subscription_payment_receipt')->nullable();
            $table->string('subscription_ext')->nullable();
            $table->string('work_book')->nullable();
            $table->string('payment_acknowledgement_slip')->nullable();
            $table->string('payment_acknowledgement_slip_ext')->nullable();
            $table->string('work_book_ext')->nullable();
            $table->string('res_proof_ext')->nullable();
            $table->string('old_id_card_ext')->nullable();
            $table->string('nominee_bank_copy_ext')->nullable();
            $table->string('ration_card_ext')->nullable();
            $table->string('pan_card_ext')->nullable();
            $table->string('worker_bank_copy_ext')->nullable();
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
        Schema::dropIfExists('Worker.main_worker_documents');
    }
}
