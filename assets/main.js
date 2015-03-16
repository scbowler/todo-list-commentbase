$('document').ready(function(){  //when the document is ready
    $("#save_task").click(function(){  //add click handler to save_task button

        var todoadd = $("#todo-add");
        var form_data={
            title:todoadd.find("input[name=title]").val(),
            date:todoadd.find("input[name=date]").val(),
            details:todoadd.find("textarea[name=details]").val(),
        }//get all the values from the form and add them to our data object for sending
        $.ajax(
        {
            url: 'actions/add.php',//send our data to the add.php file
            data: form_data, //give it the form data
            dataType: 'json', //expect json data back
            cache: false,//do not let the response be cached
            method: 'POST', //use POST to send it
            success: function(data){ //and do something when the response comes back
                //success is achieved!
                displayMSg(data, "#todo-add", "added");
            }
        }); 
        
            
    });
    $("#display_refresh").click(function(){  //add a click handler to our data display button

        $.ajax(
        {
            url: 'actions/get.php',  //get our data from the get.php file
            dataType: 'json', //expect json data back from get.php
            cache: false, //do not cache the result
            method: 'POST',  //use the post method
            success: function(data){  //do something when we get data back
                if(data.success)
                {
                    $("#todo-display > .display_container").html(data.html); //take the html object of the data object, and put it into the display container
                }
            }
        });
            
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
                $('#display_refresh').click();
                displayMSg(data, "body", "removed", "remove-msg");
                        
            }
        });
    });
});

function displayMSg(data, append, addRemove, optClass){
    
    var msgDiv = $("<div></div>");
    msgDiv.on("click", ".delete", function(){
        var errorDiv = $(this).parent();
        errorDiv.slideUp();
        $(this).fadeOut(200);
        setTimeout(function(){errorDiv.remove();}, 600);
    });
    if(data.success){
        msgDiv.html("Task " + addRemove + " successfuly");
        msgDiv.addClass("success");
    }else{
        var errorStr = "Task not " + addRemove + "<br>The following errors occured:<br>";
        msgDiv.addClass("fail");
        for(var keys in data.errors){
            errorStr += "-" + data.errors[keys] + "<br>";
        }
        msgDiv.html(errorStr);
    }
    if(typeof optClass !== undefined){
        msgDiv.addClass(optClass);
    }
    
    var delButton = $("<span class='delete'>X</span>");
    delButton.appendTo(msgDiv);
    msgDiv.appendTo(append).hide().slideDown();

    //setTimeout(function(){msgDiv.slideUp(); delButton.fadeOut(200);}, 10000);
    //setTimeout(function(){msgDiv.remove();}, 10600);
}