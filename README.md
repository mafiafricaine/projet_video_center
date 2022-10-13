# projet_video_center 
Ce projet a été fait pour la formation Dev Web à Cfitech.
Si vous le récupérez. 
N'oubliez pas tout d'abord de faire 
  - composer update
  - npm update
Pour avoir tous les composants nécessaire pour le bon fonctionnement.
Il faudra allumer Wampserver.
Faire la création de la base de données en faisant :
  - symfony console doctrine:database:create
N'oubliez pas ensuite de faire une migration vers cette base de données.

Il faudra ensuite faire un petit :
  - symfony console cache:clear
Ensuite lancer le serveur symfony ainsi que npm :
  - symfony serve -d
  - npm run dev

