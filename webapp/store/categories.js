import { stringify } from 'querystring'
import axios from 'axios'

export const state = () => ({
  roots: [],
  list: [],
  loading: false,
})

export const mutations = {
  setRoots(state, p) {
    state.roots = p
  },

  mergeList(state, p) {
    state.list = p
  },

  setLoading(state, p) {
    state.loading = p
  },
}

export const actions = {
  fetchRoots({ commit }) {
    return new Promise((resolve) => {
      const q = stringify({ parentId: 0, fields: 'id,name,slug' })
      axios
        .get(`http://localhost:8081/api/categories?${q}`)
        .then(({ data, status }) => {
          if (status === 200) {
            commit('setRoots', data.categories)
            resolve(data.categories)
          }
        })
    })
  },

  fetchList({ commit }, payload) {
    commit('setLoading', true)
    return new Promise((resolve, reject) => {
      const q = stringify(payload)
      axios
        .get(`http://localhost:8081/api/categories?${q}`)
        .then(({ data, status }) => {
          if (status === 200) {
            commit('mergeList', data.categories)
            resolve(data.categories)
          } else {
            reject(new Error(`API CODE #${status}`))
          }
        })
        .catch(() => {})
        .finally(() => commit('setLoading', false))
    })
  },
}
