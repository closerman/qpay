<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgentsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'agents';

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
            $table->increments('id');
            $table->string('agentName', 26)->comment('代理商');
            $table->string('cardNo',10)->index()->comment('cardNo');
            $table->string('name', 45)->index()->unique()->comment('会员账号');
            $table->string('password')->comment('密码');
            $table->unsignedBigInteger('mobile')->unique()->index()->comment('手机号');
            $table->string('email')->unique()->index()->comment('email');
            $table->char('id_card_number', 18)->nullable()->unqiue()->index()->comment('身份证号码');
            $table->string('id_card_pic_up', 45)->nullable()->comment('身份证正面图片地址');
            $table->string('id_card_pic_down', 45)->nullable()->comment('身份证背面图片地址');
            $table->string('id_card_pic_with_people', 45)->nullable()->comment('手持身份证正面');
            $table->string('province', 45)->nullable()->comment('省份');
            $table->string('city', 45)->nullable()->comment('市');
            $table->string('district', 45)->nullable()->comment('区');
            $table->string('address', 45)->nullable()->comment('详细地址');
            $table->boolean('active')->nullable()->default('0')->comment('是否激活');
            $table->integer('audit')->nullable()->default('0')->comment('人工审核
0:待审核
１:审核通过
２:拒绝');
            $table->string('status_code',3)->comment('审核状态码');
            $table->string('salesman_status',3)->comment('是否注销');
            //$table->timestamp('updated_at')->nullable()->comment('更新时间');

            //$table->unique(["mobile"], 'mobile_UNIQUE');

            //$table->unique(["id"], 'id_UNIQUE');

            //$table->unique(["id_card_number"], 'id_card_number_UNIQUE');

//            $table->unique(["username"], 'username_UNIQUE');
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
