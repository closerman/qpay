<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'orders';

    /**
     * Run the migrations.
     * @table agents
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
//            $table->increments('id');
            $table->string('id',32)->index()->unique()->comment('id');
//            $table->char('username', 16)->comment('会员账号');
            $table->string('agentName',20)->index()->comment('代理');
            $table->unsignedBigInteger('cardNo')->nullable()->comment('银行卡号');
            $table->string('cardType', 45)->nullable()->comment('卡类型');
            $table->string('depict')->nullable()->comment('depict');
            $table->string('failureReason')->comment('交易状态');
            $table->string('fee')->nullable()->comment('fee');
            $table->string('addFee')->nullable()->comment('addFee');
            $table->string('machineTerminalId')->nullable()->comment('machineTerminalId');
            $table->string('merchantName')->comment('商户/用户名称');
            $table->string('merchantNo')->nullable()->comment('merchantNo');
            $table->string('merchantProductType')->comment('merchantProductType');
            $table->string('orderCount')->nullable()->comment('orderCount');
            $table->string('paymentFlag')->nullable()->comment('paymentFlag');
            $table->string('paymentNo')->nullable()->comment('paymentNo');
            $table->string('phone')->comment('phone');
            $table->string('rateCode')->nullable()->comment('rateCode');
            $table->string('salesmanName')->comment('salesmanName');
            $table->string('salesmanPhone')->comment('salesmanPhone');
            $table->string('settleMode')->comment('结算类型');
            $table->string('status')->comment('交易结果描述');
            $table->string('sumFee')->nullable()->comment('sumFee');
            $table->bigInteger('trxAmount')->comment('金额');
            $table->string('trxAmountCount')->nullable()->comment('trxAmountCount');
            $table->string('trxSource')->nullable()->comment('trxSource');
            $table->dateTime('trxTime')->comment('交易时间');
//            $table->string('trxTime')->comment('交易时间');
            $table->string('trxType')->comment('交易类型');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
