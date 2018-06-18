<template>
<div>
    <next-prev :per_page="per_page" :links="transactions.links" :float="'float-right'"></next-prev>
    <h1>Unconfirmed <small class="d-none d-sm-inline lead">{{ transactions.meta ? transactions.meta.total.toLocaleString('en') : '' }} {{ transactions.meta && transactions.meta.total === 1 ? 'Transaction' : 'Transactions' }}</small></h1>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th colspan="5">Counterparty</th>
                            <th colspan="1">Bitcoin</th>
                        </tr>
                        <tr>
                            <th>Age</th>
                            <th>Type</th>
                            <th>Summary</th>
                            <th class="thin-col">Source</th>
                            <th class="thin-col">Destination</th>
                            <th>Tx Hash</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="transaction in transactions.data">
                            <td>{{ transaction.block_time_ago }}</td>
                            <td><span class="badge w-100" :class="$_mempool_badge(transaction)"><a :href="transaction.url" class="text-white">{{ transaction.type }}</a></span></td>
                            <td>{{ $_mempool_summary(transaction) }}</td>
                            <td class="thin-col"><a :href="'https://xcpfox.com/address/' + transaction.tx_data.source" :title="transaction.tx_data.source">{{ transaction.tx_data.source }}</a></td>
                            <td v-if="transaction.tx_data.destination" class="thin-col"><a :href="'https://xcpfox.com/address/' + transaction.tx_data.destination" :title="transaction.tx_data.destination">{{ transaction.tx_data.destination }}</a></td>
                            <td v-else class="thin-col"></td>
                            <td><a :href="transaction.url" :title="transaction.tx_hash">{{ transaction.tx_hash }}</a></td>
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
      this.$_mempool_update()
    },
    methods: {
      $_mempool_update() {
        var api = '/api/mempool?page=' + this.page + '&per_page=' + this.per_page
        var self = this
        $.get(api, function(data) {
          self.transactions = data
        });
      },
      $_mempool_badge(transaction) {
        switch(transaction.type) {
          case 'Send':
            return 'badge-primary'
            break;
          case 'Order':
            return 'badge-success'
            break;
          case 'Issuance':
            return 'badge-warning'
            break;
          case 'Cancel':
            return 'badge-danger'
            break;
          case 'Broadcast':
            return 'badge-dark'
            break;
          case 'Bet':
            return 'badge-dark'
            break;
          case 'Burn':
            return 'badge-danger'
            break;
          case 'Dividend':
            return 'badge-success'
            break;
          default:
            return 'badge-secondary'
        }
      },
      $_mempool_summary(transaction) {
        switch(transaction.type) {
          case 'Send':
            return transaction.tx_data.asset
            break;
          case 'Order':
            return transaction.tx_data.give_asset + ' / ' + transaction.tx_data.get_asset
            break;
          case 'Issuance':
            var action = transaction.tx_data.locked ? 'Lock' :  transaction.tx_data.transfer ? 'Transfer' : 'Issue'
            return action + ' ' + transaction.tx_data.asset
            break;
          case 'Cancel':
            return transaction.tx_data.offer_hash
            break;
          case 'Broadcast':
            return transaction.tx_data.text ? transaction.tx_data.text : ''
            break;
          case 'BTCPay':
            return transaction.tx_data.destination
            break;
          case 'Dividend':
            return transaction.tx_data.asset
            break;
          case 'Bet':
            return 'XCP'
            break;
          default:
            return ''
        }
      }
    }
  }
</script>