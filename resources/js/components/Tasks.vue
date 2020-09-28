<template>
    <div class="container" id="task-component" v-if="tasks.length > 0">
        <div class="row">
            <div class="col">
                <div class="alert alert-success">
                    <strong>All Tasks </strong>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Priority</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="task in tasks" :key="task.id">
                            <td>{{ task.title }}</td>
                            <td>{{ task.priority }}</td>
                            <td class="text-center">
                                <a
                                    class="btn btn-success px-3"
                                    @click="edit(task)"
                                    role="button"
                                    >Edit</a
                                >
                                <a
                                    class="btn btn-danger "
                                    @click="remove(task)"
                                    role="button"
                                    >Delete</a
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    components: {},
    props: {
        tasks: Array
    },
    methods: {
        remove(task) {
            this.$emit("delete", task);
        },
        edit(task) {
            this.$emit("update", task);
        }
    },
    mounted() {}
};
</script>
<style lang="css" scoped></style>
