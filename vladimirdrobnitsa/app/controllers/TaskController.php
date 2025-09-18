<?php


namespace app\controllers;


use app\models\Task;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class TaskController extends Controller
{
    public function actionIndex()
    {
        $task = new Task();
        $dataProvider = $task->search(Yii::$app->request->queryParams);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionSetState($id)
    {
        $model = Task::findOne($id);
        if($model && $model->load(Yii::$app->request->post(), '')) {
            $model->save();
            return true;
        }
        throw new BadRequestHttpException();
    }
}