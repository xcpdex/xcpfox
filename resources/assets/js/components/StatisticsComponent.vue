<template>
<div class="card">
    <div class="card-header font-weight-bold">
        <i class="fa fa-bar-chart mt-1 float-right"></i>
        Statistics
    </div>
    <div class="card-body">
        <template v-for="stat in stats">
        <div v-if="stat.type !== 'rps' && stat.type !== 'rpsresolves'" class="row">
            <div class="col-6 col-sm-8 col-lg-9 mb-2">
                <b class="text-capitalize">{{ stat.type }}:</b>
            </div>
            <div class="col-6 col-sm-4 col-lg-3 mb-2 text-right">
                {{ stat.count.toLocaleString('en') }}
            </div>
        </div>
        </template>
        <p class="card-text text-center mt-3">
            <a href="https://xcpfox.com/charts">
                Click here for more charts and data &raquo;
            </a>
        </p>
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