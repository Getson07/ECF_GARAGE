# ECF_GARAGE DELOFON EGNON KOKOU GAETAN

Git flow utiliser pour la gestion de projet
Utilisation de require egulias/email-validator pour pouvoir utiliser le validateur d'e-mail en mode strict
Ajout du dossier global photo_dir dans le fichier service.yaml afin de pouvoir y stocker les différentes images
Activation de l'extension de php.ini intl pour pouvoir utiliser la contrainte NoSuspiciousCharacters.
Req Mime type pour pouvoir gérer le type mime des fichiers et utiliser la contraintes Image
Ajout de mailer, de symfony/mailgun et symfony/http-client pour pouvoir envoyer de mail à la soumission du formulaire de contact
Création d'un compte mailgun et récupération des identifiants smtp
Mettre client en cascade persiste dans Contact

# BIEN DEMARRE LE PROJET EN LOCAL

1. Réaliser un composer install suivie d'un npm install après clonage du projet
2. Dans votre fichier .env, réaliser la configuration pour l'accès à la base de données par doctrine
   Exemple: DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4" (MySQL)
3. Dans l'invite de commande, faite exécutez les commandes suivantes:
   - php bin/console doctrine:database:create
   - php bin/console doctrine:migrations:migrate
   - php bin/console doctrine:fixtures:load
4. Cette dernière commande hydrate la base de donnée avec différentes données ainsi qu'un administrateur avec les identifiants suivants:
   username: v.parrot@admin.com
   Mot de passe: v.p@rrot280
5. Seul le compte administrateur vous permettra de créer des comptes employés
6. L'ensemble des fonctionnalités demandées peuvent être testés (certaines en inscrivant le nom de la route dans l'url)
