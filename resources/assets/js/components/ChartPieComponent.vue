<template>
  <div>
    <vue-highcharts :highcharts="Highcharts" :options="options" ref="pieChart"></vue-highcharts>
  </div>
</template>

<script>
  import VueHighcharts from 'vue2-highcharts'
  import Exporting from 'highcharts/modules/exporting'
  import Highcharts from 'highcharts'

  Exporting(Highcharts)

  export default{
    props: ['source', 'title'],
    components: {
        VueHighcharts
    },
    data() {
      return {
        Highcharts: Highcharts,
        options: {
          chart: {
            type: 'pie',
            borderWidth: 1,
            borderRadius: 4,
            borderColor: 'rgba(0, 0, 0, 0.125)',
            height: (9 / 16 * 100) + '%' // 16:9 ratio
          },
          title: {
            text: this.title
          },
          subtitle: {
            text: 'Source: XCPFOX.com'
          },
          credits: {
            enabled: false
          },
          exporting: {
            width: 800
          },
          responsive: {
            rules: [{
              condition: {
                maxWidth: 500
              },
              chartOptions: {
                chart: {
                  height: 300
                }
              }
            }]
          },
          series: []
        }
      }
    },
    mounted() {
      this.$_pie_chart_update()
    },
    methods: {
      $_pie_chart_update() {
        var api = this.source
        var self = this
        $.get(api, function(data) {
          let pieChart = self.$refs.pieChart
          pieChart.delegateMethod('showLoading', 'Loading...')
          setTimeout(() => {
              pieChart.addSeries({name: self.title, data: data.data})
              pieChart.hideLoading()
          }, 2000)
        })
      }
    }
  }
</script>