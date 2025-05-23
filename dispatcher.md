**Цель**

Разработать мини backend‑сервис для обработки аудиозаписей разговоров диспетчеров, включающий имитацию этапов транскрибации, диоризации и оценки качества разговора.

Сервис должен:

* Принимать задачи через API (аутентификация по токену).
* Хранить задачи и результаты в базе данных PostgreSQL.
* Периодически проверять статус выполнения через планировщик и очереди.
* После завершения передавать данные в фейковую LLM‑систему для оценки и сохранять результаты в БД.

---

## Основные функциональные требования

### 1. API для работы с задачами

* **Создание задачи**

    * Эндпоинт для постановки новой задачи на распознавание аудио.
    * В запросе передавать параметры: URL аудиофайла или иной идентификатор.
* **Получение статуса и результатов**

    * Эндпоинт для получения статуса конкретной задачи и её результатов (фейковые данные транскрибации, диоризации и оценки качества).
* **Аутентификация**

    * Все запросы защищены токеном доступа.

### 2. Хранение данных

* **СУБД**: PostgreSQL.
* **Таблицы**:

    * `tasks` (идентификатор, параметры задачи, статус, метаданные).
    * `transcriptions` (результаты фейковой транскрибации и диоризации).
    * `quality_assessments` (результаты оценки качества разговора).
    * `logs` (записи обращений к внешним сервисам и ошибок).

### 3. Обработка задач

* При поступлении новой задачи сохранять запись в БД со статусом `новая`.
* Использовать очереди для асинхронной обработки и обновления статусов.

### 4. Периодическая проверка статуса

* Каждые 5 минут (планировщик) запускать процесс проверки статуса задач.
* Фейковая интеграция возвращает JSON со статусом.
* При получении статуса `завершено` извлекать результаты транскрибации/диоризации в формате:

  ```json
  [
    { "speaker": "S1", "start": 0.0, "end": 5.0, "text": "Добрый день, как я могу помочь?" },
    { "speaker": "S2", "start": 5.0, "end": 10.0, "text": "Здравствуйте, у меня проблема с заказом." }
  ]
  ```

## Дополнительные компоненты

### Имитация транскрибации и диоризации

* Сервис-класс или метод, который симулирует задержку обработки и возвращает фиксированный JSON.

### Интеграция с LLM‑системой

* Передавать данные транскрибации/диоризации в фейковый LLM‑стаб для оценки качества.
* Сохранять возвращённые фейковые оценки в БД, обновлять статус задачи на `оценено`.

### Логирование и обработка ошибок

* Логировать все обращения к внешним сервисам и возникающие ошибки.
* В случае ошибки интеграции обновлять статус задачи и записывать детали сбоя.

## Технические рекомендации

* **Очереди и планировщик**: настроить асинхронную обработку задач и периодические задания.
* **Фейковые интеграции**:

    * Проверка статуса — сервис возвращает фиксированные или случайные статусы.
    * Транскрибация/диоризация — сервис с задержкой, возвращающий заранее определённый JSON.
    * LLM — стаб-класс, возвращающий предопределённые наборы оценок.
* **Документация**: подготовить `README.md` с инструкциями по запуску, тестированию API и планировщика.
* **Unit‑тестирование** (по желанию):

    * Создание новой задачи.
    * Обновление статуса через планировщик и очереди.
    * Корректная обработка фейковых результатов транскрибации, диоризации и оценки качества.

## Ожидаемый рабочий процесс

1. **Постановка задачи**: пользователь отправляет запрос на распознавание аудио через API с токеном.
2. **Сохранение задачи**: запись в БД со статусом `новая`.
3. **Проверка статуса**: каждые 5 минут сервис проверяет задачи через очередь и фейковый сервис.
4. **Получение транскрибации/диоризации**: при `завершено` извлекаются фейковые данные.
5. **Оценка качества**: результаты передаются в LLM‑стаб и сохраняются вместе с обновлённым статусом.
6. **Логирование**: все операции и ошибки записываются в лог.
7. **Получение результатов**: пользователь запрашивает состояние задачи и получает финальные данные.
