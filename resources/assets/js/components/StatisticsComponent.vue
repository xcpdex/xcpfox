<template>
<div class="card">
    <div class="card-header font-weight-bold">
        <i class="fa fa-bar-chart mt-1 float-right"></i>
        Statistics
    </div>
    <div class="card-body">
        <div v-for="stat in stats" class="row">
            <div class="col-5 col-md-6 mb-2">
                <b class="text-capitalize">{{ stat.type }}:</b>
            </div>
            <div class="col-7 col-md-6 mb-2">
                {{ stat.count.toLocaleString('en') }}
            </div>
        </div>
    </div>
</div>
</template>
 
<script>
  export default {
    data() {
      return {
        stats: {}
      }
    },
    mounted() {
      this.$_stats_update()
    },
    methods: {
      $_stats_update() {
        var api = '/api/statistics'
        var self = this
        $.get(api, function(data) {
          self.stats = data
        });
      }
    }
  }
</script>