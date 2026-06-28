<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Worker.worker_transactions', function (Blueprint $table) {
            $table->id();
//            $table->char("worker_id");
            $table->string('application_no');
            $table->char('DEPT_CODE',3);
            $table->char('PAYMENT_TYPE',2);
            $table->char('TREASURY_CODE',3);
            $table->char('OFFICE_CODE',6);
            $table->char('REC_FIN_YEAR',9);
            $table->char('PERIOD',2);
            $table->date('FROM_DATE');
            $table->date('TO_DATE');
            $table->char("MAJOR_HEAD",45);
            $table->string('HOA1',23);
            $table->decimal("AMOUNT1",14,2);
            $table->decimal("CHALLAN_AMOUNT",14,2);
            $table->char("MULTITRANSFER",1);
            $table->char("NON_TREASURY_PAYMENT_TYPE",2);
            $table->char("ACOUNT1",20)->nullable();
            $table->decimal("AC1_AMOUNT",14,2)->nullable();
            $table->decimal("TOTAL_NON_TREASURY_AMOUNT",14,2)->nullable();
            $table->char("TAX_ID",25);
            $table->string("PARTY_NAME",75)->nullable();
            $table->char("MOBILE_NO",15);
            $table->string("DEPARTMENT_ID",30);
            $table->string("REMARKS",100);
            $table->string("SUB_SYSTEM",25);
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
        Schema::dropIfExists('Worker.worker_transactions');
    }
}
