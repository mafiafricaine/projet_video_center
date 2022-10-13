# projet_video_center 
Ce projet a été fait pour la formation Dev Web à Cfitech.
Si vous le récupérez. 
N'oubliez pas tout d'abord de faire 
  - composer update
  - npm update
  - 
Pour avoir tous les composants nécessaire pour le bon fonctionnement.
Il faudra allumer Wampserver.
Faire la création de la base de données en faisant :
  - symfony console doctrine:database:create
  - 
N'oubliez pas ensuite de faire une migration vers cette base de données.
Il faudra ensuite faire un petit :
  - symfony console cache:clear
  
Ensuite lancer le serveur symfony ainsi que npm :
  - symfony serve -d
  - npm run dev
  - 
Et la votre site sera fonctionnelle. 
N'oubliez pas de configurer mailtrap dans le fichier .env

Si vous voulez utiliser les tokens, il faudra faire cette commande :
  - symfony console lexik:jwt:generate-keypair

Si ça ne marche pas, créez d'abord un dossier jwt dans config et recommencer.
Si ça marche toujours pas suivez ces étapes :
  - openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
  - openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout

Pour ces deux étapes il faudra introduire le passphrase qui se trouve dans votre fichier .env
Une fois fais vous pourrez utiliser sans problème les tokens JWT.
Si vous avez installez newman sur votre ordinateur, vous pourrez créer un utilisateur et une vidéo premium en une commande :
  - newman run ./postman/TestApiJWT.postman_collection.json  -k -e ./postman/EnvironnementTESTAPIJWT.postman_environment.json

Il vous créera 1 utilisateur déjà vérifié, il suffira de vous loguez :
 -  tokens@cfitech.be
 -  password : tokens

Vous aurez une vidéo prémium
