
# Blog personnel

Un **blog personnel simple** développé avec **Symfony**, incluant un **CRUD d’articles**, un **système d’authentification** avec le **bundle Security** et un **backoffice** pour l’administrateur.

## Fonctionnalités

- Authentification via le **bundle Security**
- Gestion des rôles : `ROLE_USER` et `ROLE_ADMIN`
- Articles : création, lecture, modification et suppression (**CRUD**)
  - Seul l’administrateur peut créer et gérer les articles
- Commentaires :
  - Les utilisateurs peuvent écrire des commentaires
  - Les commentaires deviennent publics uniquement après validation par un administrateur
- Backoffice réservé à l’administrateur pour gérer les articles et modérer les commentaires

## Installation

1. Installer les dépendances :
```bash
composer install
```

2.Configurer .env

3. Créer la base de données :
```bash
php bin/console doctrine:database:create
```

4. Exécuter les migrations :
```bash
php bin/console doctrine:migrations:migrate
```

5. Donner le rôle admin

- Les utilisateurs créés via le formulaire ont par défaut ROLE_USER

Pour donner le rôle ROLE_ADMIN :

- Accéder à la table user dans phpMyAdmin

    - Modifier la colonne roles de l’utilisateur et ajouter "ROLE_ADMIN" :

["ROLE_USER","ROLE_ADMIN"]


5. Enregistrer
