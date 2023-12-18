const { createApp } = Vue;

createApp({
    data: function() {
        return {
            key: "QWERQDRFAQER1293@@U+-+1283U4-3473e7aa8drf",
            url: "http://localhost/php-vue-todolist/backend/endpoint/todo",
            formAdd: {
                task_name: "",
                todos: [],
            },
            badgeStatusClass: {
                1: "bg-warning",
                2: "bg-info",
                3: "bg-success",
            },
        };
    },
    methods: {
        badgeStatusColor: function(StatusNum) {
            return `badge ${
        this.badgeStatusClass[StatusNum] || "bg-primary"
      } rounded-pill`;
        },
        addTask: function() {
            if (this.formAdd.task_name == "") {
                Swal.fire({
                    position: "center",
                    icon: "warning",
                    title: "Please enter a new Task ..",
                    showConfirmButton: false,
                    timer: 1000,
                });
                return;
            }

            axios
                .post(this.url + "/addTask.php", {
                    task_name: this.formAdd.task_name,
                    due_date: new Date().toISOString().slice(0, 10),
                    status: "Pending",
                    status_num: 1,
                })
                .then((res) => {
                    if (res.status == 201) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: res.data.Data.Msg,
                            showConfirmButton: false,
                            timer: 1000,
                        });
                        this.todoAll();
                        this.formAdd.task_name = "";
                    }
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        updateTaskStatus: function(taskId, statusNum) {
            axios
                .get(this.url + "/updateTaskStatus.php", {
                    params: {
                        taskId: taskId,
                        statusNum: statusNum,
                    },
                    headers: {
                        Authorization: `Bearer ${this.key}`,
                    },
                })
                .then((res) => {
                    if (res.status == 200) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: res.data.Data.Msg,
                            showConfirmButton: false,
                            timer: 1000,
                        }).then((res) => {
                            this.todoAll();
                        });
                    }
                });
        },
        deleteTask: function(taskId) {
            axios
                .get(this.url + "/deleteTask.php", {
                    params: {
                        taskId: taskId,
                    },
                    headers: {
                        Authorization: `Bearer ${this.key}`,
                    },
                })
                .then((res) => {
                    if (res.status == 200) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: res.data.Data.Msg,
                            showConfirmButton: false,
                            timer: 1000,
                        }).then((res) => {
                            this.todoAll();
                        });
                    }
                });
        },
        todoAll: function() {
            axios
                .get(this.url + "/todoAll.php", {
                    headers: {
                        Authorization: `Bearer ${this.key}`,
                    },
                })
                .then((res) => {
                    this.formAdd.todos = res.data.Data.Todos;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
    mounted: function() {
        this.todoAll();
    },
}).mount("#app");