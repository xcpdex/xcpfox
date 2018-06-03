<template>
    <div class="row">
        <div class="col-4">
            <form class="form-inline">
                <select v-model="selected" v-on:change="goToUrl" class="form-control">
                    <option v-for="option in options" v-bind:value="option.value" :selected="selected == option.value">
                        {{ option.value }}
                    </option>
                </select>
            </form>
        </div>
        <div class="col-4">
            <p class="lead text-center text-muted mt-1">Page {{ data && data.meta ? data.meta.current_page : '' }}</p>
        </div>
        <div class="col-4">
            <next-prev :per_page="per_page" :links="data.links" :float="'float-right'"></next-prev>
        </div>
    </div>
</template>
 
<script>
  export default {
    props: ['per_page', 'data'],
    data() {
      return {
        selected: this.per_page,
        options: [
          { value: 10 },
          { value: 25 },
          { value: 50 },
          { value: 100 }
        ]
      }
    },
    methods: {
      goToUrl() {
        window.location.href = this.data.meta.path.replace('/api', '') + '?page=1&per_page=' + this.selected
      }
    }
  }
</script>