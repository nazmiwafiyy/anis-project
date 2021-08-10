<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            //tarikh bayaran,jumlah,bukti,is_approve
            $table->string('payment',10)->nullable();
            $table->timestamp('payment_date',0)->nullable();
            $table->string('payment_prove',100)->nullable();
            $table->char('is_approve',1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['payment', 'payment_date', 'payment_prove','is_approve']);
        });
    }
}
