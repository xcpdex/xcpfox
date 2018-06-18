<template>
<div style="white-space: nowrap;">
    <div class="row mb-2">
        <div class="col-3 col-md-4 col-lg-3 font-weight-bold">
            <i class="fa fa-calendar mt-1"></i>
        </div>
        <div class="col-3 col-md-4 col-lg-3 font-weight-bold">
            Price
        </div>
        <div class="col-3 col-md-0 col-lg-3 font-weight-bold text-right d-inline d-md-none d-lg-inline">
            M.&nbsp;Cap
        </div>
        <div class="col-3 col-md-4 col-lg-3 font-weight-bold text-right">
            Volume
        </div>
    </div>
    <div v-for="(price, i) in prices" v-if="prices[i + 1] && prices[i][0] - prices[i + 1][0] > 60000000" class="row mb-2">
        <div class="col-3 col-md-4 col-lg-3">
            {{ prices[i][0] | moment("MMM DD") }}
        </div>
        <div class="col-3 col-md-4 col-lg-3" :title="'$' + prices[i][1]">
            {{ $_market_history_price(prices[i][1]) }}
        </div>
        <div class="col-3 col-md-0 col-lg-3 text-right d-inline d-md-none d-lg-inline" :title="'$' + market_caps[i][1].toLocaleString('en')">
            {{ $_market_history_market_cap(market_caps[i][1]) }}
        </div>
        <div class="col-3 col-md-4 col-lg-3 text-right" :title="'$' + volumes[i][1].toLocaleString('en')">
            {{ $_market_history_volume(volumes[i][1]) }}
        </div>
    </div>
    <p class="card-text text-center text-muted mt-3">
        Data Source: <a :href="source.replace('/history', '')" target="_blank">CoinCap.io</a>
    </p>
</div>
</template>
 
<script>
  export default {
    props: ['source'],
    data() {
      return {
        prices: {},
        market_caps: {},
        volumes: {},
      }
    },
    mounted() {
      this.$_market_history_update()
    },
    methods: {
      $_market_history_update() {
        var api = this.source
        var self = this
        $.get(api, function(data) {
          self.prices = data.price.reverse().slice(0, 11)
          self.market_caps = data.market_cap.reverse().slice(0, 11)
          self.volumes = data.volume.reverse().slice(0, 11)
        })
      },
      $_market_history_price(number) {
        if (number > 999) {
            return '$' + number.toLocaleString('en', {maximumFractionDigits: 0})
        } else {
            return number.toLocaleString('en', {style: 'currency', 'currency': 'USD'})
        }
      },
      $_market_history_volume(number) {
        if (number > 999999999) {
            return '$' + (number / 1000000000).toFixed(1) + 'B'
        } else if (number > 999999 && number < 1000000000) {
            return '$' + (number / 1000000).toFixed(1) + 'M'
        } else if (number > 999 && number < 1000000) {
            return '$' + (number / 1000).toFixed(1) + 'K'
        } else {
            return '$' + number.toLocaleString('en', {maximumSignificantDigits: 6, maximumFractionDigits: 0})
        }
      },
      $_market_history_market_cap(number) {
        if (number > 999999999) {
            return '$' + (number / 1000000000).toFixed(1) + 'B'
        } else if (number > 999999 && number < 1000000000) {
            return '$' + (number / 1000000).toFixed(1) + 'M'
        } else {
            return '$' + number.toLocaleString('en', {maximumSignificantDigits: 6, maximumFractionDigits: 0})
        }
      }
    }
  }
</script>