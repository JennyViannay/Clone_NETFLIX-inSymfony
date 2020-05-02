# SYMFONY PROJECT

## Clone Netflix
This project is a clone of Netflix.
You can Register/Login/Logout <br>
There is also an administration part on /admin with CRUD for movies. (if you're logged in ADMIN role)<br>
When you're log in, you can like/dislike movies, search a movie by name or category.<br>

With Fixtures, 2 users are created :
+ admin@gmail.com // mdp : admin
+ user@gmail.com // mdp : user

### To get project :
- Clone Repo
- Launch composer install
- Set access BDD in .env
- Launch ```php bin/console doctrine:create:database```
- Launch ```php bin/console make:migration```
- Launch ```php bin/console doctrine:make:migrate```
- Launch ```php bin/console make:fixture:load```

### To get more DATA in movie :
- In Folder BDD you can find some sql script to add more data on your database.

## Lauch Project 
- Launch```symfony serve```

## DEMO HERE 
[Demo](https://zupimages.net/viewer.php?id=20/18/t35n.png)(https://www.loom.com/share/3d319551587f4869882a8163d524b22a)
