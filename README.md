Hello and welcome in my project "SnowTricks" !
----

Snowtricks is a community site for sharing snowboard tricks where you can see the tricks proposed by the community or log in to add your participation, creating new tricks, modifying existing ones or posting comments.

I created this website as part of my PHP and Symfony Application Developer formation at Openclassrooms. This project is my first application with Symfony and it won't be the last one (for sure!).

To install this site, here are the steps to follow:

First make sure you have PHP 8.0.10 or newer !

1) Clone or download this repository, create a new folder "SnowTricks" and place the projet in it.

2) Run `composer install` in command in the folder "SnowTricks".

3) Create a new database : change the value of DATABASE_URL in the file .env to match with your database parameters.
   
4) Run `symfony console doctrine:database:create` in command to create your database.

5) Change the value of MAILER_DSN in the file .env to match with your mailer parameters.


Here are the analysis by CodeClimate :

[![Maintainability](https://api.codeclimate.com/v1/badges/ce74b8c22c739e98135d/maintainability)](https://codeclimate.com/github/FloryssRu/SnowTricks/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/ce74b8c22c739e98135d/test_coverage)](https://codeclimate.com/github/FloryssRu/SnowTricks/test_coverage)


I hope you will like my SnowTricks app !

Have a nice day,

FloryssRu