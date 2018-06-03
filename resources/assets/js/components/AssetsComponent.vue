<template>
<div>
    <next-prev :per_page="per_page" :links="assets.links" :float="'float-right'"></next-prev>
    <h1>
        Assets
        <small class="lead">{{ assets.meta ? assets.meta.total.toLocaleString('en') : '' }}</small>
    </h1>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th colspan="2">Bitcoin</th>
                            <th colspan="5">Counterparty</th>
                        </tr>
                        <tr>
                            <th>Height</th>
                            <th>Age</th>
                            <th>Asset</th>
                            <th>Description</th>
                            <th>Issuance</th>
                            <th>Divisible</th>
                            <th>Locked</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="asset in assets.data">
                            <td><a :href="asset.block_url">{{ asset.block_height }}</a></td>
                            <td>{{ asset.block_time_ago }}</td>
                            <td><a :href="asset.url">{{ asset.display_name }}</a></td>
                            <td :title="asset.description">{{ asset.description | truncate(40) }}</td>
                            <td class="text-right">{{ asset.issuance_normalized }}</td>
                            <td>{{ asset.divisible ? 'Yes' : 'No' }}</td>
                            <td>{{ asset.locked ? 'Yes' : 'No' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <table-tools :per_page="per_page" :data="assets"></table-tools>
</div>
</template>
 
<script>
  var VueTruncate = require('vue-truncate-filter')
  Vue.use(VueTruncate)

  export default {
    props: ['page', 'per_page'],
    data() {
      return {
        assets: {}
      }
    },
    mounted() {
      this.$_assets_update()
    },
    methods: {
      $_assets_update() {
        var api = '/api/assets?page=' + this.page + '&per_page=' + this.per_page
        var self = this
        $.get(api, function(data) {
          self.assets = data
        });
      }
    }
  }
</script>