<?php


namespace app\controllers;

use app\models\SubmitForm;
use app\services\TaskSubmitService;
use Yii;
use yii\web\Controller;

class SubmitController extends Controller
{
    public function actionIndex()
    {
        $model = new SubmitForm();
        $result = null;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $service = new TaskSubmitService($model->tg_nickname);
                $result = $service->submit();
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', 'Ошибка: ' . $e->getMessage());
            }
        }

        return $this->render('index', [
            'model' => $model,
            'result' => $result,
        ]);
    }
}