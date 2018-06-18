<template>
  <div>
    <vue-highcharts :highcharts="Highcharts" :options="options" ref="lineCharts"></vue-highcharts>
  </div>
</template>

<script>
  import VueHighcharts from 'vue2-highcharts'
  import Boost from 'highcharts/modules/boost'
  import Exporting from 'highcharts/modules/exporting'
  import Highcharts from 'highcharts'

  Boost(Highcharts)
  Exporting(Highcharts)

  export default{
    props: ['source', 'title', 'yaxis', 'group_by', 'type'],
    components: {
        VueHighcharts
    },
    data(){
      return{
        Highcharts: Highcharts,
        options: {
          chart: {
            type: this.type,
            zoomType: 'x',
            panning: true,
            panKey: 'shift',
            borderWidth: 1,
            borderRadius: 4,
            borderColor: 'rgba(0, 0, 0, 0.125)',
            height: (9 / 16 * 100) + '%', // 16:9 ratio
          },
          boost: {
            useGPUTranslations: true
          },
          title: {
            text: this.title
          },
          subtitle: {
            text: 'Source: XCPFOX.com'
          },
          xAxis: {
            type: this.group_by === 'date' ? 'datetime' : 'category'
          },
          yAxis: {
            title: {
              text: this.yaxis
            },
          },
          tooltip: {
            shared: true
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
                  height: 300,
                },
                xAxis: {
                  labels: {
                    formatter: function () {
                      return '';
                    }
                  }
                },
                yAxis: {
                  title: {
                    text: ''
                  }
                }
              }
            }]
          },
          series: []
        }
      }
    },
    mounted() {
      this.$_chart_supply_update()
    },
    methods: {
      $_chart_supply_update() {
        var api = this.source
        var self = this
        $.get(api, function(data) {
          let lineCharts = self.$refs.lineCharts;
          lineCharts.delegateMethod('showLoading', 'Loading...');
          setTimeout(() => {
            lineCharts.addSeries({name: 'Total Supply', data: self.$_chart_supply_accumulate(data.data)})
            lineCharts.hideLoading()
          }, 2000)
        });
      },
      $_chart_supply_accumulate(data) {
        var accumulation = new Array()
        var runningTotal = 2649791.07838225
        var i = 0
        for (i = 0; i < data.length; i++) {
          runningTotal -= data[i][1]
          accumulation.push([data[i][0], runningTotal])
        }
        return accumulation
      }
    }
}
</script>