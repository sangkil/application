<?php

namespace app\components;

use biz\core\master\models\Product;
use biz\core\master\models\ProductUom;
use biz\core\master\models\Uom;
use biz\core\master\models\ProductChild;
use biz\core\master\models\PriceCategory;
use biz\core\master\models\Price;
use biz\core\master\models\Customer;
use biz\core\master\models\Supplier;
use biz\core\master\models\ProductSupplier;
use biz\core\master\models\ProductStock;

/**
 * Helper
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class Helper
{

    public static function getMasters($masters)
    {
        $masters = array_flip($masters);
        $result = [];

        // master product
        if (isset($masters['products'])) {
            $query_product = ProductUom::find()
                ->select(['pu.*', 'p.code', 'p.name', 'uom_nm' => 'u.name'])
                ->from(ProductUom::tableName() . ' pu')
                ->joinWith(['product'=>function($q){
                    $q->from(Product::tableName() . ' p');
                }])
                ->joinWith(['uom'=>function($q){
                    $q->from(Uom::tableName() . ' u');
                }])
                ->orderBy(['pu.product_id' => SORT_ASC, 'pu.isi' => SORT_ASC])
                ->asArray();

            $products = [];
            foreach ($query_product->all() as $row) {
                $id = $row['product_id'];
                if (!isset($products[$id])) {
                    $products[$id] = [
                        'id' => $row['product_id'],
                        'cd' => $row['code'],
                        'text' => $row['name'],
                        'label' => $row['name'],
                    ];
                }
                $products[$id]['uoms'][] = [
                    'id' => $row['uom_id'],
                    'nm' => $row['uom_nm'],
                    'isi' => $row['isi']
                ];
            }
            $result['products'] = $products;
        }

        // barcodes
        if (isset($masters['barcodes'])) {
            $barcodes = [];
            $query_barcode = ProductChild::find()
                ->select(['barcode' => 'lower(barcode)', 'id' => 'product_id'])
                ->union(Product::find()->select(['lower(code)', 'id']))
                ->asArray();
            foreach ($query_barcode->all() as $row) {
                $barcodes[$row['barcode']] = $row['id'];
            }
            $result['barcodes'] = $barcodes;
        }

        // price_category
        if (isset($masters['price_category'])) {
            $price_category = [];
            $query_price_category = PriceCategory::find()->asArray();
            foreach ($query_price_category->all() as $row) {
                $price_category[$row['id']] = $row['name'];
            }
            $result['price_category'] = $price_category;
        }

        // prices
        if (isset($masters['prices'])) {
            $prices = [];
            $query_prices = Price::find()->asArray();
            foreach ($query_prices->all() as $row) {
                $prices[$row['product_id']][$row['price_category_id']] = $row['price'];
            }
            $result['prices'] = $prices;
        }

        // customer
        if (isset($masters['customers'])) {
            $result['customers'] = Customer::find()
                    ->select(['id', 'label' => 'name'])
                    ->asArray()->all();
        }

        // supplier
        if (isset($masters['suppliers'])) {
            $result['suppliers'] = Supplier::find()
                    ->select(['id', 'label' => 'name'])
                    ->asArray()->all();
        }

        // product_supplier
        if (isset($masters['product_supplier'])) {
            $prod_supp = [];
            $query_prod_supp = ProductSupplier::find()
                ->select(['supplier_id', 'product_id'])
                ->asArray();
            foreach ($query_prod_supp->all() as $row) {
                $prod_supp[$row['supplier_id']][] = $row['product_id'];
            }
            $result['product_supplier'] = $prod_supp;
        }

        // product_stock
        if (isset($masters['product_stock'])) {
            $prod_stock = [];
            $query_prod_stock = ProductStock::find()
                ->select(['warehouse_id', 'product_id'])
                ->asArray();
            foreach ($query_prod_stock->all() as $row) {
                $prod_stock[$row['warehouse_id']][$row['product_id']] = $row['qty'];
            }
            $result['product_stock'] = $prod_stock;
        }

        return $result;
    }
}