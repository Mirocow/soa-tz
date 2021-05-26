Вам необходимо выбрать один из наиболее популярных фреймворков, с которым вы хорошо знакомы: Yii2, Laravel, Symfony, Phalcon.
Разверните два проекта со следующими названиями: site и balance.
Проект balance отвечает за баланс пользователя на сайте.

Используйте базу данных Postgres или MySQL. 
Структура таблицы balance_history: id (int), value (float), balance (float), user_id (int), created_at (datetime).

Проект balance должен принимать json-rpc запросы:
1. Получить текущий баланс пользователя {"jsonrpc": "2.0", "method": "balance.user-balance", params": {"user_id": 10}, "id": 1}
2. Получить историю платежных операций {"jsonrpc": "2.0", "method": "balance.history", "params": {"limit": 50}, "id": 2}

Проект с названием site должен запросить у проекта balance данные (json-rpc), через серверную часть без использования Ajax т.к. проект balance должен быть закрыт от публичных доступов (условно). На главной странице site выведите баланс пользователя и историю операций. Заполните в seeds тестовые данные в таблицу.

Баланс пользователя – это последняя запись из таблицы balance_history по user_id где balance – текущий баланс, value – числовое значение на которое изменяем баланс при операции, может быть отрицательной при списании.

Вот, что важно в решении для максимальной оценки:
- архитектурное решение
- безопасный код, обработка данных средствами фреймворка
- использование встроенных средств вместо костылей и велосипедов
- код-стайл PSR

# Install

```bash
$ echo "127.0.0.1	soa-tz.loc" >> /etc/hosts
$ cd docker && docker-compose up -d
$ docker-compose exec php composer install
$ docker-compose exec php php ./yii migrate
$ docker-compose exec php php ./yii seeder/seed user
$ docker-compose exec php php ./yii seeder/seed balancehistory
```