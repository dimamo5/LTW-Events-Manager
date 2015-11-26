$(document).ready(function () {
	$(".card").click(function(e){
	var id=e.currentTarget.id.split("event")[1];
	window.location.href="event.php?id="+id;
	})
});