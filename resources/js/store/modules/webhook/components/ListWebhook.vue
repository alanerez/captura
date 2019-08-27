<template>
    <div class="row">
        <div class="col-md-12">
            <div role="alert" class="alert alert-info mt-3"><i class="fa fa-info-circle"></i>
                List of webhooks
            </div>
            <!--        <button class="btn btn-primary mb-3">Add New</button>-->
            <div class="table-responsive">
                <table class="table table-bordered table-hover js-basic-example dataTable" id="datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>URL</th>
                        <th>Method</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(webhook, k) in webhookData">
                        <td>{{k+1}}</td>
                        <td>{{webhook['name']}}</td>
                        <td>{{webhook['url']}}</td>
                        <td>{{webhook['method']}}</td>
                        <td>
                            <a v-on:click="deleteBtn()" v-bind:href="'delete/'+webhook.id" class="btn btn-danger btn-sm confirm-form" v-bind:data-name="'delete-'+webhook.name" data-message="Delete webhook?" v-bind:title="'Delete webhook ' + webhook.name">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    export default {
        created () {
            var __this = this;
            __this.form_id = window.form_id;
        },
        mounted () {
            var __this = this;
            __this.loadWebhookData();
        },
        computed: {
            ...mapState({
                webhookData: (state) => state.webhook.webhookData,
            }),
        },
        methods: {
            loadWebhookData() {
                var __this = this;
                var payload = {'form_id': __this.form_id};
                __this.$store.dispatch('webhook/loadWebhookData', payload);
            },
            deleteBtn() {
                alert('Are you sure to delete?');
            }
        }
    }
</script>

