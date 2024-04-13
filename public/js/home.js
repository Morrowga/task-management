$(function() {
    //set csrf token
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    //initiate project id
    let projectId;

    //update id of task
    let updateId;

    // ------------------------------------ functions ------------------------------------

    //get all projects
    function getProjects()
    {
        $.ajax({
            url: '/projects',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#project-dropdown').append(
                    `
                        <option value="0">Select Project</option>
                    `
                )
                if(response.data.length > 0){
                    $.each(response.data, function(index, project) {
                        //append the projects
                        appendProjects(project);
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

     //project creating function
     function createProject(formData)
     {
         $.ajax({
             url: '/projects',
             type: 'POST',
             data: formData,
             dataType: 'json',
             processData: false,
             contentType: false,
             success: function(response) {
                 if(response.success)
                 {
                     //toast success message
                     toastSuccess('Project Created Successfully.');

                     let project = response.data;

                     //append the projects
                     appendProjects(project);

                     //hide create task modal
                     $('#createProjectModal').modal('hide');

                     $('.create-project-input').val('');

                     //debug the project creating process
                     console.log('Project created successfully:', response);
                 }
             },
             error: function(xhr, status, error) {
                 //debug error while creating project
                 console.error('Error creating project:', xhr.responseText);
             }
         });
     }

    //get all tasks with related project id
    function getTasks()
    {
        $.ajax({
            url: '/tasks/' + projectId,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.success)
                {
                    //clean the tasks area
                    $('#tasks-sortable').empty();

                    //show total count of tasks
                    $('.number-text').text(response.data.length)

                    if(response.data.length > 0){

                        $.each(response.data, function(index, task) {
                            //append the tasks
                            appendTasks(task);
                        });
                    } else {
                        //set the empty response
                        $('#tasks-sortable').append('<h5 class="opacity-50 emtpy-text">Empty Task...</h5>')
                    }
                    $('.task-section').prop('hidden', false);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    //task creating function
    function createTask(formData)
    {
        $.ajax({
            url: '/tasks/' + projectId,
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success)
                {
                    //toast success message
                    toastSuccess('Task Created Successfully.');

                    let task = response.data;

                    //append the tasks
                    appendTasks(task);

                    //hide create task modal
                    $('#createTaskModal').modal('hide');

                    //remove empty text
                    $('.emtpy-text').remove();

                    $('.create-task-input').val('');

                    //debug the task creating process
                    console.log('Task created successfully:', response);
                }
            },
            error: function(xhr, status, error) {
                //debug error while creating task
                console.error('Error creating task:', xhr.responseText);
            }
        });
    }

    //task update order
    function updateOrder(tasks)
    {
        $.ajax({
            url: "/update-tasks-order",
            method: "POST",
            data: { tasks: JSON.stringify(tasks), _token: csrfToken },
            success: function(response) {
                //debug the task creating process
                console.log("Order updated successfully:", response);
            },
            error: function(xhr, status, error) {
                //debug error while updating order.
                console.error("Error updating order:", error);
            }
        });
    }

    //task updating function
    function updateTask(formData)
    {
        $.ajax({
            url: '/tasks/' + updateId + '?_method=PUT',
            type: 'POST',
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success)
                {
                    //toast success message
                    toastSuccess('Task Updated Successfully.');

                    //insert new task value in current existing task.
                    $('li[data-task-id="' + updateId + '"] .task-name-area').text(response.data.name);

                    //hide update modal
                    $('#updateTaskModal').modal('hide');

                    //debug the task updating process.
                    console.log('Task updated successfully:', response);
                }
            },
            error: function(xhr, status, error) {
                //debug error while updating the task.
                console.error('Error creating task:', xhr.responseText);
            }
        });
    }

    //removing task function
    function removeTask(taskId)
    {
        $.ajax({
            url: '/delete-tasks/' + taskId,
            type: 'POST',
            data: { _token: csrfToken },
            dataType: 'json',
            success: function(response) {
                if(response.success)
                {
                     //toast success message
                     toastSuccess('Task Deleted Successfully.');

                    //remove deleted task from sortable task area
                    $('li[data-task-id="' + taskId + '"]').remove();

                    //check li count and display empty text
                    var liCount = $('#tasks-sortable li').length;
                    if(liCount == 0)
                    {
                        $('#tasks-sortable').append('<h5 class="opacity-50 emtpy-text">Empty Task...</h5>')
                    }

                    //debug the task deleting process
                    console.log('Task deleted successfully:', response);
                }
            },
            error: function(xhr, status, error) {
                //debug error while deleting task
                console.error('Error deleting task:', xhr.responseText);
            }
        });
    }

    //append task data to sortable location
    function appendTasks(task)
    {
        $('#tasks-sortable').append(
            `
            <li class="ui-state-default task-li col-3" data-task-id="${task.id}" data-task-name="${task.name}">
                <span class="remove-task-icon" data-id="${task.id}">
                    <i class="fa-solid fa-xmark"></i>
                </span>
                <div>
                    <span class="datetime-text"><i class="fa-regular fa-calendar"></i><span class="mx-2">${dateTimeFormat(task.created_at)}</span></span>
                </div>
                <div class="task-name-area paragraph my-2" data-bs-toggle="modal" data-bs-target="#updateTaskModal">
                    ${task.name}
                </div>
            </li>
            `
        )
    }

    //append project data to select box
    function appendProjects(project)
    {
        $('#project-dropdown').append(
            `
                <option value="${project.id}">${project.name}</option>
            `
        )
    }

    //toast function for success message
    function toastSuccess(message)
    {
        const Toast = Swal.mixin({
            toast: true,
            position: "bottom-start",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            }
          });

          Toast.fire({
            icon: "success",
            title: message
          });
    }

    //formatting datetime function
    function dateTimeFormat(dateString)
    {
        var date = new Date(dateString);

        var formattedDate = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2) + ' ' +
                            ('0' + ((date.getHours() + 11) % 12 + 1)).slice(-2) + ':' + ('0' + date.getMinutes()).slice(-2) + ' ' +
                            (date.getHours() >= 12 ? 'PM' : 'AM');

        return formattedDate;
    }

    // ------------------------------------ events ------------------------------------

    //onChange event for project select box
    $('#project-dropdown').change(function() {
        var selectedValue = $(this).val();
        console.log(selectedValue + ' Here');
        if(selectedValue != 0)
        {
            // set project id value
            projectId = selectedValue;
            //fetching tasks
            getTasks();
        } else {
            $('.task-section').prop('hidden', true)
        }

    });


    //submit event for creating task
    $('#createProjectFormData').submit(function(event)
    {
        //prevent reloading page
        event.preventDefault();

        //get the formData from Form
        var formData = new FormData($(this)[0]);
        //append csrf token to formData
        formData.append('_token', csrfToken);

        //execute create project function
        createProject(formData)
    });


     //initiate sortable plugin and listen sorting event
     $('#tasks-sortable').sortable(
        {
            update: function(event, ui) {
                //create task data array to send
                var taskDataArray = [];

                //getting task id array from task lists
                $(this).children("li").each(function(index) {
                    var taskId = $(this).data("task-id");

                    var taskData = {
                        id: taskId,
                    };

                    //pushing array to task data array;
                    taskDataArray.push(taskData);
                });

                //call switch order function to update order
                updateOrder(taskDataArray);
            }
        }
    );

    //submit event for creating task
    $('#createTaskFormData').submit(function(event)
    {
        //prevent reloading page
        event.preventDefault();

        //get the formData from Form
        var formData = new FormData($(this)[0]);
        //append csrf token to formData
        formData.append('_token', csrfToken);

        //execute create task function
        createTask(formData)
    });

    //submit event for updating task
    $('#updateTaskFormData').submit(function(event)
    {
        //prevent reloading page
        event.preventDefault();

        //get the formData from Form
        var formData = new FormData($(this)[0]);
        //append csrf token to formData
        formData.append('_token', csrfToken);

        //execute update task function
        updateTask(formData)
    });

    //on click function for removing task
    $(document).on('click', '.remove-task-icon', function()
    {
        //call Sweetalert box
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to remove the item.',
            showCancelButton: true,
            confirmButtonText: 'Yes, remove it!',
            confirmButtonColor: '#a61f41',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            //after confirm the process
            if (result.isConfirmed) {
                let taskId = $(this).attr('data-id');

                //execute the remove task function
                removeTask(taskId);

            } else if (result.dismiss === Swal.DismissReason.cancel) {
                //after cancel the process
                Swal.close();
            }
        });
    })

    //add current value to related task update form
    $(document).on('click','.task-li', function()
    {

        //get value from current li
        $('.update-task-input').val($(this).attr('data-task-name'));

        //update id value to the global variable
        updateId = $(this).attr('data-task-id');
    })

    //fetching on load tasks data
    getProjects();
})
