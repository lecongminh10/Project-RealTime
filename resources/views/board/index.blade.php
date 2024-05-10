@extends('layouts.app')

@section('style')
    <style>
        @import url("https://fonts.googleapis.com/css?family=Arimo:400,700|Roboto+Slab:400,700");

        :root {
            font-size: calc(0.5vw + 1vh);
        }

        * {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        body {
            min-width: 420px;
        }

        h1,
        h4 {
            font-family: "Arimo", sans-serif;
            line-height: 1.3;
        }

        header h1 {
            font-size: 2.4rem;
            margin: 4rem auto;
        }

        span {
            font-size: 3rem;
        }

        p {
            font-family: "Roboto Slab", serif;
        }

        a,
        a:link,
        a:active,
        a:visited {
            color: #0066aa;
            text-decoration: none;
            border-bottom: #000013 0.16rem solid;
        }

        a:hover {
            color: #000013;
            border-bottom: #0066aa 0.16rem solid;
        }

        header,
        footer {
            width: 40rem;
            margin: 2rem auto;
            text-align: center;
        }

        .add-task-container {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            width: 20rem;
            height: 5.3rem;
            margin: auto;
            background: #a8a8a8;
            border: #000013 0.2rem solid;
            border-radius: 0.2rem;
            padding: 0.4rem;
        }

        .main-container {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .columns {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: start;
            -ms-flex-align: start;
            align-items: flex-start;
            margin: 1.6rem auto;
        }

        .column {
            width: 8.4rem;
            margin: 0 0.6rem;
            background: #a8a8a8;
            border: #000013 0.2rem solid;
            border-radius: 0.2rem;
        }

        .column-header {
            padding: 0.1rem;
            border-bottom: #000013 0.2rem solid;
        }

        .column-header h4 {
            text-align: center;
        }

        .to-do-column .column-header {
            background: #ff872f;
        }

        .doing-column .column-header {
            background: #13a4d9;
        }

        .done-column .column-header {
            background: #15d072;
        }

        .trash-column .column-header {
            background: #ff4444;
        }

        .task-list {
            min-height: 3rem;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        li {
            list-style-type: none;
        }

        .column-button {
            text-align: center;
            padding: 0.1rem;
        }

        .button {
            font-family: "Arimo", sans-serif;
            font-weight: 700;
            border: #000013 0.14rem solid;
            border-radius: 0.2rem;
            color: #000013;
            padding: 0.6rem 1rem;
            margin-bottom: 0.3rem;
            cursor: pointer;
        }

        .delete-button {
            background-color: #ff4444;
            margin: 0.1rem auto 0.6rem auto;
        }

        .delete-button:hover {
            background-color: #fa7070;
        }

        .add-button {
            background-color: #ffcb1e;
            padding: 0 1rem;
            height: 2.8rem;
            width: 10rem;
            margin-top: 0.6rem;
        }

        .add-button:hover {
            background-color: #ffdd6e;
        }

        .task {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            vertical-align: middle;
            list-style-type: none;
            background: #fff;
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
            margin: 0.4rem;
            height: 4rem;
            border: #000013 0.15rem solid;
            border-radius: 0.2rem;
            cursor: move;
            text-align: center;
            vertical-align: middle;
        }

        #taskText {
            background: #fff;
            border: #000013 0.15rem solid;
            border-radius: 0.2rem;
            text-align: center;
            font-family: "Roboto Slab", serif;
            height: 4rem;
            width: 7rem;
            margin: auto 0.8rem auto 0.1rem;
        }

        .task p {
            margin: auto;
        }

        /* Dragula CSS Release 3.2.0 from: https://github.com/bevacqua/dragula */

        .gu-mirror {
            position: fixed !important;
            margin: 0 !important;
            z-index: 9999 !important;
            opacity: 0.8;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
            filter: alpha(opacity=80);
        }

        .gu-hide {
            display: none !important;
        }

        .gu-unselectable {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
        }

        .gu-transit {
            opacity: 0.2;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=20)";
            filter: alpha(opacity=20);
        }

        .items {
            position: relative;
        }

        .status {
            position: absolute;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: green;
            top: 15px;
            left: 15px;
        }

        .my-message {
            text-align: right;
            color: blue;
            margin: 5px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-2">
                    <h2> Name : {{ $board->name }}</h2>
                </div>
                <div class="col-md-7"></div>
                <div class="col-md-3">
                    @if ($create_by->id == Auth::user()->id)
                        <button class=" btn btn-primary " data-bs-toggle="modal" data-bs-target="#addMember">Add
                            Member</button>

                            <button class=" btn btn-danger " data-bs-toggle="modal" data-bs-target="#deleteBoard">Delete Board</button>
    
                    @endif
                </div>
            </div>
            <div class="row justify-content-around">

                <div class="col-md-2">
                    <div class="card my-2 text-center">
                        <h5 class="card-title">Người tạo </h5>
                        <div class="card-body items" id="link{{ $create_by->id }}">

                            <img src="{{ $create_by->avatar }}" class="rounded-circle " alt="{{ $create_by->name }}"
                                width="100" height="100">
                            <h5 class="card-title mt-2">{{ $create_by->name }}</h5>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Danh sách thành viên</h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($members as $member)
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center items p-3" id="link{{ $member->id }}">
                                            <img src="{{ $member->avatar }}" class="rounded-circle me-3 "
                                                alt="{{ $member->name }}" width="50" height="50">
                                            <div>
                                                <h6 class="mb-0">{{ $member->name }}</h6>

                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 ">
                    <div class="add-task-container">
                        <div id="addTask">

                            <input type="text" maxlength="50" id="taskText" placeholder="New Task...">
                            <button id="add" class="button add-button" onclick="addTask()">Add New Task</button>
                        </div>
                        <div id="editTask" style="display: none">
                            <input type="text" maxlength="50" id="taskText" class="taskTextUp">
                            <input type="hidden" id="taskId">
                            <button id="update" class="button add-button" onclick="UpTask()">Edit Task</button>
                        </div>
                    </div>

                    <div class="main-container">
                        <ul class="columns">

                            <li class="column to-do-column">
                                <div class="column-header">
                                    <h4>Mới tạo </h4>
                                </div>
                                <ul class="task-list listTask" id="to-do">
                                    @foreach ($tasks as $task)
                                        @if ($task->status == 1)
                                            <li class="task" data-task-id="{{ $task->id }}"
                                                id="task{{ $task->id }}">

                                                <button class="border-0 edit-button bg-body"
                                                    onclick="editTask({{ $task->id }}, '{{ $task->name }}')">
                                                    <p>{{ $task->name }}</p>
                                                </button>
                                            </li>
                                        @endif
                                    @endforeach

                                </ul>
                            </li>

                            <li class="column doing-column">
                                <div class="column-header">
                                    <h4>Đang làm </h4>
                                </div>
                                <ul class="task-list" id="doing">
                                    @foreach ($tasks as $task)
                                        @if ($task->status == 2)
                                            <li class="task" data-task-id="{{ $task->id }}"
                                                id="task{{ $task->id }}">

                                                <button class="border-0 edit-button bg-body"
                                                    onclick="editTask({{ $task->id }}, '{{ $task->name }}')">
                                                    <p>{{ $task->name }}</p>
                                                </button>
                                            </li>
                                        @endif
                                    @endforeach


                                </ul>
                            </li>

                            <li class="column done-column">
                                <div class="column-header">
                                    <h4>Hoàn thành </h4>
                                </div>
                                <ul class="task-list done" id="done">
                                    @foreach ($tasks as $task)
                                        @if ($task->status == 3)
                                            <li class="task" data-task-id="{{ $task->id }}"
                                                id="task{{ $task->id }}">

                                                <button class="border-0 edit-button bg-body"
                                                    onclick="editTask({{ $task->id }}, '{{ $task->name }}')">
                                                    <p>{{ $task->name }}</p>
                                                </button>
                                            </li>
                                        @endif
                                    @endforeach


                                </ul>
                            </li>

                            <li class="column trash-column">
                                <div class="column-header">
                                    <h4>Cũ </h4>
                                </div>
                                <ul class="task-list" id="trash">
                                    @foreach ($tasks as $task)
                                        @if ($task->status == 4)
                                            <li class="task" data-task-id="{{ $task->id }}"
                                                id="task{{ $task->id }}">

                                                <button class="border-0 edit-button bg-body"
                                                    onclick="editTask({{ $task->id }}, '{{ $task->name }}')">
                                                    <p>{{ $task->name }}</p>
                                                </button>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                <div class="column-button">
                                    @if ($create_by->id == Auth::user()->id)
                                        <button class="button delete-button" onclick="emptyTrash()">Delete</button>
                                    @endif
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="col-md-3 order-md-last">
                    <div class="container">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#home">Chat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#menu1">Lịch sử</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane container active" id="home">
                                <div class="row border">
                                    <ul id="messages" class="list-unstyled overflow-auto" style="min-height:300px"></ul>
                                    <form class="border-top">
                                        <div class="row py-3">
                                            <div class="col-10">
                                                <input type="text" id="message" class="form-control">
                                            </div>
                                            <div class="col-2">
                                                <button id="send" class="btn btn-primary">Gửi</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane container" id="menu1">
                                <div class="container">
                                    <ul class="notifications my-3"></ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    </div>


    <div class="modal fade" id="addMember" tabindex="-1" aria-labelledby="addMemberLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberLabel">Add Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="boardId" value="{{ $board->id }}">
                    <div class="mb-2">
                        <label for="avatar">Member</label>
                        <select multiple name="member[]" id="members" class=" form-control "
                            style="min-height: 250px">
                            @foreach ($add_member as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="confirmAdd">Add</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="deleteBoard" tabindex="-1" aria-labelledby="deleteBoardLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBoardLabel">Delete Board</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="IdBoard" value="{{ $board->id }}">
                    <p class="text-danger">Bạn có chắc muốn xóa không </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="confirmdeleteBoard">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('script')
        <script type="module">
            Echo.channel("notificationss")
                .listen("UserSessionChange", e => {
                    const notiElement = document.querySelector("#notifications")
                    notiElement.innerText = e.message
                    notiElement.classList.remove("invisible")
                    notiElement.classList.remove("alert-success")
                    notiElement.classList.remove("alert-danger")
                    notiElement.classList.add('alert-' + e.type)

                })
        </script>

        <script type="module">
            Echo.join('usersonline')
                .here(
                    function(users) {
                        users.forEach(function(user) {
                            var element = document.querySelector('#link' + user.id);
                            let notifications = document.querySelector('.notifications');
                            if (element) {
                                var statusElement = document.createElement("div");
                                statusElement.classList.add('status');

                                element.appendChild(statusElement);
                            }
                            if (notifications) {
                                var li_notifications = document.createElement("li");
                                li_notifications.innerHTML = `${user.name} is online`;
                                li_notifications.classList.add('text-primary');
                                notifications.appendChild(li_notifications);
                            }
                        });


                    })
                .joining(function(user) {
                    var element = document.querySelector('#link' + user.id);
                    let notifications = document.querySelector('.notifications');
                    if (element) {
                        var statusElement = document.createElement("div");
                        statusElement.classList.add('status');
                        element.appendChild(statusElement);
                    }
                    if (notifications) {
                        var li_notifications = document.createElement("li");
                        li_notifications.innerHTML = `${user.name} is online`;
                        li_notifications.classList.add('text-primary');
                        notifications.appendChild(li_notifications);
                    }
                })
                .leaving(function(user) {
                    var element = document.querySelector('#link' + user.id);
                    let notifications = document.querySelector('.notifications');
                    var statusElement = element.querySelector(".status");
                    if (statusElement) {
                        element.removeChild(statusElement);
                    }
                    if (notifications) {
                        var li_notifications = document.createElement("li");
                        li_notifications.innerHTML = `${user.name} is off`;
                        li_notifications.classList.add('text-danger');
                        notifications.appendChild(li_notifications);
                    }
                })
                .listen('UserOnline', (e) => {
                    let messages = document.querySelector("#messages");
                    let itemElement = document.createElement('li');
                    itemElement.classList.add('my-2');

                    itemElement.textContent = `${e.user.name} :${e.message}`;

                    messages.appendChild(itemElement);
                    if (e.user.id == "{{ Auth::user()->id }}") {
                        itemElement.classList.add('my-message')
                    }
                })


            ;


            let btnSent = document.querySelector("#send");
            let message = document.querySelector('#message');
            btnSent.addEventListener('click', function(e) {
                e.preventDefault();
                axios.post('{{ route('postmessage') }}', {
                    'message': message.value
                }).then((data) => {
                    message.value = ""
                })
            })


            let members = document.querySelector("#members");
            let boardId = document.querySelector("#boardId");

            let confirmAdd = document.querySelector("#confirmAdd");
            confirmAdd.addEventListener('click', function() {
                let selectedMembers = [];
                let selectedOptions = members.selectedOptions;
                for (let i = 0; i < selectedOptions.length; i++) {
                    selectedMembers.push(selectedOptions[i].value);
                }
                let data = {
                    id: boardId.value,
                    members: selectedMembers
                };

                axios.post("{{ route('addNewMember') }}", data)
                    .then(res => {
                       
                        console.log(res);
                        let btnClose = document.querySelector("#addMember .btn-secondary")
                        btnClose.click();
                    })
            })

           let confirmdeleteBoard = document.querySelector('#confirmdeleteBoard');
            let IdBoard = document.querySelector('#IdBoard');
            confirmdeleteBoard.addEventListener('click' , function(){
                
                let id = IdBoard.value
                axios.post("{{ route('deleteBoard') }}", {id})
                    .then(res => {
                        alert(res.data.message);
                        window.location.reload();
                    })
            })
        </script>

        <script type="module">
            Echo.channel('task')
                .listen('TaskCreated', (e) => {
                    let notifications = document.querySelector('.notifications');
                    document.getElementById("to-do").innerHTML += "<li class='task'><p>" + e.task.name + "</p></li>";
                    if (notifications) {
                        var li_notifications = document.createElement("li");
                        li_notifications.innerHTML = `${e.create_by} is create tasks ${e.task.name}`;
                        li_notifications.classList.add('text-success');
                        notifications.appendChild(li_notifications);
                    }
                })
                .listen('TaskDrop', (e) => {
                    let to_do = document.getElementById("to-do");
                    let doing = document.getElementById("doing");
                    let done = document.getElementById("done");
                    let trash = document.getElementById("trash");
                    var task_id = document.querySelector(`#task${e.task.id}`);
                    let notifications = document.querySelector('.notifications');

                    if (task_id) {
                        task_id.remove();
                    }

                    function createTaskElement(task, list) {
                        var li_task = document.createElement("li");
                        li_task.classList.add('task');
                        var p_li_task = document.createElement("p");
                        p_li_task.innerHTML = task.name;
                        li_task.appendChild(p_li_task);
                        list.appendChild(li_task);
                    }

                    if (e.task.status == 1) {
                        createTaskElement(e.task, to_do);
                    } else if (e.task.status == 2) {
                        createTaskElement(e.task, doing);
                    } else if (e.task.status == 3) {
                        createTaskElement(e.task, done);
                    } else if (e.task.status == 4) {
                        createTaskElement(e.task, trash);
                    }
                    if (notifications) {
                        var li_notifications = document.createElement("li");
                        li_notifications.innerHTML = `${e.create_by} has moved task ${e.task.name}`;
                        li_notifications.classList.add('text-success');
                        notifications.appendChild(li_notifications);
                    }

                })
                .listen('TaskDelete', (e) => {
                    document.getElementById("trash").innerHTML = "";
                    let notifications = document.querySelector('.notifications');
                    if (notifications) {
                        var li_notifications = document.createElement("li");
                        li_notifications.innerHTML = `${e.create_by} delete task ${e.task.name}`;
                        li_notifications.classList.add('text-success');
                        notifications.appendChild(li_notifications);
                    }
                })
                .listen('TaskUpdated', (e) => {
                    document.getElementById('editTask').style.display = 'none';
                    document.getElementById('addTask').style.display = 'block';

                    let to_do = document.getElementById("to-do");
                    let doing = document.getElementById("doing");
                    let done = document.getElementById("done");
                    let trash = document.getElementById("trash");
                    var task_id = document.querySelector(`#task${e.task.id}`);
                    let notifications = document.querySelector('.notifications');

                    if (task_id) {
                        task_id.remove();
                    }



                    function createTaskElement(task, list) {
                        var li_task = document.createElement("li");
                        li_task.classList.add('task');
                        li_task.dataset.taskId = task.id;
                        li_task.id = 'task' + task.id;

                        var button_li_task = document.createElement("button");
                        button_li_task.classList.add('border-0', 'edit-button', 'bg-body');
                        button_li_task.onclick = function() {
                            editTask(task.id, task.name);
                        };

                        var p_li_task = document.createElement("p");
                        p_li_task.innerText = task.name;

                        button_li_task.appendChild(p_li_task);
                        li_task.appendChild(button_li_task);
                        list.appendChild(li_task);
                    }

                    if (e.task.status == 1) {
                        createTaskElement(e.task, to_do);
                    } else if (e.task.status == 2) {
                        createTaskElement(e.task, doing);
                    } else if (e.task.status == 3) {
                        createTaskElement(e.task, done);
                    } else if (e.task.status == 4) {
                        createTaskElement(e.task, trash);
                    }



                    if (notifications) {
                        var li_notifications = document.createElement("li");
                        li_notifications.innerHTML = `${e.create_by} edit task ${e.task.name}`;
                        li_notifications.classList.add('text-success');
                        notifications.appendChild(li_notifications);
                    }
                })

            ;
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.js"></script>
        <script>
            dragula([
                    document.getElementById("to-do"),
                    document.getElementById("doing"),
                    document.getElementById("done"),
                    document.getElementById("trash")
                ], {
                    removeOnSpill: false
                })
                .on("drag", function(el) {
                    el.className.replace("ex-moved", "");

                })
                .on("drop", function(el, target, source) {
                    el.className += "ex-moved";

                    var taskId = el.getAttribute('data-task-id');
                    var newStatus = "";
                    switch (target.id) {
                        case "to-do":
                            newStatus = 1;
                            break;
                        case "doing":
                            newStatus = 2;
                            break;
                        case "done":
                            newStatus = 3;
                            break;
                        case "trash":
                            newStatus = 4;
                            break;
                        default:
                            break;
                    }


                    var data = {
                        taskId: taskId,
                        newStatus: newStatus
                    };

                    axios.post("{{ route('updateTask') }}", data)
                        .then(res => {
                            console.log(res);
                        })
                    el.remove();

                })
                .on("over", function(el, container) {
                    container.className += "ex-over";
                })
                .on("out", function(el, container) {
                    container.className.replace("ex-over", "");
                });

            function editTask(taskId, taskName) {
                // Display edit form
                document.getElementById('editTask').style.display = 'block';
                document.getElementById('addTask').style.display = 'none';
                document.querySelector('.taskTextUp').value = taskName;
                var task_id = document.querySelector(`#task${taskId}`);
                task_id.remove();
                let Idtask = document.querySelector('#taskId')
                Idtask.value = taskId;

            }

            // cập nhật task

            function UpTask() {
                let taskname = document.querySelector('.taskTextUp');
                let taskId = document.querySelector('#taskId');

                let data = {
                    taskId: taskId.value,
                    taskname: taskname.value
                }

                axios.post("{{ route('UpTask') }}", data)
                    .then(res => {

                    })

            }

            // thêm task 
            function addTask() {
                var inputTask = document.getElementById("taskText").value;

                document.getElementById("taskText").value = "";


                let data = {
                    boardId: boardId.value,
                    name: inputTask
                };


                axios.post("{{ route('addTask') }}", data)
                    .then(res => {

                    })
            }


            function emptyTrash() {



                var taskIds = [];
                var trashTasks = document.querySelectorAll('#trash .task');
                console.log(trashTasks);
                trashTasks.forEach(function(task) {
                    var taskId = task.getAttribute('data-task-id');
                    taskIds.push(taskId);
                });
                var data = {
                    taskIds: taskIds
                };

                axios.post("{{ route('deleteTasks') }}", data)
                    .then(res => {

                    })
            }
        </script>
    @endsection
