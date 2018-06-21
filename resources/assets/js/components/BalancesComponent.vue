<template>
<div>
    <h1>Balances <small class="lead">{{ balances.data ? balances.data.length.toLocaleString('en') : '' }}</small></h1>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th>Asset</th>
                            <th>Balance</th>
                            <th>% Supply</th>
                            <th>Credits</th>
                            <th>Debits</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="balance in balances.data">
                            <td><a :href="balance.asset_url">{{ balance.asset }}</a></td>
                            <td class="text-right">{{ balance.quantity }}</td>
                            <td class="text-right">{{ balance.percent }}%</td>
                            <td class="text-right">{{ balance.credits_count }}</td>
                            <td class="text-right">{{ balance.debits_count }}</td>
                        </tr>
                        <tr v-if="balances.data && balances.data.length == 0">
                            <td colspan="5" class="text-center"><em>No current balances</em></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</template>
 
<script>
  export default {
    props: ['source'],
    data() {
      return {
        balances: {}
      }
    },
    mounted() {
      this.$_balances_update()
    },
    methods: {
      $_balances_update() {
        var api = this.source
        var self = this
        $.get(api, function(data) {
          self.balances = data
        });
      }
    }
  }
</script>