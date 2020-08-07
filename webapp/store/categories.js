import axios from 'axios'

export const state = () => ({
  list: [],
  loading: false,
})

export const mutations = {
  mergeList(state, p) {
    state.list = p
  },

  setLoading(state, p) {
    state.loading = p
  },
}

export const actions = {
  fetchList({ commit }, payload) {
    const { parentId } = payload

    commit('setLoading', true)
    return new Promise((resolve, reject) => {
      axios
        .get(`http://localhost:8081/api/categories?parent_id=${parentId}`)
        .then(({ data, status }) => {
          if (status === 200) {
            commit('mergeList', data.categories)
            resolve()
          } else {
            reject(new Error(`API CODE #${status}`))
          }
        })
        .catch(() => {})
        .finally(() => commit('setLoading', false))
    })
  },
}
