<template>
  <v-container>
    <v-card>
      <v-card-title class="headline">
        Application Whitedev-Vuetify
      </v-card-title>
      <hr>
      <v-card-text>
        <section id="goals" class="my-5">
          <h2 class="mb-2">Objectif :</h2>
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
          <h2 class="mb-2">Bonus</h2>
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
          <h2 class="mb-2">Technologies utilisées</h2>
          <ul>
            <li>API/Back: Api Platform (Symfony, MySQL)</li>
            <li>Front: Vue.js / Vuetify</li>
          </ul>
        </section>
        <section id="installation" class="my-5">
          <h2 class="mb-2">Installation</h2>
          <code>A REDIGER</code>
        </section>
        <section id="credits" class="my-5">
          <h2 class="mb-2">Réalisé par</h2>
          <p><a href="https://leonicaisse.fr">Léo Nicaisse</a>, 2021</p>
        </section>
      </v-card-text>
    </v-card>
  </v-container>
</template>
