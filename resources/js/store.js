import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
    state : {
        authUser:false
    },
    getters: {
        getAuthUser(state) {
            return state.authUser
        }
    },
    mutations: {
        setAuthuser(state, data) {
            state.authUser = data
        }
    },
    actions: {
        setAuthuser(state, data) {
            state.commit('setAuthuser', data);
         }
    }
})
