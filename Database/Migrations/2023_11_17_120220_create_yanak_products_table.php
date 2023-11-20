<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateYanakProductsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('yanak_products', function (Blueprint $table) {
                $table->id('stk_idnumb');
                $table->string('stk_name');
                $table->string('stk_name_2')->nullable();
                $table->integer('gr_id');
                $table->json('screen_gr_ids')->nullable();
                $table->double('quantity', 15, 8);
                $table->double('quantity_per_pack', 15, 8);
                $table->double('quantity_per_big_pack', 15, 8);
                $table->boolean('broimo')->default(false);
                $table->double('bruto', 15, 8);
                $table->double('neto', 15, 8);
                $table->double('basic_price', 15, 8);
                $table->double('price', 15, 8);
                $table->double('customer_file_price', 15, 8);
                $table->double('price_1', 15, 8);
                $table->double('price_2', 15, 8);
                $table->double('price_3', 15, 8);
                $table->double('price_4', 15, 8)->nullable();
                $table->double('price_5', 15, 8)->nullable();
                $table->double('price_6', 15, 8)->nullable();
                $table->double('price_7', 15, 8)->nullable();
                $table->double('price_8', 15, 8)->nullable();
                $table->double('price_9', 15, 8)->nullable();
                $table->double('price_10', 15, 8)->nullable();
                $table->text('description')->nullable();
                $table->text('description_2')->nullable();
                $table->string('importer')->nullable();
                $table->string('producer')->nullable();
                $table->string('location')->nullable();
                $table->string('address')->nullable();
                $table->string('code');
                $table->double('code_quantity', 15, 8);
                $table->string('code_2')->nullable();
                $table->double('code_2_quantity', 15, 8)->nullable();
                $table->string('code_3')->nullable();
                $table->double('code_3_quantity', 15, 8)->nullable();
                $table->string('code_4')->nullable();
                $table->double('code_4_quantity', 15, 8)->nullable();
                $table->string('kat_number')->nullable();
                $table->string('price_list_name')->nullable();
                $table->json('package_stocks')->nullable();
                $table->json('additions')->nullable();
                $table->json('comments')->nullable();
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
            Schema::dropIfExists('yanak_products');
        }
    }
