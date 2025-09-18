<?php

use yii\helpers\Url;


$this->title = 'Список задач';

$setStateUrl = Url::to(['task/set-state']);

$js = <<<JS
// Обработчик клика по чекбоксу

JS;

$this->registerJs($js);

?>

    <h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

    <div class="alert alert-warning">
        Отредактируйте models/Task.php и views/task/index.php в соответствии с условиями задачи.
    </div>

<?= 'Табличные данные' ?>