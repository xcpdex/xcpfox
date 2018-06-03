<template>
<div>
    <next-prev :per_page="per_page" :links="transactions.links" :float="'float-right'"></next-prev>
    <h1>
        Transactions
        <small class="d-none d-sm-inline lead">{{ transactions.meta ? transactions.meta.total.toLocaleString('en') : '' }}</small>
    </h1>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th colspan="5">Bitcoin</th>
                            <th colspan="3">Counterparty</th>
                        </tr>
                        <tr>
                            <th>Tx Hash</th>
                            <th>Height</th>
                            <th>Source</th>
                            <th>Fee</th>
                            <th>Sats/Byte</th>
                            <th>Category</th>
                            <th>Message Index</th>
                            <th>Valid</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="transaction in transactions.data">
                            <td><a :href="transaction.url">{{ transaction.tx_hash | truncate(15) }}</a></td>
                            <td><a :href="transaction.block_url">{{ transaction.block_index }}</a></td>
                            <td>{{ transaction.source }}</td>
                            <td>{{ transaction.fee_usd }}</td>
                            <td>{{ transaction.fee_rate }}</td>
                            <td class="text-capitalize">{{ transaction.type }}</td>
                            <td>{{ transaction.message_index }}</td>
                            <td :class="transaction.valid ? 'text-success' : 'text-danger'">{{ transaction.valid ? 'Yes' : 'No' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <table-tools :per_page="per_page" :data="transactions"></table-tools>
</div>
</template>
 
<script>
  var VueTruncate = require('vue-truncate-filter')
  Vue.use(VueTruncate)

  export default {
    props: ['page', 'per_page'],
    data () {
      return {
        transactions: {},
      }
    },
    mounted() {
      this.$_transactions_update()
    },
    methods: {
      $_transactions_update() {
        var api = '/api/transactions?page=' + this.page + '&per_page=' + this.per_page
        var self = this
        $.get(api, function(data) {
          self.transactions = data
        });
      },
    },
  }
</script>