import Vue from 'vue'
import AddWebhook from './components/AddWebhook'
import ListWebhook from './components/ListWebhook'
import axios from "axios";

Vue.component('webhook-list', ListWebhook)
Vue.component('webhook-add', AddWebhook)

const state = {
    headers: [],
    methods: [],
    formats: [],
    fields: [],
    webhookData: [],
}

const getters = {

}

const actions = {
    loadMethods ({ commit }) {
        axios
        .get('/get-all-webhook-methods')
        .then(r => r.data)
        .then(data => {
            commit('SET_METHODS', data.methods)
        })
    },
    loadHeaders ({ commit }) {
        axios
        .get('/get-all-webhook-headers')
        .then(r => r.data)
        .then(data => {
            commit('SET_HEADERS', data.headers)
        })
    },
    loadFormats ({ commit }) {
        axios
        .get('/get-all-webhook-formats')
        .then(r => r.data)
        .then(data => {
            commit('SET_FORMATS', data.formats)
        })
    },
    loadFields ({ commit }, payload) {
        axios
        .get('/get-all-webhook-fields', { params: { form_id: payload.form_id } })
        .then(r => r.data)
        .then(data => {
            commit('SET_FIELDS', data.fields)
        })
    },
    loadWebhookData ({ commit }, payload) {
        axios
            .get('/get-all-webhook', { params: { form_id: payload.form_id } })
            .then(r => r.data)
            .then(data => {
                commit('SET_WEBHOOK_DATA', data.webhookData)
            })
    },
}

const mutations = {
    SET_METHODS (state, methods) {
        state.methods = methods
    },
    SET_HEADERS (state, headers) {
        state.headers = headers
    },
    SET_FORMATS (state, formats) {
        state.formats = formats
    },
    SET_FIELDS (state, fields) {
        state.fields = fields
    },
    SET_WEBHOOK_DATA (state, webhookData) {
        state.webhookData = webhookData
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
