<?php
/**
 * Created by PhpStorm.
 * User: nataly
 * Date: 08.01.18
 * Time: 21:21
 */
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\Order;

class CatalogController extends Controller
{
    /**
     * Вывод товаров
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Оформление заказа
     *
     * @return array
     */
    public function actionCheckout()
    {
        if (Yii::$app->request->isAjax) {
            $products = Yii::$app->request->post();
            $status = 'error';
            if (isset($products)) {

                $order = new Order();

                if($order->checkout($products)) {
                    $htmlBody = $this->renderPartial('@app/views/order/_notification', ['products' => $products]);

                    if(Yii::$app->mailer->compose()
                        ->setFrom(\Yii::$app->params['adminEmail'])
                        ->setTo(\Yii::$app->params['orderEmailTo'])
                        ->setSubject('Новый заказ')
                        ->setHtmlBody($htmlBody)
                        ->send()) {
                        $status = 'ok';
                    }
                }

                \Yii::$app->response->format = Response::FORMAT_JSON;
                return [
                    'status' => $status,
                ];
            }
        }
    }
}