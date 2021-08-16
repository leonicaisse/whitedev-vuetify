# Application Whitedev-Vuetify

## Objectif :

Créer une application permettant l'administration d'une bibliothèque de musiques.
Cette application se décompose en deux pages :

- La première page "Nouvelle Entrée", qui comporte un formulaire permettant l'ajout d'une nouvelle entrée dans la bibliothèque.
- La seconde page "Bibliothèque", qui affiche la liste des entrées présentes dans la bibliothèque, ainsi que des actions CRUD associées à ces entrées. Cette page comporte également un champs de recherche permettant de rechercher un morceau en fonction du titre ou de l'artiste / groupe.

## Bonus

- L'application utilise Vuetify
- Les colonnes de la bibliothèque permettent d'en trier l'affichage selon les différents libellés (Titre, Artiste, etc.)
- Un test unitaire doit être écrit pour une des méthodes mises en place
- La mise en page est libre

## Technologies utilisées

- API/Back: Api Platform (Symfony, MySQL)
- Front: Vue.js / Vuetify

## Installation

### Client

Installation :
```sh
cd client && npm install
```

Lancement de l'application :
```sh
npm run dev
```

Pour lancer les tests :
```sh
npm run test
```

### API

L'API nécessite une version supérieure ou égale à PHP 8.0

Installation :

Tout d'abord, s'il n'est pas installé sur votre système, installez Symfony CLI
```sh
curl -sS https://get.symfony.com/cli/installer | bash
```

Puis installez les dépendences de l'application :
```sh
cd api && composer install
```

Ouvrez le fichier .env et configurez la connexion à la base de données, puis créez cette base grâce aux commandes suivantes
```sh
php bin/console doctrine:database:create
php bin/console doctrine:schema:create
```

Chargez ensuite les fixtures (données pré-enregistrées)
```sh
php bin/console doctrine:fixtures:load
```
Lancez le serveur de l'API
```sh
symfony serve
```

## Réalisé par

[Léo Nicaisse](https://leonicaisse.fr), 2021
