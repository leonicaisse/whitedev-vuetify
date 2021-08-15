export default {
  getUrl (options = null, search = null) {
    let url = 'http://localhost:8000/api/songs'
    if (options) {
      const { page, itemsPerPage } = options
      url += `?page=${page}&itemsPerPage=${itemsPerPage}`
    }

    if (search) {
      url += `&search=${search}`
    }

    if (options) {
      const { sortBy, sortDesc } = options
      if (sortBy && sortDesc) {
        sortBy.forEach((criteria, index) => {
          url += `&orderBy[${criteria}]=${sortDesc[index] ? 'desc' : 'asc'}`
        })
      }
    }

    return url
  }
}
