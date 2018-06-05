<template>
  <div>
    <vue-highcharts :options="options" ref="lineCharts"></vue-highcharts>
  </div>
</template>

<script>
  import VueHighcharts from 'vue2-highcharts'

  export default{
    props: ['chart', 'group', 'type'],
    components: {
        VueHighcharts
    },
    data(){
      return{
        options: {
          chart: {
            type: this.type,
            borderWidth: 1,
            borderRadius: 4,
            borderColor: 'rgba(0, 0, 0, 0.125)',
            height: (9 / 16 * 100) + '%', // 16:9 ratio
          },
          title: {
            text: 'Counterparty Transactions'
          },
          subtitle: {
            text: 'Source: XCPFOX.com'
          },
          xAxis: {
            type: this.group === 'date' ? 'datetime' : 'category'
          },
          yAxis: [{
            title: {
              text: 'TX Count'
            },
          },{
            title: {
              text: 'Cumulative'
            },
            opposite: true
          }],
          tooltip: {
            shared: true
          },
          credits: {
            enabled: false
          },
          plotOptions: {
            line: {
              animation: false
            }
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
                yAxis: [{
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
      this.$_chart_transactions_update()
    },
    methods: {
      $_chart_transactions_update() {
        var api = '/api/charts/total-transactions?group_by=' + this.group
        var self = this
        $.get(api, function(data) {
          let lineCharts = self.$refs.lineCharts;
          lineCharts.delegateMethod('showLoading', 'Loading...');
          setTimeout(() => {
              lineCharts.addSeries({name: 'Transactions', yAxis: 0, zIndex: 2, data: data.data})
              lineCharts.addSeries({name: 'Cumulative', yAxis: 1, zIndex: 1, color: 'rgba(0, 0, 0, 0.20)', data: self.$_chart_transactions_accumulate(data.data)})
              lineCharts.hideLoading()
          }, 2000)
        });
      },
      $_chart_transactions_accumulate(data) {
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