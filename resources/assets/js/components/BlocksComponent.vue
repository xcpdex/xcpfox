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
                            <th colspan="5">Bitcoin</th>
                            <th colspan="2">Counterparty</th>
                        </tr>
                        <tr>
                            <th>Height</th>
                            <th>Age</th>
                            <th>Transactions</th>
                            <th>Size (kB)</th>
                            <th>Weight (kWU)</th>
                            <th>Messages</th>
                            <th>Transactions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="block in blocks.data">
                            <td><a :href="block.url">{{ block.block_height }}</a></td>
                            <td>{{ block.block_time_ago }}</td>
                            <td>{{ block.tx_count }}</td>
                            <td>{{ block.size }}</td>
                            <td>{{ block.weight }}</td>
                            <td><a :href="block.url">{{ block.messages_count }}</a></td>
                            <td><a :href="block.url">{{ block.transactions_count }}</a></td>
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