<template>
<div>
    <next-prev :per_page="per_page" :links="transactions.links" :float="'float-right'"></next-prev>
    <h1 class="text-capitalize">{{ type ? type : 'Transactions' }} <small class="d-none d-sm-inline lead">{{ transactions.meta ? transactions.meta.total.toLocaleString('en') : '' }}</small></h1>
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
                            <th>Type</th>
                            <th>Summary</th>
                            <th>Tx Index</th>
                            <th class="thin-col">Source</th>
                            <th>Valid</th>
                            <th>Height</th>
                            <th class="thin-col">Tx Hash</th>
                            <th>Fee</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="transaction in transactions.data">
                            <td>{{ transaction.block_time_ago }}</td>
                            <td><span class="badge w-100" :class="$_transaction_badge(transaction)"><a :href="transaction.url" class="text-white">{{ transaction.type }}</a></span></td>
                            <td v-if=" ! transaction.valid"><em class="text-muted">Invalid: View transaction for error.</em></td>
                            <td v-else>{{ $_transaction_summary(transaction) }}</td>
                            <td><a :href="transaction.url">{{ transaction.tx_index }}</a></td>
                            <td class="thin-col"><a :href="transaction.source_url" :title="transaction.source">{{ transaction.source }}</a></td>
                            <td v-if="transaction.valid" class="text-success"><i class="fa fa-check-circle"></i> Yes</td>
                            <td v-else class="text-danger"><i class="fa fa-times-circle"></i> No</td>
                            <td><a :href="transaction.block_url">{{ transaction.block_index }}</a></td>
                            <td class="thin-col"><a :href="transaction.url" :title="transaction.tx_hash">{{ transaction.tx_hash }}</a></td>
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
  export default {
    props: ['type', 'page', 'per_page'],
    data () {
      return {
        transactions: {}
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
        })
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
            return transaction.related.asset_model.display_name
            break;
          case 'Order':
            return transaction.related.get_asset_model.display_name + ' / ' + transaction.related.give_asset_model.display_name
            break;
          case 'Issuance':
            var action = transaction.related.locked ? 'Lock' :  transaction.related.transfer ? 'Transfer' : 'Issue'
            return action + ' ' + transaction.related.display_name
            break;
          case 'Cancel':
            return transaction.related.offer_hash
            break;
          case 'Broadcast':
            return transaction.related.text ? transaction.related.text : ''
            break;
          case 'Burn':
            return 'Burn ' + transaction.related.burned_normalized + ' BTC / Earn ' + transaction.related.earned_normalized + ' XCP'
            break;
          case 'BTCPay':
            return transaction.related.destination
            break;
          case 'Dividend':
            return transaction.related.asset
            break;
          case 'Bet':
            return transaction.related.display_type
            break;
          case 'RPS':
            return 'Possible Moves: ' + transaction.related.possible_moves
            break;
          case 'RPS Resolve':
            return 'Move ' + transaction.related.move
            break;
          default:
            return ''
        }
      }
    }
  }
</script>