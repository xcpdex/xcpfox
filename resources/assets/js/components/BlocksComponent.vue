<template>
<div>
    <next-prev :per_page="per_page" :links="blocks.links" :float="'float-right'"></next-prev>
    <h1>
        Blocks
        <small class="lead">{{ blocks.meta ? blocks.meta.total.toLocaleString('en') : '' }}</small>
    </h1>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th colspan="4">Counterparty</th>
                            <th colspan="6">Bitcoin</th>
                        </tr>
                        <tr>
                            <th>Age</th>
                            <th>Messages</th>
                            <th>Transactions</th>
                            <th>XCP</th>
                            <th>Height</th>
                            <th>Timestamp</th>
                            <th>Transactions</th>
                            <th>Size (kB)</th>
                            <th>Weight (kWU)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="block in blocks.data">
                            <td>{{ block.block_time_ago }}</td>
                            <td class="text-right"><a :href="block.url">{{ block.messages_count }}</a></td>
                            <td class="text-right"><a :href="block.url">{{ block.transactions_count }}</a></td>
                            <td :class="block.messages_count > 0 ? 'text-success' : 'text-danger'"><i class="fa" :class="block.messages_count > 0 ? 'fa-check-circle' : 'fa-times-circle'"></i> {{ block.messages_count > 0 ? 'Yes' : 'No' }}</td>
                            <td><a :href="block.url">{{ block.block_height }}</a></td>
                            <td>{{ block.block_time }}</td>
                            <td class="text-right">{{ block.tx_count }}</td>
                            <td class="text-right">{{ block.size }}</td>
                            <td class="text-right">{{ block.weight }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <table-tools :per_page="per_page" :data="blocks"></table-tools>
</div>
</template>
 
<script>
  export default {
    props: ['page', 'per_page'],
    data() {
      return {
        blocks: {}
      }
    },
    mounted() {
      this.$_blocks_update()
    },
    methods: {
      $_blocks_update() {
        var api = '/api/blocks?page=' + this.page + '&per_page=' + this.per_page
        var self = this
        $.get(api, function(data) {
          self.blocks = data
        });
      }
    }
  }
</script>