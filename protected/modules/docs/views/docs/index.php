## Hello, Docs :-)

-----------------
###Установка:

Проверьте настройки mysql(/etc/mysql/my.cnf), и если чего-то из этого не хватает - добавьте.

[client]
default-character-set = utf8
character_set_client = utf8

[mysqld]
character-set-server = utf8
collation-server = utf8_general_ci
init-connect='SET NAMES utf8;'
skip-character-set-client-handshake=yes


###Далее:

goto: http://domain_name.com/install


Дальше по обстоятельствам :-)


