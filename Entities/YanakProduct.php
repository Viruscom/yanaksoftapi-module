<?php

    namespace Modules\YanaksoftApi\Entities;

    use App\Helpers\CacheKeysHelper;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Cache;

    class YanakProduct extends Model
    {
        public    $incrementing = false;
        public    $timestamps   = true;
        protected $table        = 'yanak_products';

        // Указва, че ключът е от тип string (ако е нужно)
        // protected $keyType = 'string';
        protected $primaryKey = 'stk_idnumb';
        protected $fillable   = [
            'stk_idnumb', 'stk_name', 'stk_name_2', 'gr_id', 'screen_gr_ids', 'quantity',
            'quantity_per_pack', 'quantity_per_big_pack', 'broimo', 'bruto', 'neto',
            'basic_price', 'price', 'customer_file_price', 'price_1', 'price_2', 'price_3',
            'price_4', 'price_5', 'price_6', 'price_7', 'price_8', 'price_9', 'price_10',
            'description', 'description_2', 'importer', 'producer', 'location', 'address',
            'code', 'code_quantity', 'code_2', 'code_2_quantity', 'code_3', 'code_3_quantity',
            'code_4', 'code_4_quantity', 'kat_number', 'price_list_name',
            'package_stocks', 'additions', 'comments'
        ];

        public static function updateCache()
        {
            Cache::forget(CacheKeysHelper::$YANAK_API_PRODUCTS_ADMIN);
            Cache::rememberForever(CacheKeysHelper::$YANAK_API_PRODUCTS_ADMIN, function () {
                return YanakProduct::all();
            });
        }
    }
