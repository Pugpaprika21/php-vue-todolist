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
                "ยังไม่เริ่ม": "bg-warning",
                "กำลังทำ": "bg-info",
                "เสร็จแล้ว": "bg-success",
            },
        };
    },
    methods: {
        badgeStatusColor: function(status) {
            return `badge ${this.badgeStatusClass[status] || 'bg-primary'} rounded-pill`;
        },
        addTask: function() {
            axios
                .post(this.url + "/addTask.php", {
                    task_name: this.formAdd.task_name,
                    due_date: new Date().toISOString().slice(0, 10),
                    status: "ยังไม่เริ่ม",
                })
                .then((res) => {
                    if (res.status == 201) {
                        this.todoAll();
                        this.formAdd.task_name = "";
                        console.log(res);
                    }
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        updateTaskStatus: function(taskId) {
            console.log(taskId);
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
                    console.log(res.data.Data.Todos);
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