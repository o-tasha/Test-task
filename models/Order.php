<?php
/**
 * Created by PhpStorm.
 * User: nataly
 * Date: 09.01.18
 * Time: 17:41
 */
namespace app\models;

use Yii;
use yii\base\Model;

class Order extends Model
{
    /**
     * Заглушка оформления заказа
     */
    public function checkout($products)
    {
        if(count($products) > 0) return true;
        return false;
    }
}