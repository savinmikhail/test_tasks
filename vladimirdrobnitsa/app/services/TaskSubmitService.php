<?php

namespace app\services;

use Yii;
use yii\httpclient\Client;

class TaskSubmitService
{
    private string $tgNickname;
    private string $endpoint = 'https://pulse.vladimirdrobnitsa.online/applicants/submit-test';
//    private string $endpoint = 'http://pulse.local/applicants/submit-test';

    // Пути к файлам относительно корня приложения
    private array $files = [
        'models/Task.php',
        'views/task/index.php',
    ];

    public function __construct(string $tgNickname)
    {
        $this->tgNickname = $tgNickname;
    }

    /**
    * Создаёт ZIP-архив с файлами и возвращает путь к архиву
    * @return string путь к архиву
    * @throws \Exception
    */
    private function createZipArchive(): string
    {
        $zipPath = Yii::getAlias('@runtime/task_files_' . uniqid() . '.zip');

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE) !== true) {
            throw new \Exception('Не удалось создать архив');
        }

        foreach ($this->files as $file) {
            $fullPath = Yii::getAlias('@app/' . $file);
            if (!file_exists($fullPath)) {
                throw new \Exception("Файл не найден: $fullPath");
            }
        // Добавляем файл в архив, сохраняя структуру
            $zip->addFile($fullPath, $file);
        }

        $zip->close();

        return $zipPath;
    }

    /**
    * Отправляет архив на внешний API
    * @return array|null ответ сервера или null при ошибке
    * @throws \Exception
    */
    public function submit(): ?array
    {
        $zipPath = $this->createZipArchive();

        $client = new Client();

        $response = $client->createRequest()
        ->setMethod('POST')
        ->setUrl($this->endpoint)
        ->addFile('archive', $zipPath)
        ->setData(['tg_nickname' => $this->tgNickname])
        ->send();

        // Удаляем временный архив
        @unlink($zipPath);
        Yii::warning($response);

        if ($response->isOk) {
            return $response->data;
        }

        Yii::error('Ошибка отправки архива: ' . $response->content, __METHOD__);
        return null;
    }
}