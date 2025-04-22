<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopHoursTable extends Migration
{
    public function up()
    {
        Schema::create('shop_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->tinyInteger('weekday');      // 0 = Sunday … 6 = Saturday
            $table->time('open_time');
            $table->time('lunch_start');
            $table->time('lunch_end');
            $table->time('close_time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shop_hours');
    }
}
