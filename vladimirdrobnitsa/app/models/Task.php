<?php

namespace app\models;

use yii\base\Model;

class Task extends Model
{
    public $id;
    public $order;
    public $title;
    public $checked;

    private const INIT_DATA = [
        ['id' => 4, 'order' => 2, 'title' => 'Сделать тестовое задание', 'checked' => false],
        ['id' => 2, 'order' => 1, 'title' => 'Написать документацию', 'checked' => true],
        ['id' => 1, 'order' => 3, 'title' => 'Отправить на проверку', 'checked' => false],
    ];


    public function search($params) {
        return false;
    }

    public function save()
    {
        return false;
    }

    public static function findOne($id) {
        return false;
    }
}