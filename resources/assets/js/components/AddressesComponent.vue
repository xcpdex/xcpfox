<template>
<div>
    <next-prev :per_page="per_page" :links="addresses.links" :float="'float-right'"></next-prev>
    <h1>
        Addresses
        <small class="lead">{{ addresses.meta ? addresses.meta.total.toLocaleString('en') : '' }}</small>
    </h1>
    <div class="card my-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered mb-0">
                     <thead class="card-header">
                        <tr>
                            <th colspan="4">Counterparty</th>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <th>Type</th>
                            <th>Options</th>
                            <th>Burn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="address in addresses.data">
                            <td><a :href="address.url">{{ address.address }}</a></td>
                            <td>{{ address.type }}</td>
                            <td>{{ address.options }}</td>
                            <td>{{ address.burn ? 'Yes' : 'No' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <table-tools :per_page="per_page" :data="addresses"></table-tools>
</div>
</template>
 
<script>
  var VueTruncate = require('vue-truncate-filter')
  Vue.use(VueTruncate)

  export default {
    props: ['page', 'per_page'],
    data() {
      return {
        addresses: {}
      }
    },
    mounted() {
      this.$_addresses_update()
    },
    methods: {
      $_addresses_update() {
        var api = '/api/addresses?page=' + this.page + '&per_page=' + this.per_page
        var self = this
        $.get(api, function(data) {
          self.addresses = data
        });
      }
    }
  }
</script>