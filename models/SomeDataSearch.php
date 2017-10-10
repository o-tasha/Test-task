<?php
/**
 * Created by PhpStorm.
 * User: nataly
 * Date: 10.10.17
 * Time: 3:50
 */
namespace app\models;

use Yii;
use yii\base\Model;

class SomeDataSearch extends Model
{
    public function search($date, $type)
    {
        $userId = Yii::$app->user->id;

        $key = [__CLASS__, $date, $userId, $type];

        return Yii::$app->cache->getOrSet($key, function () use ($date, $type, $userId) {
            $dataList = SomeDataModel::find()->where(['date' => $date, 'type' => $type, 'user_id' => $userId])->all();
            $result = [];

            if (!empty($dataList)) {
                foreach ($dataList as $dataItem) {
                    $result[$dataItem->id] = ['a' => $dataItem->a, 'b' => $dataItem->b];
                }
            }

            return $result;
        });
    }
}