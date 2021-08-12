<template>
  <v-container>
    <v-row @submit.prevent>
      <v-col cols="8">
        <v-form>
          <v-text-field v-model="song.title" label="Title" />
          <v-text-field v-model="song.artist" label="Artist or Band" />
          <v-text-field v-model="song.year" label="Year" />
          <v-autocomplete v-model="song.genre" :items="items" label="Genre" />
          <v-text-field v-model="song.duration" label="Duration (ms)" />
          <v-btn
            :disabled="!valid"
            color="success"
            class="mr-4"
            @click="handleSubmit"
          >
            Submit
          </v-btn>
        </v-form>
      </v-col>
      <v-col cols="4">
        <h1>Create New</h1>
        <p>
          This page allows you to add a new song to the library.<br />
          Simply fill the fields and press submit to register a new song.
        </p>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    valid: true,
    items: ['Rap', 'Rock', 'Pop', 'Classique'],
    song: {
      title: null,
      artist: null,
      year: null,
      genre: null,
      duration: null
    },
    response: null
  }),

  methods: {
    async handleSubmit () {
      const song = this.song
      const response = await this.$axios.$post('http://localhost:8000/api/songs', {
        title: song.title,
        artist: song.artist,
        year: song.year,
        genre: song.year,
        duration: +song.duration
      })
      this.response = response
    }
  }
}
</script>
