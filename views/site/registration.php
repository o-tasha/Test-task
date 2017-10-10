<?php
/**
 * Created by PhpStorm.
 * User: nataly
 * Date: 10.10.17
 * Time: 0:27
 */
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrationForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-registration">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('registrationFormSubmitted')): ?>

        <div class="alert alert-success">
            Спасибо за регистрацию!
        </div>

    <?php else: ?>

        <p>
            Пожалуйста, заполните форму регистрации.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'registration-form']); ?>

                <?= $form->field($model, 'fio')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'organizationForm')->radioList($organizationForms); ?>

                <?= $form->field($model, 'inn') ?>

                <?= $form->field($model, 'organizationName') ?>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'registration-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
