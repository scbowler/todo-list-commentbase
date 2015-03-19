$('document').ready(function(){
    
    $("#save_task").click(function(){ 

        var todoadd = $("#todo-add");
        var form_data={
            title:todoadd.find("input[name=title]").val(),
            date:todoadd.find("input[name=date]").val(),
            details:todoadd.find("textarea[name=details]").val(),
        }
        $.ajax(
        {
            url: 'actions/add.php',
            data: form_data,
            dataType: 'json',
            cache: false,
            method: 'POST', 
            success: function(data){ 
                displayMSg(data, "#todo-add", "added");
                refreshTasks();
                
            }
        }); 
        
            
    });
    $("#display_refresh").click(function(){

        refreshTasks();
            
    });
    $("#todo-display").on("click", ".delTask", function(){
        var taskContainer = $(this).parent();
        var title = taskContainer.find('.title').text().match(/^Title: (.+)$/);
        
        var taskData ={
            toDelete: taskContainer.data('id'),
            title: title[1]
        }
        
        $.ajax({
            url: 'actions/remove.php',
            data: taskData,
            dataType: 'json',
            cache: false,
            method: 'POST',
            success: function(data){
                refreshTasks();
                displayMSg(data, "body", "removed", "remove-msg");
                console.log(data.result);
                
                        
            }
        });
    });
    
    $(".display_container").on("click", ".editTask", function(){
        var task = {
            id: $(this).parent().data('id')
        }
        
        $.ajax({
            url: 'includes/editForm.php',
            data: task,
            dataType: 'json',
            cache: false,
            method: 'POST',
            success: function(data){
                editTask(data);
            }
        });
        
    });
    $("#display_refresh").click();
});

function displayMSg(data, append, addRemove, optClass){
    
    var delay = 3000;
    
    var msgDiv = $("<div></div>");
    msgDiv.on("click", ".delete", function(){
        var errorDiv = $(this).parent();
        errorDiv.slideUp();
        $(this).fadeOut(200);
        setTimeout(function(){errorDiv.remove();}, 600);
    });
    if(data.success){
        msgDiv.html(data["success msg"]);
        msgDiv.addClass("success");
        
    }else{
        var errorStr = "Task not " + addRemove + "<br>The following errors occured:<br>";
        msgDiv.addClass("fail");
        for(var keys in data.errors){
            errorStr += "-" + data.errors[keys] + "<br>";
        }
        msgDiv.html(errorStr);
        delay = 10000;
    }
    if(typeof optClass !== undefined){
        msgDiv.addClass(optClass);
    }
    
    var delButton = $("<span class='delete'>X</span>");
    delButton.appendTo(msgDiv);
    msgDiv.appendTo(append).hide().slideDown();

    setTimeout(function(){msgDiv.slideUp(); delButton.fadeOut(200);}, delay);
    setTimeout(function(){msgDiv.remove();}, delay+500);
}

function editTask(data){
    var editView = $("<div id='shadow'><div id='editTask'><h1>Edit Task</h1>" + data['html'] + "</div></div>");
    
    editView.appendTo("#main-content").hide().fadeIn();
    
    $("#shadow").on("click", "#cancelUD", function(){
        editView.remove();
    });
    
    $("#shadow").on("click", "#update", function(){
        
        var form_data = {
            title: editView.find("input[name=titleUD]").val(),
            date: editView.find("input[name=dateUD]").val(),
            details: editView.find("textarea[name=detailsUD]").val(),
            id: data['id'],
            update: true
        }
        
        $.ajax({
            url: 'actions/add.php',
            data: form_data,
            dataType: 'json',
            cache: false,
            method: 'POST',
            success: function(data){
                if(data.success){
                    displayMSg(data, "#todo-add", "updated", "update-succ");
                    editView.remove();
                    $("#display_refresh").click();
                }else{
                    displayMSg(data, "#editTask", "updated", "update-errors");
                }
            }
        });
    })
}

function refreshTasks(){
    $.ajax(
        {
            url: 'actions/get.php',
            dataType: 'json', 
            cache: false, 
            method: 'POST',
            success: function(data){ 
                if(data.success)
                {
                    $("#todo-display > .display_container").html(data.html);
                }else{
                    $("#todo-display > .display_container").html("<h1>" + data['error msg'] + "<h1>");
                }
            }
        });
}