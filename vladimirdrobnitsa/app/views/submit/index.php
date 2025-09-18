<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SubmitForm */
/* @var $result array|null */

$this->title = 'Отправка задачи';
?>

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="alert alert-warning">
        Будут отправлены на проверку файлы models/Task.php и views/task/index.php.<br> Обязательно укажите реальный ник Telegram, чтобы мы могли дать обратную связь.
    </div>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<?php if ($result !== null): ?>
    <?php if(key_exists('success', $result) && key_exists('message', $result)) : ?>
    <div class="alert <?=$result['success'] ? 'alert-success' : 'alert-danger'?>">
        <h4>Результат отправки:</h4>
        <pre><?= htmlspecialchars(print_r($result['message'], true)) ?></pre>
    </div>
    <?php else: ?>
        <div class="alert alert-danger">
            'Неизвестная ошибка'
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tg_nickname')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>