<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class AddStkIdnumbToProductsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedBigInteger('stk_idnumb')->nullable()->after('id');
                $table->foreign('stk_idnumb')->references('stk_idnumb')->on('yanak_products')->onDelete('set null');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::table('products', function (Blueprint $table) {
                $table->dropForeign(['stk_idnumb']);
                $table->dropColumn('stk_idnumb');
            });
        }
    }
