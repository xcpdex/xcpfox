<template>
<div style="white-space: nowrap;">
    <div class="row mb-2">
        <div class="col-6 font-weight-bold">
            {{ title }}
        </div>
        <div class="col-6 font-weight-bold text-right">
            {{ ranking }}
        </div>
    </div>
    <div v-for="(address, i) in addresses" class="row mb-2">
        <div class="col-6" style="overflow: hidden; text-overflow: ellipsis;">
            <a :href="'https://xcpfox.com/address/' + address[0]">{{ address[0] }}</a>
        </div>
        <div class="col-6 text-right">
            {{ address[1].toLocaleString('en') }}
        </div>
    </div>
    <p class="card-text text-center text-muted mt-4">
        More Content Link Here
    </p>
</div>
</template>
 
<script>
  export default {
    props: ['source', 'title', 'ranking'],
    data() {
      return {
        addresses: {},
      }
    },
    mounted() {
      this.$_list_addresses_update()
    },
    methods: {
      $_list_addresses_update() {
        var api = this.source
        var self = this
        $.get(api, function(data) {
          self.addresses = data.data
        })
      }
    }
  }
</script>