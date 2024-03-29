import Vue from 'vue'
import Vuex from 'vuex'
import webhook from './modules/webhook'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  strict: debug,
  modules: {
    webhook
  }
})
