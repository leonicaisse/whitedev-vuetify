<template>
  <v-container>
    <v-row @submit.prevent>
      <v-col cols="8">
        <v-alert v-if="response" :type="alertType" dismissible>
          {{
            response.status !== 200 && response.status !== 204
              ? `error ${response.status} : `
              : ""
          }}{{ response.message }}
        </v-alert>
        <v-card>
          <v-card-title>
            <span class="text-h5"> New song entry </span>
          </v-card-title>

          <v-card-text>
            <v-form
              ref="form"
              v-model="valid"
              lazy-validation
              @submit.prevent="save"
            >
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
                :items="genres"
                label="Genre"
                clearable
              />
              <v-text-field
                v-model="song.duration"
                label="Duration (ms)"
                :rules="[rules.required, rules.duration]"
              />
            </v-form>
          </v-card-text>

          <v-card-actions>
            <v-spacer />
            <v-btn color="blue darken-1" text @click="close"> Cancel </v-btn>
            <v-btn :disabled="!valid" color="blue darken-1" text @click="save">
              Save
            </v-btn>
          </v-card-actions>
        </v-card>
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
import processedApiUrl from '@/services/ProcessedApiUrl'
export default {
  data: () => ({
    valid: true,
    genres: ['Classical', 'Dance', 'Disco', 'Folk', 'Hip-Hop', 'Jazz', 'Latino', 'Metal', 'Pop', 'Rock', 'Synthpop'],
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

  computed: {
    alertType () {
      const status = this.response.status
      return (status === 400 || status === 404 || status === 500 ? 'error' : 'success')
    }
  },

  methods: {
    async save () {
      if (this.$refs.form.validate()) {
        const song = this.song
        const response = await this.$axios.$post(processedApiUrl.getUrl(), {
          title: song.title,
          artist: song.artist,
          year: song.year,
          genre: song.genre,
          duration: +song.duration
        })
          .then((res) => {
            return (this.response = {
              status: 200,
              message: `Song "${res.title}" has been saved`
            })
          })
          .catch((err) => {
            if (err.response.status === 400) {
              return (this.response = {
                status: 400,
                message: 'There was Some Problem, while processing your Request'
              })
            }
            if (err.response.status === 404) {
              return (this.response = {
                status: 404,
                message: 'API Route is Missing or Undefined'
              })
            }
            if (err.response.status === 500) {
              return (this.response = {
                status: 500,
                message: 'Server Error, please try again later'
              })
            }
          })
        this.response = response
        this.$refs.form.reset()
      }
    }
  }
}
</script>
