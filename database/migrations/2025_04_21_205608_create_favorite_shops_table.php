<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavoriteShopsTable extends Migration
{
    public function up()
    {
        Schema::create('favorite_shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('shop_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'shop_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorite_shops');
    }
}
