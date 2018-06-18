<template>
<div>
    <next-prev :per_page="per_page" :links="messages.links" :float="'float-right'"></next-prev>
    <h1>Messages <small class="d-none d-sm-inline lead">{{ messages.meta ? messages.meta.total.toLocaleString('en') : '' }}</small></h1>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th colspan="5">Counterparty</th>
                            <th colspan="2">Bitcoin</th>
                        </tr>
                        <tr>
                            <th>Age</th>
                            <th>Message Index</th>
                            <th>Command</th>
                            <th>Category</th>
                            <th>Bindings</th>
                            <th>Height</th>
                            <th>Tx Hash</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="message in messages.data">
                            <td>{{ message.block_time_ago }}</td>
                            <td><a :href="message.url">{{ message.message_index }}</a></td>
                            <td class="text-capitalize">{{ message.command }}</td>
                            <td class="text-capitalize">{{ message.category.replace('_', ' ') }}</td>
                            <td :title="JSON.stringify(message.bindings)">{{ JSON.stringify(message.bindings) }}</td>
                            <td><a :href="message.block_url">{{ message.block_index }}</a></td>
                            <td v-if="message.tx_hash"><a :href="message.transaction_url">{{ message.tx_hash }}</a></td>
                            <td v-else></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <table-tools :per_page="per_page" :data="messages"></table-tools>
</div>
</template>
 
<script>
  export default {
    props: ['page', 'per_page'],
    data () {
      return {
        messages: {}
      }
    },
    mounted() {
      this.$_messages_update()
    },
    methods: {
      $_messages_update() {
        var api = '/api/messages?page=' + this.page + '&per_page=' + this.per_page
        var self = this
        $.get(api, function(data) {
          self.messages = data
        });
      }
    }
  }
</script>