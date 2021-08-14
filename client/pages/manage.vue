<template>
  <v-container>
    <v-row>
      <v-col cols="8">
        <v-text-field v-model="search" label="Title" />
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
            <v-icon small @click="deleteItem(item)">
              mdi-delete
            </v-icon>
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
                  <v-container>
                    <v-row>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.title"
                          label="Title"
                        />
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.artist"
                          label="Artist or Band"
                        />
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field v-model="editedItem.year" label="Year" />
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-autocomplete
                          v-model="editedItem.genre"
                          :items="genres"
                          label="Genre"
                        />
                      </v-col>
                      <v-col cols="12" sm="6" md="4">
                        <v-text-field
                          v-model="editedItem.duration"
                          label="Duration (ms)"
                        />
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions>
                  <v-spacer />
                  <v-btn color="blue darken-1" text @click="close">
                    Cancel
                  </v-btn>
                  <v-btn color="blue darken-1" text @click="save">
                    Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
            <v-dialog v-model="dialogDelete" max-width="500px">
              <v-card>
                <v-card-title class="text-h5">
                  Are you sure you want to delete this item?<br>
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
          This page allows you to manage existing songs in the library.<br>
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
      const response = await this.$axios.$delete(`http://localhost:8000/api/songs/${id}`)
      this.getDataFromApi()
      this.closeDelete()
      return response
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
      const song = this.editedItem
      const id = this.editedId
      const editedSong = {}
      if (song.title) { editedSong.title = song.title }
      if (song.artist) { editedSong.artist = song.artist }
      if (song.year) { editedSong.year = song.year }
      if (song.genre) { editedSong.genre = song.genre }
      if (song.duration) { editedSong.duration = +song.duration }
      const response = await this.$axios.$put(`http://localhost:8000/api/songs/${id}`, editedSong)
      this.response = response
      this.getDataFromApi()
      this.close()
    }
  }
}
</script>
