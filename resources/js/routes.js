import Vue from 'vue';
import VueRouter from 'vue-router';

import TasksComponent from './components/TasksComponent.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/tasks',
            component: TasksComponent
        }
    ]
})

export default router;