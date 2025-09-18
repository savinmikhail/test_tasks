<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <title>Описание задачи: Реализация списка задач</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
            color: #333;
        }
        h1, h2 {
            color: #2c3e50;
        }
        ul {
            margin-top: 0;
        }
        blockquote {
            border-left: 4px solid #ccc;
            padding-left: 1rem;
            color: #666;
            margin: 1rem 0;
            font-style: italic;
            background-color: #f9f9f9;
        }
        code {
            background-color: #f4f4f4;
            padding: 0.2em 0.4em;
            border-radius: 3px;
            font-family: Consolas, monospace;
        }
    </style>
</head>
<body>
<h1>Описание задачи: Реализация списка задач с возможностью изменения статуса выполнения</h1>

<h2>Цель</h2>
<p>Создать веб-интерфейс для отображения списка задач с возможностью помечать задачи как выполненные или невыполненные. Изменения статуса задачи должны отправляться на сервер асинхронно (AJAX) и сохраняться в кеше.</p>

<h2>Основные требования</h2>
<blockquote>К редактированию доступны только файлы <code>models/Task.php</code> и <code>views/task/index.php</code>.</blockquote>

<ul>
    <li>Задача содержит поля:
        <ul>
            <li><code>id</code> — уникальный идентификатор задачи.</li>
            <li><code>order</code> — порядок сортировки.</li>
            <li><code>title</code> — название задачи.</li>
            <li><code>checked</code> — булево значение, указывающее, выполнена задача или нет.</li>
        </ul>
    </li>
    <li>Изначальные данные хранятся в константе <code>INIT_DATA</code>.</li>
    <li>Данные загружаются и сохраняются в кеш приложения (<code>Yii::$app->cache</code>).</li>
    <li>Необходимо реализовать методы:
        <ul>
            <li><code>search($params)</code></li>
            <li><code>save()</code> — сохраняет текущий объект задачи в кеш.</li>
            <li><code>findOne($id)</code> — возвращает задачу по идентификатору.</li>
        </ul>
    </li>
    <li>Валидация поля <code>checked</code> как булевого значения.</li>
    <li>Определены метки атрибутов для отображения в интерфейсе.</li>
</ul>

<h2>Представление (<code>index.php</code>)</h2>
<ul>
    <li>Отображает список задач в виде таблицы с помощью <code>GridView</code>.</li>
    <li>Колонки таблицы:
        <ul>
            <li><code>id</code> — идентификатор задачи.</li>
            <li><code>title</code> — название задачи.</li>
            <li><code>checked</code> — чекбокс, отражающий статус выполнения задачи.</li>
        </ul>
    </li>
    <li>При изменении состояния чекбокса отправляется AJAX POST-запрос на <code>\app\controllers\TaskController::actionSetState</code>.</li>
    <li>В случае ошибки запроса состояние чекбокса восстанавливается.</li>
</ul>

<h2>Технические детали</h2>
<ul>
    <li>Данные задач не хранятся в базе, а кэшируются в памяти приложения.</li>
    <li>Сортировка задач происходит по полю <code>order</code> в порядке возрастания.</li>
    <li>AJAX-запросы позволяют обновлять статус задачи без перезагрузки страницы.</li>
    <li>Валидация и сохранение данных реализованы в модели <code>Task</code>.</li>
    <li>Представление использует стандартные компоненты Yii2 (<code>GridView</code>, <code>ArrayDataProvider</code>).</li>
</ul>
</body>
</html>