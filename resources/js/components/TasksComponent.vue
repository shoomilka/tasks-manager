<template>
    <div class="">

        <h2>Tasks</h2>

        <div class="card card-body" v-for="task in tasks" v-bind:key="task.id">
            <h3>{{ task.title }}</h3>
            <p>{{ task.description }}</p>
            <hr>
            <button @click="deleteTask(task.id)" class="btn btn-danger">Delete</button>
        </div>

        <div aria-label="" class="text-xs-center">
            <ul class="pagination justify-content-center">
                <li v-if=pagination.prev_page_url><a class="page-link" href="#" @click="fetchTasks(pagination.prev_page_url)">&laquo;</a></li>
                <li class="page-item disabled"><a class="page-link" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page}}</a></li>
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
            deleteTask(task_id){
                if(confirm("Are You Sure?")){
                    fetch('/api/tasks/' + task_id, {
                        method: 'delete'
                    })
                    .then(responce => responce.json())
                    .then(responce => {
                        this.fetchTasks();
                        alert('Task removed!');
                    })
                    .catch(error => console.log(error));
                }
            }
        }
    }
</script>