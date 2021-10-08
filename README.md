## Для поднятия проекта после его скачивания:

- создать .env файл и прописать DB_DATABASE=weather
- php artisan make:database
- php artisan migrate

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Эндпоинты

- GET /api/temperature/?source=source&city=city - получить температуру по определенному ресурсу

source = meta|online required, city - required

- GET /api/average-temperature/?city=city - средняя температура по всем ресурсам для города (из локальной БД)

city - required

- GET /api/temperature/popular/?min_count=count&from_date=xxxx-xx-xx&city=city - популярные запросы за период

min_count - required - минимальное кол-во запросов, from_date - начиная от какой даты запросы, city - город
