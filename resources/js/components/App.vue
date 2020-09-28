<template>
    <div class="container" id="app-component">
        <loading
            :active.sync="isLoading"
            :can-cancel="true"
            :on-cancel="onCancel"
            :is-full-page="fullPage"
        ></loading>
        <div class="row justify-content-center my-2">
            <div class="col">
                <div class="form-row align-items-center">
                    <div class="col-6">
                        <label class="sr-only" for="inputTitle">title</label>
                        <input
                            v-model="task.title"
                            type="text"
                            class="form-control"
                            id="inputTitle"
                            placeholder="Entre Title the Task..."
                        />
                    </div>
                    <div class="col-4">
                        <label class="sr-only" for="priority">Priority</label>

                        <select
                            id="priority"
                            class="form-control"
                            v-model="task.priority"
                        >
                            <option>Low</option>
                            <option>Meduime</option>
                            <option>High</option>
                        </select>
                    </div>
                    <div class="col-2">
                        <button
                            v-if="!isOpenBtnUpdate"
                            @click="storeTask"
                            class="btn btn-primary px-4"
                        >
                            Add
                        </button>
                        <button
                            v-if="isOpenBtnUpdate"
                            @click="updateTask"
                            class="btn btn-success px-4"
                        >
                            update
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <tasks :tasks="tasks" @update="checkTask" @delete="remove" />
        </div>
    </div>
</template>

<script>
import Tasks from "./Tasks";
// Import component
import Loading from "vue-loading-overlay";
// Import stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
import axios from "axios";
export default {
    data() {
        return {
            isOpenBtnUpdate: false,
            tasks: [],
            task: { id: "", title: "", priority: "" },
            isLoading: false,
            fullPage: true
        };
    },
    components: {
        Tasks,
        Loading
    },
    methods: {
        getTasks() {
            this.isLoading = true;
            axios
                .get("api/tasks ")
                .then(response => (this.tasks = response.data))
                .catch(error => console.log(error));
            this.isLoading = false;
        },
        storeTask() {
            this.isLoading = true;
            if (this.task.title != "" && this.task.priority != "") {
                axios
                    .post("api/tasks", this.task)
                    .then(response => {
                        this.tasks.push(response.data);
                        this.task.title = "";
                    })
                    .catch(error => console.log(error));
            }
            this.isLoading = false;
        },
        checkTask(params) {
            this.task.id = params.id;
            this.task.title = params.title;
            this.task.priority = params.priority;
            this.isOpenBtnUpdate = true;
            console.log(this.task);
        },
        updateTask() {
            this.isLoading = true;
            if (this.task.title != "" && this.task.priority != "") {
                console.log(this.task);
                axios
                    .put(`api/tasks/${this.task.id}`, this.task)
                    .then(response => {
                        this.getTasks();
                        this.task.title = "";
                        this.isOpenBtnUpdate = false;
                    })
                    .catch(error => console.log(error));
            }
            this.isLoading = false;
        },
        remove(params) {
            window.axios
                .delete(`api/tasks/${params.id}`)
                .then(() => {
                    let index = this.tasks.findIndex(
                        task => task.id == params.id
                    );
                    this.tasks.splice(index, 1);
                })
                .catch(error => console.log(error));
        },
        onCancel() {
            console.log("User cancelled the loader.");
        }
    },
    created() {
        this.getTasks();
    },
    mounted() {}
};
</script>
