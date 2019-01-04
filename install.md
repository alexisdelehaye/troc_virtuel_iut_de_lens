####On clone le projet :
```
git clone https://forge.univ-artois.fr/projetsIUT/trocVirtuel.git
```

####On se rends dans le dossier du site
```
cd trocVirtuel
```

####On crée une copie du .env, et on le renomme en .env.local
```
cp .env .env.local
```
####On modifie la ligne DATABASE
```
DATABASE_URL=mysql://**user**:**password**@127.0.0.1:3306/**bdd**
```

####on met à jour les dépendences requises
```
composer update
```

####on met à jour notre bdd :
```
php bin/console doctrine:schema:update --force
```

####on charge les fixtures de bases(cela va créer deux utilisateurs, un user, et un admin)
```
php bin/console doctrine:fixtures:load
```

####on lance le serveur 
```
php bin/console server:run
```

####compte de test
user: user@user.fr - secret

admin: admin@admin.fr - secret