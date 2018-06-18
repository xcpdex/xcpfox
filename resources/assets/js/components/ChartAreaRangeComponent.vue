<template>
  <div>
    <vue-highcharts :highcharts="Highcharts" :options="options" ref="areaRangeCharts"></vue-highcharts>
  </div>
</template>

<script>
  import VueHighcharts from 'vue2-highcharts'
  import Exporting from 'highcharts/modules/exporting'
  import More from 'highcharts/highcharts-more'
  import Highcharts from 'highcharts'

  Exporting(Highcharts)
  More(Highcharts)

  export default{
    props: ['source', 'title', 'yaxis', 'group_by', 'combined'],
    components: {
      VueHighcharts
    },
    data() {
      return {
        Highcharts: Highcharts,
        options: {
          chart: {
            zoomType: 'x',
            panning: true,
            panKey: 'shift',
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
          xAxis: {
            type: this.group_by === 'date' ? 'datetime' : 'category'
          },
          yAxis: this.combined === 'true' ? {
            floor: 0,
            title: {
              text: this.yaxis
            }
          } : [{
            floor: 0,
            title: {
              text: this.yaxis + ' (Average)'
            }
          },{
            floor: 0,
            title: {
              text: this.yaxis + ' (Range)'
            },
            opposite: true
          }],
          tooltip: {
              crosshairs: true,
              shared: true
          },
          legend: {
            enabled: false
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
                },
                xAxis: {
                  labels: {
                    formatter: function () {
                      return ''
                    }
                  }
                },
                yAxis: this.combined === 'true' ? {
                  title: {
                    text: ''
                  }
                } : [{
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
      this.$_area_range_chart_update()
    },
    methods: {
      $_area_range_chart_update() {
        var api = this.source
        var self = this
        $.get(api, function(data) {
          let areaRangeCharts = self.$refs.areaRangeCharts
          areaRangeCharts.delegateMethod('showLoading', 'Loading...')
          setTimeout(() => {
            areaRangeCharts.addSeries({
              name: 'Average',
              yAxis: 0,
              zIndex: 1,
              marker: {
                fillColor: 'white',
                lineWidth: 2,
                lineColor: Highcharts.getOptions().colors[0]
              },
              data: self.$_area_range_chart_averages(data.data)
            })
            areaRangeCharts.addSeries({
              name: 'Range',
              yAxis: self.combined === 'true' ? 0 : 1,
              type: 'arearange',
              lineWidth: 0,
              linkedTo: ':previous',
              color: Highcharts.getOptions().colors[0],
              fillOpacity: 0.3,
              zIndex: 0,
              marker: {
                enabled: false
              },
              data: self.$_area_range_chart_ranges(data.data)
            })
            areaRangeCharts.hideLoading()
          }, 2000)
        })
      },
      $_area_range_chart_averages(data) {
        var averages = new Array()
        var i = 0
        for (i = 0; i < data.length; i++) {
          averages.push([data[i][0], data[i][1]])
        }
        return averages
      },
      $_area_range_chart_ranges(data) {
        var ranges = new Array()
        var i = 0
        for (i = 0; i < data.length; i++) {
          ranges.push([data[i][0], data[i][2], data[i][3]])
        }
        return ranges
      }
    }
  }
</script>