<p align="center">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

## Тестовый проект

Создан для освоения фичей и демонстрации рабочего кода

## Что необходимо сделать (TODO)

- [x] Поднять в докере nginx проксю для отделения бека от фронта
    - [x] Изучить балансировку
- [x] Поднять в докере supervisor для запуска демонов
- [x] Поднять в докере БД Postgres и Pgadmin для администрирования
- [x] Поднять в докере Redis и GUI RedisInsight
- [x] Поднять в докере MailHog для писем
- [x] Статанализ (Larastan)

- Реализованы методы контроллеров
    - [x] Services
    - [ ] Checks
    - [ ] Credentials
- Добавлен паттерн репозитории (с декоратором кеш)
    - [x] Services
    - [ ] Checks
    - [ ] Credentials
- Тестирование (убрать фабрики и использовать собственное API)
    - [x] Пользователь (регистрация, валидация, сброс пароля)
    - [ ] Services
        - [x] index
        - [ ] Store
        - [ ] Show
        - [ ] Update
        - [ ] Delete
    - [ ] Checks
    - [ ] Credentials
- [ ] Сделать документацию API

## Что можно улучшить

- Добавить broadcast для некоторых событий, например регистрации пользователя
- Добавить A\B тестирование фич
