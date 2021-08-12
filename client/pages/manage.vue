<template>
  <v-container>
    <v-row>
      <v-col cols="8">
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
          This page allows you to manage existing songs in the library.<br>
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
    }
  },
  mounted () {
    this.getDataFromApi()
  },
  methods: {
    async getDataFromApi () {
      const { /* sortBy, sortDesc, */ page, itemsPerPage } = this.options
      this.loading = true
      await this.$axios.get(`http://localhost:8000/api/songs?page=${page}&itemsPerPage=${itemsPerPage}`).then((res) => {
        const data = res.data
        this.songs = data['hydra:member']
        this.totalSongs = data['hydra:totalItems']
        this.loading = false
      })
    }
  }
}
</script>
