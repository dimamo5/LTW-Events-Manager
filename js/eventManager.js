$(document).ready(function () {
	$(".card").click(function (e) {
		var id = e.currentTarget.id.split("event")[1];
		window.location.href = "event.php?id=" + id;
	});

	$("#deleteEvent").click(function () {
		swal({ title: "Are you sure?", type: "warning", showCancelButton: true, closeOnConfirm: false, showLoaderOnConfirm: true, }, function () {
			$.ajax("processDelete.php",
				{
					type: "POST",
					data: "eventId=" + parseInt(getUrlParameter("id")),
					success: function (data) {
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
					error: function (data) {
						swal("Error deleting event!");
					}
				});
		});
	});

	$("#editEvent").click(function (e) {
		$("#openModal").show();

	});

	$("form #cancel").click(function (e) {
		e.preventDefault();
		$("#openModal").hide();
	}
		);

$('#save').click(function (e) {
		e.preventDefault();
		var nameEvent = $("#nameEvent").val();
		var description = $("#description").val();
		var creationDate = $("#creationDate").val();
		var endDate = $("#endDate").val();
		var local = $("#local").val();
		var type = $("#type").val();

	$.post("processEdit.php",
				{
					'idEvent': parseInt(getUrlParameter("id")),
					'nameEvent': nameEvent,
					'description': description,
					'creationDate': creationDate,
					'endDate': endDate,
					'local':local,
					'type': type
				},
				function (data) {
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
				.fail(function (error) {
					console.log("erro!!!");
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
};