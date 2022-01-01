<template>
    <div>
        <server-datasource
            :source="items"
            :total="total_of_items"
            :columns="columns"
            :actions="actions">
        </server-datasource>
    </div>
</template>
<script>
import { ServerDatasource } from 'vue-datasource'
export default {
    components: {
         ServerDatasource
    },
    props:{
        items: [...],
        total: 100,
        columns: [...],
        actions: [...]
    },
    data() {
        return {
            items: [...],
            total: 100,
            columns: [...],
            actions: [...]
        }
    }
}
</script>
