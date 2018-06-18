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
    props: ['source', 'title'],
    components: {
        VueHighcharts
    },
    data(){
      return{
        Highcharts: Highcharts,
        options: {
          chart: {
            alignTicks: true,
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
            text: 'Source: CoinCap.io'
          },
          xAxis: {
            type: 'datetime'
          },
          yAxis: [{
            title: {
              text: 'Price (USD)'
            },
            labels: {
              formatter: function () {
                return '$' + this.value
              }
            },
            height: '75%',
            opposite: true,
          },{
            title: {
              text: 'Market Cap'
            },
            height: '75%',
          },{
            title: {
              text: 'Volume'
            },
            top: '80%',
            height: '20%',
            offset: 0,
          }],
          navigator: {
            enabled: true
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
                yAxis: [{
                  title: {
                    text: ''
                  }
                },{
                  title: {
                    text: ''
                  }
                },{
                  title: {
                    text: ''
                  }
                }]
              }
            }]
          },
          series: []
        }
      }
    },
    mounted() {
      this.$_chart_market_update()
    },
    methods: {
      $_chart_market_update() {
        var api = this.source
        var self = this
        $.get(api, function(data) {
          let lineCharts = self.$refs.lineCharts;
          lineCharts.delegateMethod('showLoading', 'Loading...')
          setTimeout(() => {
            lineCharts.addSeries({type: 'line', name: 'Price (USD)', yAxis: 0, zIndex: 1, color: '#009e73', data: data.price})
            lineCharts.addSeries({type: 'line', name: 'Market Cap', yAxis: 1, zIndex: 0, color: '#7cb5ec', data: data.market_cap})
            lineCharts.addSeries({type: 'column', name: 'Volume', yAxis: 2, color: '#777777', data: data.volume})
            lineCharts.hideLoading()
          }, 2000)
        });
      },
    }
}
</script>