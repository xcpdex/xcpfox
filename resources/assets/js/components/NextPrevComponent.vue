<template>
    <ul class="pagination mt-1" :class="float">
        <li v-if="links && links.prev" class="page-item"><a :href="links.prev.replace('/api', '') + '&per_page=' + per_page" rel="prev" class="page-link">&laquo;</a></li>
        <li v-else class="page-item disabled"><span class="page-link">&laquo;</span></li>
        <li v-if="links && links.next" class="page-item"><a :href="links.next.replace('/api', '') + '&per_page=' + per_page" rel="next" class="page-link">&raquo;</a></li>
        <li v-else class="page-item disabled"><span class="page-link">&raquo;</span></li>
    </ul>
</template>
 
<script>
  export default {
    props: ['per_page', 'links', 'float']
  }
</script>