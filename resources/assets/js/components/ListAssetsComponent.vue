<template>
<div style="white-space: nowrap;">
    <div v-for="(asset, i) in assets" class="row" :class="i === assets.length - 1 ? 'mb-0' : 'mb-2' ">
        <div class="col-6" style="overflow: hidden; text-overflow: ellipsis;"><a :href="'https://xcpfox.com/asset/' + asset[0]">{{ asset[0] }}</a></div>
        <div class="col-3 text-right" :title="asset.percent">{{ asset[1].toFixed(0) }}%</div>
        <div class="col-3 text-right">{{ asset[2].toLocaleString('en') }}</div>
    </div>
</div>
</template>
 
<script>
  export default {
    props: ['source'],
    data() {
      return {
        assets: {},
      }
    },
    mounted() {
      this.$_list_assets_update()
    },
    methods: {
      $_list_assets_update() {
        var api = this.source
        var self = this
        $.get(api, function(data) {
          self.assets = data.data
        })
      }
    }
  }
</script>