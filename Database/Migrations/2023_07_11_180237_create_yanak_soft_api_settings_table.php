<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYanakSoftApiSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yanak_soft_api_settings', function (Blueprint $table) {
            $table->id();
            $table->text('bearer_token')->nullable();
            $table->timestamp('bearer_token_last_update')->nullable();
            $table->string('client_email');
            $table->string('username');
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
        Schema::dropIfExists('yanak_soft_api_settings');
    }
}
