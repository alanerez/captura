<template>
    <div class="row" id="webhook-page">
        <div class="col-md-12">
            <div class="alert alert-success d-none" id="alert">Webhook successfully created.</div>
            <div class="alert alert-danger d-none" id="alert-danger">Error in creating webhook.</div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-md-offset-8">
                        <label for="name">Name</label>
                        <input v-model="name" type="text" name="name" class="form-control" value="">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="payload_url">Request URL</label>
                <input v-model="url" type="text" name="url" class="form-control" value="">
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3 col-md-offset-10">
                        <label for="method" class="col-form-label">Request Method</label>
                        <select v-model="method" name="method" id="method" class="form-control" required="required">
                            <option :value="null" disabled selected>Select a Method</option>
                            <option v-bind:value="method" v-for="method in methods">{{ method }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-3 col-md-offset-10">
                        <label for="format" class="col-form-label">Request Format</label>
                        <select v-model="format" name="format" id="format" class="form-control" required="required">
                            <option :value="null" disabled selected>Select a Format</option>
                            <option v-bind:value="format" v-for="format in formats">{{ format }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <p class="mb-0"><strong>Request Headers</strong></p>
                <div class="row h-100">
                    <div class="col-md-4">
                        <p class="col-form-label">Key</p>
                    </div>
                    <div class="col-md-4">
                        <p class="col-form-label">Value</p>
                    </div>
                    <div class="col-md-4"></div>
                </div>
                <div class="row h-100 mb-1" v-for="(request_header, index) in request_headers">
                    <div class="col-md-4">
                        <select v-model="request_header.header_key" class="form-control" required="required">
                            <option :value="null" disabled selected>Select a Name</option>
                            <option v-bind:value="header" v-for="header in headers">{{ header }}</option>
                            <option :value="'custom_key'">Add Custom Key</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div v-if="!request_header.header_value_custom">
                            <select v-model="request_header.header_value" v-on:change="changeHeaderValueCustom(index)" class="form-control" required="required">
                                <option :value="null" disabled selected>Select a Field</option>
                                <option v-bind:value="k" v-for="(field, k) in fields">{{ field }}</option>
                                <option :value="'custom_value'">Add Custom Value</option>
                            </select>
                        </div>
                        <div v-else>
                            <input type="text" v-model="request_header.header_value" class="form-control" placeholder="Custom Value">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="btn-group">
                            <button v-on:click="addRequestHeaderRow()" class="btn btn-outline-primary">+</button>
                            <button v-show="request_headers.length > 1" v-on:click="removeRequestHeaderRow(index)" class="btn btn-outline-primary">-</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-md-4 col-md-offset-8">
                        <label class="col-form-label">Request Body</label><br>
                        <label class="fancy-radio">
                            <input name="request_body" id="rb_1" value="all_fields" type="radio"><span><i></i>All Fields</span>
                        </label>
                        <label class="fancy-radio">
                            <input name="request_body" id="rb_2" value="selected_fields" type="radio" checked><span><i></i>Selected Fields</span>
                        </label>
                    </div>
                </div>
                <div class="row h-100">
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                        <p class="col-form-label">Key</p>
                    </div>
                    <div class="col-md-4">
                        <p class="col-form-label">Value</p>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row h-100 mb-1" v-for="(req_body, index) in request_body">
                    <div class="col-md-1">
                        <input type="checkbox" v-model="req_body.body_check" :key="index" style="height: 55%; margin-top: 15%; margin-left: 50%; width: 40%;">
                    </div>
                    <div class="col-md-4">
                        <input type="text" v-model="req_body.body_field" class="form-control form-select" placeholder="Custom Key">
                    </div>
                    <div class="col-md-4">
                        <div v-if="!req_body.body_value_custom">
                            <select v-model="req_body.body_value" v-on:change="changeBodyFieldCustom(index)" class="form-control form-select" required="required">
                                <option :value="null" disabled selected>Select a Field</option>
                                <option v-bind:value="k" v-for="(field, k) in fields">{{ field }}</option>
                                <option :value="'custom_value'">Add Custom Value</option>
                            </select>
                        </div>
                        <div v-else>
                            <input type="text" v-model="req_body.body_value" class="form-control" placeholder="Custom Value">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="btn-group">
                            <button v-on:click="addRequestBodyRow()" class="btn btn-outline-primary form-select">+</button>
                            <button v-show="request_body.length > 1" v-on:click="removeRequestBodyRow(index)" class="btn btn-outline-primary form-select">-</button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" v-on:click="saveData()" class="btn btn-success">Add Webhook</button>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import { mapState, mapMutations, mapActions } from 'vuex'
    export default {
        data: function() {
            return {
                form_id: null,
                request_headers: [{
                    header_key: null,
                    header_value: null,
                    header_value_custom: false
                }],
                request_body: [{
                    body_check: false,
                    body_field: null,
                    body_value: null,
                    body_value_custom: false
                }],
                name: '',
                url: '',
                method: null,
                format: null,
            }
        },
        created () {
            var __this = this;
            __this.form_id = window.form_id;
        },
        mounted () {
            var __this = this;
            __this.loadMethods();
            __this.loadHeaders();
            __this.loadFormats();
            __this.loadFields();
        },
        computed: {
            ...mapState({
                methods: (state) => state.webhook.methods,
                headers: (state) => state.webhook.headers,
                formats: (state) => state.webhook.formats,
                fields: (state) => state.webhook.fields,
            }),
        },
        methods: {
            ...mapActions({
                loadMethods: 'webhook/loadMethods',
                loadHeaders: 'webhook/loadHeaders',
                loadFormats: 'webhook/loadFormats',
            }),
            loadFields() {
                var __this = this;
                var payload = {'form_id':  __this.form_id};
                __this.$store.dispatch('webhook/loadFields', payload);
            },
            addRequestHeaderRow(){
                var __this = this;
                __this.request_headers.push({header_key: null, header_value: null, header_value_custom: false});
            },
            removeRequestHeaderRow(index){
                var __this = this;
                __this.request_headers.splice(index, 1);
            },
            changeHeaderValueCustom(index){
                var __this = this;
                if(__this.request_headers[index].header_value == 'custom_value') {
                    __this.request_headers[index].header_value_custom = true;
                    __this.request_headers[index].header_value = null;
                }
            },
            addRequestBodyRow(){
                var __this = this;
                __this.request_body.push({body_check: false, body_field: null, body_value: null, body_value_custom: false});
            },
            removeRequestBodyRow(index){
                var __this = this;
                __this.request_body.splice(index, 1);
            },
            changeBodyFieldCustom(index){
                var __this = this;
                if(__this.request_body[index].body_value == 'custom_value') {
                    __this.request_body[index].body_value_custom = true;
                    __this.request_body[index].body_value = null;
                }
            },
            saveData(){
                var __this = this;
                var headers = __this.request_headers;
                var body = __this.request_body;
                var name = __this.name;
                var url = __this.url;
                var method = __this.method;
                var format = __this.format;
                var form_id = __this.form_id;

                var sel_body = [];
                body.map(function (el) {
                    if(document.getElementById('rb_1').checked){
                        body = __this.fields;
                    } else{
                        if(el.body_check){
                            sel_body.push(el);
                            body = sel_body;
                        }
                    }
                })

                $(window).scroll(function() {
                    var height = $(window).scrollTop();
                });

                $.ajax({
                    type: 'POST',
                    url: "/create-webhook/",
                    data: {
                        name:name,
                        url: url,
                        method: method,
                        format: format,
                        headers: headers,
                        body: body,
                        form_id: form_id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res){
                        $("html, body").animate({ scrollTop: 0 });
                        document.getElementById('alert').classList.remove('d-none')
                        setTimeout(location.reload(), 800);
                    },
                    error: function(){
                        $("html, body").animate({ scrollTop: 0 });
                        document.getElementById('alert-danger').classList.remove('d-none')
                        setTimeout(location.reload(), 800);
                    }
                })
            }
        }
    }
</script>
