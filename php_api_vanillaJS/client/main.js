const taskContainer = document.getElementById('tasks');
const formAdd = document.getElementById('form-add');
const formEdit = document.getElementById('form-edit');
let allTasks = [];

function renderTask(task) {
    const li = document.createElement('li');
    li.innerHTML = `
        <div>
            <h3>${task.title}</h3>
            <p>${task.description}</p>
            <p>${task.id}</p>
            <button onclick="markTaskAsDone('${task.id}')">${task.done ? 'done' : 'not done'}</button>
            <div>
                <button class="edit" onclick="editTask('${task.id}')">Edit</button>
                <button class="delete" onclick="deleteTask('${task.id}')">Delete</button>
            </div>
        </div>
    `;
    taskContainer.appendChild(li);
}


function getTasks() {
    axios.get('http://localhost/tasks_api/get_tasks.php')
        .then(response => {
            //devuelemos un array de todas las tasks
            console.log(response.data);
            allTasks = response.data;
            taskContainer.innerHTML = '';
            //two ways to render the tasks

            //1
            allTasks.forEach(task => renderTask(task));

            //2
            //allTasks.forEach(renderTask);
        })
        .catch(error => {
            console.log(error);
        })
}

getTasks()


formAdd.addEventListener('submit', (event) => {
    event.preventDefault();
    const title = document.getElementById('title-add').value;
    const description = document.getElementById('description-add').value;
    axios.post('http://localhost/tasks_api/add_task.php', { title, description })
        .then(response => {
            console.log(response.data);
            formAdd.reset();
            //renderTask(response.data);
            getTasks()
        })
        .catch(error => {
            console.log(error);
        })
})

function deleteTask(id) {
    confirm('Are you sure you want to delete this task?') && axios.delete(`http://localhost/tasks_api/delete_task.php?id=${id}`)
        .then(response => {
            console.log(response.data);
            getTasks();
        })
        .catch(error => {
            console.log(error);
        })
}

function editTask(id) {
    axios.get(`http://localhost/tasks_api/get_tasks.php?id=${id}`)
        .then(response => {
            console.log(response.data);
            const task = response.data[0];
            document.getElementById('title-edit').value = task.title;
            document.getElementById('description-edit').value = task.description;
            document.getElementById('title-edit').focus();
            formEdit.dataset.id = task.id;
            document.getElementById('cancel-edit').onclick = () => {
                formEdit.reset();
                formEdit.dataset.id = '';
            }
            formEdit.addEventListener('submit', (event) => {
                event.preventDefault();
                const title = document.getElementById('title-edit').value;
                const description = document.getElementById('description-edit').value;
                if (!formEdit.dataset.id) return;
                axios.put(`http://localhost/tasks_api/edit_task.php?id=${formEdit.dataset.id}`, { title, description })
                    .then(response => {
                        console.log(response.data);
                        formEdit.reset();
                        formEdit.dataset.id = '';
                        //renderTask(response.data);
                        getTasks()
                    })
                    .catch(error => {
                        console.log(error);
                    })
            })
        })
        .catch(error => {
            console.log(error);
        })
}

async function markTaskAsDone(id) {
    const response = await axios.get(`http://localhost/tasks_api/get_tasks.php?id=${id}`)
    const task = response.data[0];
    let { done } = task;
    console.log('Current task status:', done);
    axios.put(`http://localhost/tasks_api/done.php?id=${id}`, { done: done ? 0 : 1 })
        .then(response => {
            console.log(response.data);
            getTasks();
        })
        .catch(error => {
            console.log(error);
        })
    
}



