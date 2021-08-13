<template>
  <v-container>
    <v-row @submit.prevent>
      <v-col cols="8">
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-text-field
            v-model="song.title"
            label="Title"
            :rules="[rules.required]"
          />
          <v-text-field
            v-model="song.artist"
            label="Artist or Band"
            :rules="[rules.required]"
          />
          <v-text-field
            v-model="song.year"
            label="Year"
            :rules="[rules.required, rules.year]"
          />
          <v-autocomplete
            v-model="song.genre"
            :items="items"
            label="Genre"
            :rules="[rules.required]"
          />
          <v-text-field
            v-model="song.duration"
            label="Duration (ms)"
            :rules="[rules.required, rules.duration]"
          />
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
      title: '',
      artist: '',
      year: '',
      genre: '',
      duration: ''
    },
    response: null,
    rules: {
      required: value => !!value || 'Required.',
      year: (value) => {
        const pattern = /^\d{4}$/
        return pattern.test(value) || 'Invalid year.'
      },
      duration: (value) => {
        const pattern = /^\d+$/
        return pattern.test(value) || 'Invalid duration.'
      }
    }
  }),

  methods: {
    async handleSubmit () {
      if (this.$refs.form.validate()) {
        const song = this.song
        const response = await this.$axios.$post('http://localhost:8000/api/songs', {
          title: song.title,
          artist: song.artist,
          year: song.year,
          genre: song.year,
          duration: +song.duration
        })
        this.response = response
        this.$refs.form.reset()
      }
    }
  }
}
</script>
