import { expect } from '@jest/globals'
import processedApiUrl from '@/services/ProcessedApiUrl'

describe('Get processed URL for API call', () => {
  it('should return base API URL', () => {
    expect(processedApiUrl.getUrl()).toBe('http://localhost:8000/api/songs')
  })

  it('should return processed URL for "Peaches", sorted by title (desc)', () => {
    const options = {
      sortBy: ['title'],
      sortDesc: [false],
      page: 1,
      itemsPerPage: 5
    }
    const search = 'Peaches'
    expect(processedApiUrl.getUrl(options, search)).toBe(
      'http://localhost:8000/api/songs?page=1&itemsPerPage=5&search=Peaches&orderBy[title]=asc'
    )
  })

  it('should return processed URL for empty search, sorted by title (desc) and year (asc)', () => {
    const options = {
      sortBy: ['title', 'year'],
      sortDesc: [true, false],
      page: 1,
      itemsPerPage: 5
    }
    expect(processedApiUrl.getUrl(options)).toBe(
      'http://localhost:8000/api/songs?page=1&itemsPerPage=5&orderBy[title]=desc&orderBy[year]=asc'
    )
  })
})
