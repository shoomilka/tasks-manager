<template>
    <div class="">

        <h2>Tasks</h2>

        <form @submit.prevent="addTask" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Title of Task" v-model="task.title">
            </div>
            <div class="form-group">
                <textarea class="form-control" placeholder="Description of Task" v-model="task.description"></textarea>
            </div>
            <button type="submit" class="btn btn-light btn-block">Save Task</button>
        </form>

        <div class="card card-body" v-for="task in tasks" v-bind:key="task.id">
            <h3>{{ task.title }}</h3>
            <p>{{ task.description }}</p>
            <hr>
            <button @click="editTask(task)" class="btn btn-warning mb-2">Edit</button>
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
                    .then(response => response.json())
                    .then(response => {
                        this.tasks = response.data;
                        let pagination = {
                            current_page: response.current_page,
                            last_page: response.last_page,
                            next_page_url: response.next_page_url,
                            prev_page_url: response.prev_page_url,
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
                    .then(response => response.json())
                    .then(response => {
                        this.fetchTasks();
                        alert('Task removed!');
                    })
                    .catch(error => console.log(error));
                }
            },
            addTask(){
                if(this.edit === false){
                    // Add
                    fetch('/api/tasks/', {
                        method: 'post',
                        body: JSON.stringify(this.task),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.task.title = '';
                        this.task.description = '';
                        alert("Task Added");
                        this.fetchTasks();
                    })
                    .catch(error => console.log(error));
                }else{
                    // Update
                    fetch('/api/tasks/' + this.task_id, {
                        method: 'put',
                        body: JSON.stringify(this.task),
                        headers: {
                            'content-type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.edit = false;
                        this.task.title = '';
                        this.task.description = '';
                        alert("Task Updated");
                        this.fetchTasks();
                    })
                    .catch(error => console.log(error));
                }
            },
            editTask(task){
                this.edit = true;
                this.task.id = task.id;
                this.task_id = task.id;
                this.task.title = task.title;
                this.task.description = task.description;
            }
        }
    }
</script>