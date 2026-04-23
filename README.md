## Если у Полины Антоновны не получится запустить с лету (а вдруг)🤯🤯🤯

### Проверить или же установить npm командой npm install

### Создать два bash терминала и в одном прописать php artisan serve а в другом npm run dev (Вообще так и тестщу в vs code)

#### а так по хорошему проблем возникнуть не должно 🙏🙏🙏

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