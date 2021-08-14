export default {
  getUrl (options, search) {
    let url = 'http://localhost:8000/api/songs'
    const { sortBy, sortDesc, page, itemsPerPage } = options
    url += `?page=${page}&itemsPerPage=${itemsPerPage}`

    if (search) {
      url += `&search=${search}`
    }

    if (sortBy && sortDesc) {
      sortBy.forEach((criteria, index) => {
        url += `&orderBy[${criteria}]=${sortDesc[index] ? 'desc' : 'asc'}`
      })
    }
    return url
  }
}
