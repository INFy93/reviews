<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <button @click="update" class="btn btn-default mb-1" v-if="!is_refresh">Обновить {{id}}...</button>
                <span class="badge badge-primary" v-if="is_refersh">Обновляю...</span>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Наименование</th>
                            <th>URL сайта</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="url in urldata" :key="url.url">
                            <td>{{url.title}}</td>
                            <td>{{url.url}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                urldata: [],
                is_refresh: false,
                id: 0
            }
        },
        mounted() {
            this.update()
        },
        methods: {
            update: function() {
                this.is_refresh = true
                axios.get('/test/ajax').then((response) => {
                    console.log(response)
                    this.urldata = response.data
                    this.is_refresh = false
                    this.id++
                })
            }
        }
    }
</script>
