Проверка

1. npm install
2. composer install
3. php artisan migrate
4. php artisan storage:link
5. php artisan migrate:fresh 
6. php artisan db:seed --class=AdminUserSeeder

## - composer install --ignore-platform-reqs

## Очистка КЭША
- php artisan config:cache

## - npm install bootstrap

## - composer create-project laravel/laravel .

## - Создал контроллер
- php artisan make:controller ContactController

## - Создание таблицы и доп модели
- php artisan make:model Product -m

## Создание файла для валидации
- php artisan make:request ContactRequest

## Вызов частичек из includes
- @include('includes/НАЗВАНИЕБЕЗТОЧЕК')

## Вызов наследуемых постоянных тем для страницы
- @extends('layouts/main')

## Создание Образа таблицы бд
- $ php artisan make:model Contact -m

## Обновление и добавление введеных данных в таблицу
- $ php artisan migrate

## возврат одного действия назад 
- $ php artisan migrate:rollback

## возврат более одного действия назад 
- $ php artisan migrate:rollback --step=КОЛИЧЕСТВО НЕОБХОДИМЫХ ШАГОВ ВЗАД

## СБРОС ВСЕХ ЗНАЧЕНИЙ 
- $ php artisan migrate:reset 