<?php

namespace app\models;

use yii\base\Model;

class SubmitForm extends Model
{
    public string $tg_nickname = '';

    public function rules()
    {
        return [
            ['tg_nickname', 'required'],
            ['tg_nickname', 'string', 'max' => 64],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tg_nickname' => 'Имя пользователя Telegram'
        ];
    }
}