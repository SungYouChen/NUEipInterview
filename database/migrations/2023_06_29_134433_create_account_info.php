<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('account_info', function (Blueprint $table) {
            $table->id();
            $table->string('account')->comment('帳號');
            $table->string('name')->comment('姓名');
            $table->string('gender')->comment('性別');
            $table->date('birthday')->comment('生日');
            $table->string('email')->comment('信箱');
            $table->text('note')->nullable()->comment('備註');
            $table->uuid()->comment('唯一識別碼');
            $table->timestamps();
            $table->index(['uuid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_info');
    }
};
