README
======

99 БУТЫЛОК

1. Скачивание и распаковка
==========================

"99 бутылок" можно скачать с http://github.ru/bankirtest клацнув
на download source вверху справа. После скачивания распакуйте
архив (например, в папку bankirtest)  

или с помощью git, выполнив
git clone http://github.com/boxfrommars/bankirtest.git
в текущей директории создастся папка bankirtest



2. Настройка VHOST
==================

Пример настройки

<VirtualHost *:80>
   DocumentRoot "/path/to/bankirtest/public"
   ServerName bankirtest.dev

   # Удалите строчку ниже при выходе в production
   SetEnv APPLICATION_ENV development
    
   <Directory "/path/to/bankirtest/public">
       Options Indexes MultiViews FollowSymLinks
       AllowOverride All
       Order allow,deny
       Allow from all
   </Directory>
</VirtualHost>



3. Настройка БД
===============

"99 бутылок" использует PostgreSQL.

3.1 Создайте новую базу данных (например, bankirtest)

3.2 Выполните SQL код из файла /path/to/bankirtest/docs/install.sql

3.3 Настройте соединение приложения с БД, для этого откройте файл
    /path/to/bankirtest/application/configs/application.ini
    
    и установите нужные значения для
    
    resources.db.params.host = 127.0.0.1
    resources.db.params.username = postgres
    resources.db.params.password = qt3nf
    resources.db.params.dbname = bankirtest
    
    сохраните файл.

    
    
4. Обновление поискового индекса
================================

4.1 ВАЖНО: удалите папку /path/to/bankirtest/application/data/searchindex

4.2 Откройте приложение в браузере
    и выполните поиск любой фразы (используя форму поиска справа).
    поисковый индекс должен создаться и обновиться.
    далее любое изменение в данных, автоматически изменяет поисковый индекс



5. Приложение настроено, можно пользовать
=========================================



6. Возможные проблемы
=====================

6.1 Вполне возможно, что вам придётся изменить
    права доступа для /path/to/bankirtest/application/data

6.2 Вполне возможно, что вам придётся самостоятельно отключить магические кавычки
    (в файле .htaccess есть нужная директива, но она вполне может не сработать,
    если так произошло, то удалите строчку
    php_flag magic_quotes_gpc Off
    в начале /path/to/bankirtest/public/.htaccess) и воспользуйтесь рабочим для
    вас способом
