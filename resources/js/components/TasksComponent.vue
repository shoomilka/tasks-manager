<template>
    <div class="">

        <h2>Tasks</h2>

        <div class="card card-body" v-for="task in tasks" v-bind:key="task.id">
            <h3>{{ task.title }}</h3>
            <p>{{ task.description }}</p>
        </div>

        <div aria-label="" class="text-xs-center">
            <ul class="pagination" style="padding-left: 45%;">
                <li v-if=pagination.prev_page_url><a class="page-link" href="#" @click="fetchTasks(pagination.prev_page_url)">&laquo;</a></li>
                <li class="page-item"><a class="page-link disabled" href="#">{{ pagination.current_page }}</a></li>
                <li v-if=pagination.next_page_url><a class="page-link" href="#" @click="fetchTasks(pagination.next_page_url)">&raquo;</a></li>
            </ul>
        </div>
    </div>
    
</template>

<script>
    export default{
        data(){
            return {
                tasks: [],
                task:{
                    id: '',
                    title: '',
                    description: ''
                },
                task_id: '',
                pagination: {},
                edit: false
            }
        },
        created(){
            this.fetchTasks();
        },
        methods:{
            fetchTasks(page_url){
                page_url = page_url || '/api/tasks'
                let vm = this;
                fetch(page_url)
                    .then(responce => responce.json())
                    .then(responce => {
                        this.tasks = responce.data;
                        let pagination = {
                            current_page: responce.current_page,
                            last_page: responce.last_page,
                            next_page_url: responce.next_page_url,
                            prev_page_url: responce.prev_page_url,
                        };
                        this.pagination = pagination;
                    })
                    .catch(error => console.log(error))
            },
        }
    }
</script>