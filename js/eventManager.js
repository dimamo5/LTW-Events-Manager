$(document).ready(function() {
    $(".card").click(function(e) {
        var id = e.currentTarget.id.split("event")[1];
        window.location.href = "event.php?id=" + id;
    });
    
    $("#deleteEvent").click(function() {
        swal({
            title: "Are you sure?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function() {
            $.ajax("process/delete.php", 
            {
                type: "POST",
                data: "eventId=" + parseInt(getUrlParameter("id")),
                success: function(data) {
                    var result = JSON.parse(data);
                    switch (result["delete"]) {
                    case "success":
                        swal("Success");
                        window.location.href = "index.php";
                        break;
                    case "failed":
                        swal("Error deleting event!");
                        break;
                    }
                },
                error: function(data) {
                    swal("Error deleting event!");
                }
            });
        });
    });

    $("#newpost").click(function(e){
        $("#NewPost").show();
    });

    $("form #back").click(function(e){
        $("#NewPost").hide();
    });
    
    $("#editEvent").click(function(e) {
        $("#openModal").show();
    
    });
    
    $("form #cancel").click(function(e) {
        e.preventDefault();
        $("#openModal").hide();
    }
    );
    
    $("#addUser").click(function(e) {
        $("#inviteUser").show();
    
    });
    
    $("#Users").click(function(e) {
        $("#listUsers").show();
    
    });
    
    $("#addPhoto").click(function(e) {
        $("#addPhotoModal").show();
    
    });
    
    $("#seePhotos").click(function(e) {
        $("#viewPhotos").show();
    
    });
    
    $("button#close").click(function(e) {
        e.preventDefault()
        $("#viewPhotos").hide();
    
    });
        
	$("body").on('keyup', function (e) {
		e.preventDefault();
		if ( e.keyCode === 27 ) {	
        $(".modalDialog").hide();
   	 	}
    });	

    $("#newPostForm").submit(function(e){
        e.preventDefault();
        var postInfo=$("#newPost").val();

        $.post("process/addPost.php",
        {
            'idEvent': parseInt(getUrlParameter("id")),
            'info':postInfo
        },
        function(data) {
            console.log(data);
            var result = JSON.parse(data);
            console.log(result);
            switch (result["edit"]) {
            case "success":
                swal("Success");
                $("#NewPost").hide();
                location.reload();
                break;
            case "failed":
                swal("Error adding Post");
                break;
            }
        }
        )
        .fail(function(error) {
            console.log("erro!!!");
        });
    });
    
    $('#save').click(function(e) {
        e.preventDefault();
        var nameEvent = $("#nameEvent").val();
        var description = $("#description").val();
        var creationDate = $("#creationDate").val();
        var endDate = $("#endDate").val();
        var local = $("#local").val();
        var type = $("#type").val();
        
        $.post("process/edit.php", 
        {
            'idEvent': parseInt(getUrlParameter("id")),
            'nameEvent': nameEvent,
            'description': description,
            'creationDate': creationDate,
            'endDate': endDate,
            'local': local,
            'type': type
        }, 
        function(data) {
            var result = JSON.parse(data);
            switch (result["edit"]) {
            case "success":
                swal("Success");
                $("#openModal").hide();
                location.reload();
                break;
            case "failed":
                swal("Error Editing Event");
                break;
            }
        }
        )
        .fail(function(error) {
            console.log("erro!!!");
        });
    });
    
    $('#searchUser').keyup(function(e) {
        e.preventDefault();
        var search = $("#searchUser").val();
        
        $.post("process/getUsers.php", 
        {
            'username': search,
            'eventId': parseInt(getUrlParameter("id"))
        }, 
        function(data) {
            var result = JSON.parse(data);
            var invited = result["invited"];
            var notInvited = result["notinvited"];
            $("#listUser").empty();
            if (search != "") {
                for (var i = 0; i < notInvited.length; i++) {
                    var input = "<li id=\"user" + notInvited[i]["idUser"] + "\" class=\"listUsers\">" 
                    + "<div id=\"name\">" + notInvited[i]["name"] + "</div>" 
                    + "<div id=\"add\">" 
                    + "<i class=\"fa fa-plus fa-lg\"></i>" 
                    + "</div>" 
                    + "</li>";
                    
                    $("#listUser").append(input);
                }
            }
            
            for (var i = 0; i < invited.length; i++) {
                var input = "<li id=\"user" + invited[i]["idUser"] + "\" class=\"listUsers\">" 
                + "<div id=\"name\">" + invited[i]["name"] + "</div>" 
                + "<div id=\"sub\">" 
                + "<i class=\"fa fa-minus fa-lg\"></i>" 
                + "</div>" 
                + "</li>";
                
                $("#listUser").append(input);
            }
        
        
        }
        )
        .fail(function(error) {
            console.log("erro!!!");
        });
    });
    
    $('#listUser').on("click", ' #add', function(e) {
        
        var id = e.currentTarget.parentElement.id.split("user")[1];
        
        $.post("process/editUser.php", 
        {
            'idUser': id,
            'type': 'add',
            'eventId': parseInt(getUrlParameter("id"))
        
        }, 
        function(data) {
            var result = JSON.parse(data);
            switch (result["editUser"]) {
            case "success":
                $("#searchUser").trigger("keyup");
                break;
            case "failed":
                swal("Error Editing Event");
                break;
            }
        }
        )
        .fail(function(error) {
            console.log("erro!!!");
        });
    });
    
    $('#accept').click(function(e) {
        e.preventDefault();
        
        $.post("process/inviteRequest.php", 
        {
            'idEvent': parseInt(getUrlParameter("id")),
            'request': 'accept'
        }, 
        function(data) {
            var result = JSON.parse(data);
            switch (result["invite"]) {
            case "success":
                location.reload();
                break;
            case "failed":
                swal("Error in Request");
                break;
            }
        }
        )
        .fail(function(error) {
            console.log("erro!!!");
        });
    });
    
    $('#decline').click(function(e) {
        e.preventDefault();
        
        $.post("process/inviteRequest.php", 
        {
            'idEvent': parseInt(getUrlParameter("id")),
            'request': 'decline'
        }, 
        function(data) {
            var result = JSON.parse(data);
            switch (result["invite"]) {
            case "success":
                location.reload();
                break;
            case "failed":
                swal("Error in Request");
                break;
            }
        }
        )
        .fail(function(error) {
            console.log("erro!!!");
        });
    });
    
    $('#autoInvite').click(function(e) {
        e.preventDefault();
        
        $.post("process/inviteRequest.php", 
        {
            'idEvent': parseInt(getUrlParameter("id")),
            'request': 'entry'
        }, 
        function(data) {
            var result = JSON.parse(data);
            switch (result["invite"]) {
            case "success":
                location.reload();
                break;
            case "failed":
                swal("Error in Request");
                break;
            }
        }
        )
        .fail(function(error) {
            console.log("erro!!!");
        });
    });
    
    $('#listUser').on("click", ' #sub', function(e) {
        
        var id = e.currentTarget.parentElement.id.split("user")[1];
        
        $.post("process/editUser.php", 
        {
            'idUser': id,
            'type': 'sub',
            'eventId': parseInt(getUrlParameter("id"))
        
        }, 
        function(data) {
            var result = JSON.parse(data);
            switch (result["editUser"]) {
            case "success":
                $("#searchUser").trigger("keyup");
                break;
            case "failed":
                swal("Error Editing Event");
                break;
            }
        }
        )
        .fail(function(error) {
            console.log("erro!!!");
        });
    });
    
    
    $('#addPhotoForm').submit(function(e) {
        e.preventDefault();
        
        var filedata = $("form#addPhotoForm #eventPhoto")[0];
        formData = new FormData(this);
        
        var i = 0
          
        , len = filedata.files.length;
        
        for (var i = 0; i < len; i++) {
            var file = filedata.files[i];
            formData.append("file" + i, file);
        }
        formData.append('nrfiles', filedata.files.length);
        formData.append('eventId', parseInt(getUrlParameter("id")));
        
        
        $.ajax({
            type: "POST",
            url: "processNewPhoto.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var data=JSON.parse(response);
                if(data["fileuload"]!="success"){
                  console.log(data["fileupload"]); 
           
                }
            },
            error: function(errResponse) {
                console.log(errResponse);
            },
            complete: function() 
            {
                location.reload();
            }
        });
    });

});

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)), 
    sURLVariables = sPageURL.split('&'), 
    sParameterName, 
    i;
    
    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');
        
        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}
;
