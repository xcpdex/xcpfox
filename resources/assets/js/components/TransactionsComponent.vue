<template>
<div>
    <next-prev :per_page="per_page" :links="transactions.links" :float="'float-right'"></next-prev>
    <h1 class="text-capitalize">
        {{ type ? type : 'Transactions' }}
        <small class="d-none d-sm-inline lead">{{ transactions.meta ? transactions.meta.total.toLocaleString('en') : '' }}</small>
    </h1>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th colspan="6">Counterparty</th>
                            <th colspan="3">Bitcoin</th>
                        </tr>
                        <tr>
                            <th>Age</th>
                            <th>Action</th>
                            <th>Summary</th>
                            <th>Tx Index</th>
                            <th>Source</th>
                            <th>Valid</th>
                            <th>Height</th>
                            <th>Tx Hash</th>
                            <th>Fee</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="transaction in transactions.data">
                            <td>{{ transaction.block_time_ago }}</td>
                            <td><span class="badge w-100" :class="$_transaction_badge(transaction)"><a :href="transaction.url" class="text-white">{{ transaction.type }}</a></span></td>
                            <td v-if=" ! transaction.valid"><em class="text-muted">Invalid: View transaction for error.</em></td>
                            <td v-else-if="transaction.type === 'Broadcast' || transaction.type === 'Cancel'">{{ $_transaction_summary(transaction) | truncate(30) }}</td>
                            <td v-else>{{ $_transaction_summary(transaction) }}</td>
                            <td><a :href="transaction.url">{{ transaction.tx_index }}</a></td>
                            <td><a :href="transaction.source_url">{{ transaction.source | truncate(10) }}</a></td>
                            <td :class="transaction.valid ? 'text-success' : 'text-danger'"><i class="fa" :class="transaction.valid ? 'fa-check-circle' : 'fa-times-circle'"></i> {{ transaction.valid ? 'Yes' : 'No' }}</td>
                            <td><a :href="transaction.block_url">{{ transaction.block_index }}</a></td>
                            <td><a :href="transaction.url">{{ transaction.tx_hash | truncate(10) }}</a></td>
                            <td class="text-right" :title="transaction.fee_rate + ' sats/byte'">{{ transaction.fee_usd }}</td>
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
    props: ['type', 'page', 'per_page'],
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
        if(this.type) {
          var api = '/api/transactions/'+ this.type  +'?page=' + this.page + '&per_page=' + this.per_page
        } else {
          var api = '/api/transactions?page=' + this.page + '&per_page=' + this.per_page
        }
        var self = this
        $.get(api, function(data) {
          self.transactions = data
        });
      },
      $_transaction_badge(transaction) {
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
      $_transaction_summary(transaction) {
        switch(transaction.type) {
          case 'Send':
            return transaction.related.quantity_normalized + ' ' + transaction.related.asset_model.display_name
            break;
          case 'Order':
            return transaction.related.get_quantity_normalized + ' ' + transaction.related.get_asset_model.display_name + ' for ' + transaction.related.give_asset_model.display_name
            break;
          case 'Issuance':
            var action = transaction.related.locked ? 'Lock' :  transaction.related.transfer ? 'Transfer' : transaction.related.quantity_normalized
            return action + ' ' + transaction.related.display_name
            break;
          case 'Cancel':
            return transaction.related.offer_hash
            break;
          case 'Broadcast':
            return transaction.related.text
            break;
          case 'Burn':
            return 'Burn ' + transaction.related.burned_normalized + ' BTC / Earn ' + transaction.related.earned_normalized + ' XCP'
            break;
          case 'BTCPay':
            return transaction.related.btc_amount_normalized + ' BTC to ' + transaction.related.destination
            break;
          case 'Dividend':
            return transaction.related.quantity_per_unit_normalized + ' ' + transaction.related.dividend_asset + ' on ' + transaction.related.asset
            break;
          case 'Bet':
            return transaction.related.wager_quantity_normalized + ' XCP (' + transaction.related.display_type + ')'
            break;
          case 'RPS':
            return transaction.related.wager_normalized + ' XCP (Possible Moves: ' + transaction.related.possible_moves + ')'
            break;
          case 'RPS Resolve':
            return 'Move ' + transaction.related.move + ' (' + transaction.related.random + ')'
            break;
          default:
            return ''
        }
      }
    }
  }
</script>