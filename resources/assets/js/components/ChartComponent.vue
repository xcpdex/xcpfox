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
    props: ['source', 'title', 'yaxis', 'group_by', 'type', 'cumulative'],
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
          yAxis: this.cumulative === 'true' ? [{
            title: {
              text: this.yaxis
            },
          },{
            title: {
              text: 'Cumulative'
            },
            opposite: true
          }] : {
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
                xAxis: {
                  labels: {
                    formatter: function () {
                      return '';
                    }
                  }
                },
                yAxis: this.cumulative === 'true' ? [{
                  title: {
                    text: ''
                  }
                },{
                  title: {
                    text: ''
                  }
                }] : {
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
      this.$_chart_update()
    },
    methods: {
      $_chart_update() {
        var api = this.source
        var self = this
        $.get(api, function(data) {
          let lineCharts = self.$refs.lineCharts;
          lineCharts.delegateMethod('showLoading', 'Loading...');
          setTimeout(() => {
            if(self.cumulative === 'true'){
              lineCharts.addSeries({name: 'Total', yAxis: 0, zIndex: 2, data: data.data})
              lineCharts.addSeries({name: 'Cumulative', yAxis: 1, zIndex: 1, color: 'rgba(0, 0, 0, 0.20)', data: self.$_chart_accumulate(data.data)})
            }else{
              lineCharts.addSeries({name: self.yaxis, data: data.data})
            }
            lineCharts.hideLoading()
          }, 2000)
        });
      },
      $_chart_accumulate(data) {
        var accumulation = new Array()
        var runningTotal = 0
        var i = 0
        for (i = 0; i < data.length; i++) {
          runningTotal += data[i][1]
          accumulation.push([data[i][0], runningTotal])
        }
        return accumulation
      }
    }
}
</script>