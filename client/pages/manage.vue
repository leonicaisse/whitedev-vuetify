<template>
  <v-container>
    <v-row>
      <v-col cols="8">
        <v-alert v-if="response" :type="response.status" dismissible>
          {{ response.message }}
        </v-alert>
        <v-text-field v-model="search" label="Search..." />
        <v-data-table
          :headers="headers"
          :items="songs"
          :options.sync="options"
          :server-items-length="totalSongs"
          :items-per-page="songsPerPage"
          :loading="loading"
          multi-sort
        >
          <template #[`item.duration`]="{ item }">
            {{ millisecondsToDuration(item.duration) }}
          </template>
          <template #[`item.actions`]="{ item }">
            <v-icon small class="mr-2" @click="editItem(item)">
              mdi-pencil
            </v-icon>
            <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
          </template>
          <template #top>
            <v-dialog v-model="dialogEdit" max-width="500px">
              <v-card>
                <v-card-title>
                  <span class="text-h5">
                    (#{{ editedItem.id }}) {{ editedItem.title }}
                  </span>
                </v-card-title>

                <v-card-text>
                  <v-form ref="form" v-model="valid" lazy-validation @submit.prevent="save">
                    <v-text-field
                      v-model="editedItem.title"
                      label="Title"
                      :rules="[rules.required]"
                    />
                    <v-text-field
                      v-model="editedItem.artist"
                      label="Artist or Band"
                      :rules="[rules.required]"
                    />
                    <v-text-field
                      v-model="editedItem.year"
                      label="Year"
                      :rules="[rules.required, rules.year]"
                    />
                    <v-autocomplete
                      v-model="editedItem.genre"
                      :items="genres"
                      label="Genre"
                      clearable
                    />
                    <v-text-field
                      v-model="editedItem.duration"
                      label="Duration (ms)"
                      :rules="[rules.required, rules.duration]"
                    />
                  </v-form>
                </v-card-text>

                <v-card-actions>
                  <v-spacer />
                  <v-btn color="blue darken-1" text @click="close">
                    Cancel
                  </v-btn>
                  <v-btn
                    :disabled="!valid"
                    color="blue darken-1"
                    text
                    @click="save"
                  >
                    Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
            <v-dialog v-model="dialogDelete" max-width="500px">
              <v-card>
                <v-card-title class="text-h5">
                  Are you sure you want to delete this item?<br />
                  <i>(#{{ editedItem.id }}) {{ editedItem.title }}</i>
                </v-card-title>
                <v-card-actions>
                  <v-spacer />
                  <v-btn color="blue darken-1" text @click="closeDelete">
                    Cancel
                  </v-btn>
                  <v-btn color="blue darken-1" text @click="deleteItemConfirm">
                    Confirm delete
                  </v-btn>
                  <v-spacer />
                </v-card-actions>
              </v-card>
            </v-dialog>
          </template>
        </v-data-table>
      </v-col>
      <v-col cols="4">
        <h1>Manage</h1>
        <p>
          This page allows you to manage existing songs in the library.<br />
          Simply use the associated actions to edit or delete a song.
        </p>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import processedApiUrl from '@/services/ProcessedApiUrl'
export default {
  data () {
    return {
      totalSongs: 0,
      songs: [],
      songsPerPage: 5,
      loading: true,
      options: {},
      search: '',
      response: '',
      dialogEdit: false,
      dialogDelete: false,
      editedIndex: -1,
      editedItem: {
        title: '',
        artist: '',
        year: 0,
        genre: '',
        duration: 0
      },
      valid: true,
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
      },
      genres: ['Classical', 'Dance', 'Disco', 'Folk', 'Hip-Hop', 'Jazz', 'Latino', 'Metal', 'Pop', 'Rock', 'Synthpop'],
      headers: [
        {
          text: 'Title',
          align: 'start',
          value: 'title'
        },
        { text: 'Artist or Band', value: 'artist' },
        { text: 'Year', value: 'year' },
        { text: 'Genre', value: 'genre' },
        { text: 'Duration', value: 'duration' },
        { text: 'Actions', value: 'actions', sortable: false }
      ]
    }
  },

  computed: {
    computedUrl () {
      return processedApiUrl.getUrl(this.options, this.search)
    }
  },

  watch: {
    options: {
      handler () {
        this.getDataFromApi()
      },
      deep: true
    },

    search: {
      handler () {
        this.handleSearch()
      }
    }
  },

  mounted () {
    this.getDataFromApi()
  },

  methods: {
    async getDataFromApi () {
      this.loading = true
      // TODO : handle both title and artist search
      await this.$axios.get(this.computedUrl).then((res) => {
        const data = res.data
        this.songs = data['hydra:member']
        this.totalSongs = data['hydra:totalItems']
        this.loading = false
      })
    },

    millisecondsToDuration (milliseconds) {
      const minutes = Math.floor(milliseconds / 60000)
      const seconds = ((milliseconds % 60000) / 1000).toFixed(0)
      return minutes + ':' + (seconds < 10 ? '0' : '') + seconds
    },

    handleSearch () {
      clearTimeout(this.timeout)
      const self = this
      this.timeout = setTimeout(function () {
        self.getDataFromApi()
      }, 500)
    },

    editItem (item) {
      this.editedIndex = this.songs.indexOf(item)
      this.editedId = item.id
      this.editedItem = Object.assign({}, item)
      this.dialogEdit = true
    },

    deleteItem (item) {
      this.editedIndex = this.songs.indexOf(item)
      this.editedId = item.id
      this.editedItem = Object.assign({}, item)
      this.dialogDelete = true
    },

    async deleteItemConfirm () {
      const id = this.editedId
      const response = await this.$axios.$delete(`${processedApiUrl.getUrl()}/${id}`)
        .then((res) => {
          return (this.response = {
            status: 'success',
            message: `Song "${this.editedItem.title}" has been deleted`
          })
        })
        .catch((err) => {
          return (this.response = {
            status: 'error',
            message: 'Something went wrong, please try again later.',
            error: err
          })
        })
      this.getDataFromApi()
      this.closeDelete()
      this.response = response
    },

    close () {
      this.dialogEdit = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    closeDelete () {
      this.dialogDelete = false
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem)
        this.editedIndex = -1
      })
    },

    async save () {
      if (this.$refs.form.validate()) {
        const song = this.editedItem
        const id = this.editedId
        const editedSong = {}
        if (song.title) { editedSong.title = song.title }
        if (song.artist) { editedSong.artist = song.artist }
        if (song.year) { editedSong.year = song.year }
        if (song.genre) { editedSong.genre = song.genre }
        if (song.duration) { editedSong.duration = +song.duration }
        const response = await this.$axios.$put(`${processedApiUrl.getUrl()}/${id}`, editedSong)
          .then((res) => {
            return (this.response = {
              status: 'success',
              message: `Changes have been saved for song "${res.title}"`
            })
          })
          .catch((err) => {
            return (this.response = {
              status: 'error',
              message: 'Something went wrong, please try again later.',
              error: err
            })
          })
        this.response = response
        this.getDataFromApi()
        this.close()
      }
    }
  }
}
</script>
