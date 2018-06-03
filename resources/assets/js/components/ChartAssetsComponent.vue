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
            text: 'Counterparty Assets'
          },
          subtitle: {
            text: 'Source: XCPFOX.com'
          },
          xAxis: {
            type: this.group === 'date' ? 'datetime' : 'category'
          },
          yAxis: {
            title: {
              text: 'Registrations'
            },
          },
          credits: {
            enabled: false
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
                yAxis: {
                  labels: {
                    align: 'left',
                    x: 0,
                    y: -2
                  },
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
      this.$_chart_assets_update()
    },
    methods: {
      $_chart_assets_update() {
        var api = '/api/charts/total-assets?group_by=' + this.group
        var self = this
        $.get(api, function(data) {
          let lineCharts = self.$refs.lineCharts;
          lineCharts.delegateMethod('showLoading', 'Loading...');
          setTimeout(() => {
              lineCharts.addSeries({name: 'Assets', data: data.data});
              lineCharts.hideLoading();
          }, 2000)
        });
      }
    }
}
</script>