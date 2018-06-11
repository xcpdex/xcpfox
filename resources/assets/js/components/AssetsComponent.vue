<template>
<div>
    <next-prev :per_page="per_page" :links="assets.links" :float="'float-right'"></next-prev>
    <h1 class="text-capitalize">
        {{ type ? type + 's' : 'Assets' }}
        <small class="lead">{{ assets.meta ? assets.meta.total.toLocaleString('en') : '' }}</small>
    </h1>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th colspan="8">Counterparty</th>
                        </tr>
                        <tr>
                            <th>Age</th>
                            <th>Type</th>
                            <th>Asset</th>
                            <th>Description</th>
                            <th>Issuance</th>
                            <th>Locked</th>
                            <th>Owner</th>
                            <th>Holders</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="asset in assets.data">
                            <td>{{ asset.block_time_ago }}</td>
                            <td><span class="badge w-100" :class="$_asset_badge(asset)"><a :href="type ? asset.url : 'https://xcpfox.com/assets/' + asset.type" class="text-white text-capitalize">{{ asset.type }}</a></span></td>
                            <td><a :href="asset.url">{{ asset.display_name }}</a></td>
                            <td :title="asset.description">{{ asset.description | truncate(30) }}</td>
                            <td class="text-right">{{ asset.issuance_normalized }}</td>
                            <td :class="asset.locked ? 'text-success' : 'text-danger'"><i class="fa" :class="asset.locked ? 'fa-check-circle' : 'fa-times-circle'"></i> {{ asset.locked ? 'Yes' : 'No' }}</td>
                            <td><a :href="asset.owner_url">{{ asset.owner | truncate(10) }}</a></td>
                            <td class="text-right">{{ asset.holders }}</td>
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
    props: ['type', 'page', 'per_page'],
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
        if(this.type) {
          var api = '/api/assets/'+ this.type  +'?page=' + this.page + '&per_page=' + this.per_page
        } else {
          var api = '/api/assets?page=' + this.page + '&per_page=' + this.per_page
        }
        var self = this
        $.get(api, function(data) {
          self.assets = data
        });
      },
      $_asset_badge(asset) {
        switch(asset.type) {
          case 'asset':
            return 'badge-success'
            break;
          case 'subasset':
            return 'badge-primary'
            break;
          case 'numeric':
            return 'badge-warning'
            break;
          default:
            return 'badge-secondary'
        }
      }
    }
  }
</script>