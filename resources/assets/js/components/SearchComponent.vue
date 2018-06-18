<template>
<div>
    <h1>
        Search
    </h1>
    <div class="mb-4">
        <form method="GET" action="https://xcpfox.com/search" class="form-inline">
            <input name="q" type="search" placeholder="Address / Asset / Tx Hash" aria-label="Search" class="form-control mr-sm-2" :value="q === '...' ? '' : q">
            <button type="submit" class="btn btn-outline-success my-2 my-sm-0">Search</button>
        </form>
    </div>
    <div v-if="q !== '...'">
        <div class="card my-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                         <thead class="card-header">
                            <tr>
                                <th>Type</th>
                                <th>Result</th>
                                <th>First Seen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="result in results.data">
                                <td class="text-uppercase">{{ result.type }}</td>
                                <td><a :href="result.url">{{ result.result }}</a></td>
                                <td>{{ result.time_ago }}</td>
                            </tr>
                            <tr v-if="results.data && results.data.length === 0">
                                <td colspan="3">No Results</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <p class="text-center text-muted">
            Search by Address, Asset, or Tx Hash.
        </p>
        <p class="text-center card-text">
            <a href="https://xcpfox.com/" class="btn btn-outline-success">
                <i class="fa fa-home"></i> Go Back Home
            </a>
        </p>
    </div>
</div>
</template>
 
<script>
  export default {
    props: ['q', 'page', 'per_page'],
    data() {
      return {
        results: {}
      }
    },
    mounted() {
      this.$_search_update()
    },
    methods: {
      $_search_update() {
        var api = '/api/search?q=' + this.q + '&page=' + this.page + '&per_page=' + this.per_page
        var self = this
        $.get(api, function(data) {
          self.results = data
        });
      }
    }
  }
</script>