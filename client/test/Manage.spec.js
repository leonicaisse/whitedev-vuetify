import { expect } from '@jest/globals'
import processedApiUrl from '@/services/ProcessedApiUrl'

describe('Get processed URL for API call', () => {
  it('should return processed URL', () => {
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
})
