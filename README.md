# chdphp #

Handle of characters transfer by wowtransfer.com


## Desctription ##

Application divides in two parts:

1. Frontend - this is part for users (players).

2. Backend - this is part for administrations, allow create, delete and update transfers, create and delete the characters.


## Requirements

* PHP 5.3+
* MySQL 5.1+


## Dependenses ##

### Installator

* jquery-2.1.1
* bootstrap-3.2.0

### Application

* Yii framework version 1.15+
 * yiistrap, we are use also
     * yiibootstrap, depricated
     * yiibooster-4.0.1, very large
     * yii bootstrap 3 module, very similar to yiistrap


## Aims

* Simple application, KISS principle.
* Minimum dependences.
* Minimum network data.
* Include installer.
* If service is denied then use default values, don't throw exceptions!


## Roles ##

1. user - Simple users (players).
2. admin - Full privileges.


## Sitemap ##

Simple map of application

frontend

* /site/login   - login
* /site/logout  - logout
* /transfers/           - my transfers
* /transders/create     - create transfer
* /transfers/id         - view transfer
* /transfers/update/id  - update transfer's attributes
* /transfers/delete/id  - delete transfer

backend

* /transfers/           - view all transfers
* /transfers/id         - view transfer
* /transfers/update/id  - update transfer's attributes
* /transders/delete/id  - delete transfer
* /transfers/char/id    - handle of character
* /transfers/deletechar/id  - delete character by transfer's id


## Code style ##

* Yes, we use tabs!


## TODO ##

* Defence from infinite login: give 5 attempts on 15 minutes
* Apply cache
* Add multilanguages
* register css, js files
* Rewrite application based on yii2 ()
* Move the dumps to service