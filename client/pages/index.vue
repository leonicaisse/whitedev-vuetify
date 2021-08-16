<template>
  <v-container>
    <v-card>
      <v-card-title class="headline">
        Application Whitedev-Vuetify
      </v-card-title>
      <hr>
      <v-card-text>
        <section id="goals" class="my-5">
          <h2 class="mb-2">
            Objectif :
          </h2>
          <p>
            Créer une application permettant l'administration d'une bibliothèque
            de musiques. Cette application se décompose en deux pages :
          </p>
          <ul>
            <li>
              La première page "Nouvelle Entrée", qui comporte un formulaire
              permettant l'ajout d'une nouvelle entrée dans la bibliothèque.
            </li>
            <li>
              La seconde page "Bibliothèque", qui affiche la liste des entrées
              présentes dans la bibliothèque, ainsi que des actions CRUD
              associées à ces entrées. Cette page comporte également un champs
              de recherche permettant de rechercher un morceau en fonction du
              titre ou de l'artiste / groupe.
            </li>
          </ul>
        </section>
        <section id="bonus" class="my-5">
          <h2 class="mb-2">
            Bonus
          </h2>
          <ul>
            <li>L'application utilise Vuetify</li>
            <li>
              Les colonnes de la bibliothèque permettent d'en trier l'affichage
              selon les différents libellés (Titre, Artiste, etc.)
            </li>
            <li>
              Un test unitaire doit être écrit pour une des méthodes mises en
              place
            </li>
            <li>La mise en page est libre</li>
          </ul>
        </section>
        <section id="technologies" class="my-5">
          <h2 class="mb-2">
            Technologies utilisées
          </h2>
          <ul>
            <li>API/Back: Api Platform (Symfony, MySQL)</li>
            <li>Front: Vue.js (Nuxt) / Vuetify</li>
          </ul>
        </section>
        <section id="installation" class="my-5">
          <h2 class="mb-2">
            Installation
          </h2>

          <section id="client" class="my-5">
            <h3>Client</h3>

            <div class="my-3">
              <h4>Installation :</h4>
              <code>cd client && npm install</code>
            </div>
            <div class="my-3">
              <h4>Lancement de l'application :</h4>
              <code>npm run dev</code>
            </div>
            <div class="my-3">
              <h4>Pour lancer les tests :</h4>
              <code>npm run test</code>
            </div>
          </section>

          <section id="api" class="my-5">
            <h3>API</h3>
            <p>L'API nécessite une version supérieure ou égale à PHP 8.0</p>
            <div class="my-3">
              <h4>Installation :</h4>
              <p class="mt-3 mb-0">
                Tout d'abord, s'il n'est pas installé sur votre système,
                installez Symfony CLI
              </p>
              <code>curl -sS https://get.symfony.com/cli/installer | bash</code>
              <p class="mt-3 mb-0">Puis installez les dépendences de l'application :</p>
              <code>cd api && composer install</code>
              <p class="mt-3 mb-0">
                Ouvrez le fichier .env et configurez la connexion à la base de
                données, puis créez cette base grâce aux commandes suivantes :
              </p>
              <code>php bin/console doctrine:database:create</code><br>
              <code>php bin/console doctrine:schema:create</code>
              <p class="mt-3 mb-0">Chargez ensuite les fixtures (données pré-enregistrées)</p>
              <code>php bin/console doctrine:fixtures:load</code>
            </div>
            <div class="my-3">
              <h4>Lancement de l'API</h4>
              <code>symfony serve</code>
            </div>
          </section>
        </section>
        <section id="credits" class="my-5">
          <h2 class="mb-2">
            Réalisé par
          </h2>
          <p><a href="https://leonicaisse.fr">Léo Nicaisse</a>, 2021</p>
        </section>
      </v-card-text>
    </v-card>
  </v-container>
</template>
