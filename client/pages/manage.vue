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
        />
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
export default {
  data () {
    return {
      totalSongs: 0,
      songs: [],
      songsPerPage: 5,
      loading: true,
      options: {},
      search: '',
      headers: [
        {
          text: 'Title',
          align: 'start',
          sortable: false,
          value: 'title'
        },
        { text: 'Artist or Band', value: 'artist' },
        { text: 'Year', value: 'year' },
        { text: 'Genre', value: 'genre' },
        { text: 'Duration', value: 'duration' }
      ]
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
      const { /* sortBy, sortDesc, */ page, itemsPerPage } = this.options
      this.loading = true
      // TODO : handle both title and artist search
      await this.$axios.get(`http://localhost:8000/api/songs?page=${page}&itemsPerPage=${itemsPerPage}${this.search ? '&title=' + this.search : ''}`).then((res) => {
        const data = res.data
        this.songs = data['hydra:member']
        this.totalSongs = data['hydra:totalItems']
        this.loading = false
      })
    },

    handleSearch () {
      clearTimeout(this.timeout)
      const self = this
      this.timeout = setTimeout(function () {
        self.getDataFromApi()
      }, 500)
    }
  }
}
</script>
