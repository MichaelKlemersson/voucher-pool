<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('offer_id')->unsigned();
            $table->integer('recipient_id')->unsigned()->nullable()->default(null);
            $table->dateTime('used_date')->nullable()->default(null);
            $table->dateTime('end_date');
            $table->timestamps();
            $table->softDeletes();

            $table->index('code');
            $table->index([
                'used_date',
                'end_date'
            ], 'restriction_dates');
        });

        Schema::table('vouchers', function (Blueprint $table) {
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->foreign('recipient_id')->references('id')->on('recipients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vouchers', function (Blueprint $table) {
            $table->dropForeign(['offer_id', 'recipient_id']);
        });
    }
}
