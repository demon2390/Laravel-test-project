<p align="center">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

## Тестовый проект

Создан для освоения фичей и демонстрации рабочего кода

## Что реализованно на данный момент

- [x] Поднять в докере nginx проксю для отделения бека от фронта
    - [x] Изучить балансировку
- [x] В докере подняты и настроены
  - [x] **supervisor** для запуска демонов
  - [x] БД Postgres и Pgadmin для администрирования
  - [x] **Redis** и GUI RedisInsight (в образовательных целях)
  - [x] MailHog для отлова писем
- [x] Добавлен и настроен статанализ (**Larastan**, **PHP-CS-Fixer**, **Rector**)
- [x] Добавлен и настроен **Swagger**
- [x] Переписаны тесты у пользователя (убраны фабрики из тестов)

## IN PROGRESS
- [ ] Сделать документацию и спецификацию API (в процессе)
- [ ] Доделать тесты для ServiceController (сделан только index)

## TODO
- Реализовать оставшиеся методы контроллеров
    - [ ] Checks
    - [ ] Credentials
- Добавить паттерн репозитории (с оберткой в кеш при необходимости)
    - [ ] Checks
    - [ ] Credentials
- Тестирование (убрать фабрики и использовать собственное API)
    - [ ] Services (Store, Show, Update, Delete)
    - [ ] Checks (All)
    - [ ] Credentials (All)
