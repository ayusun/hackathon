function showLoc_join(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    $.ajax({
	    url:"join.php?toplist=1",
	    type:'GET',
	    data: {lat: latitude, lon: longitude},
	    dataType:'json'
	}).done(function(result){
		var html = "";
		for(var key in result){
		    html += "<div><table><tr><td><table>";
		    html += "<tr><td><img src='" + result[key].info.photo + "' width=60 height=60></td></tr>";
		    html += "<tr><td>" + result[key].info.description + "</td></tr>";
		    html += "<tr><td> Address :" + result[key].info.address + "</td></tr>";
		    html += "<tr><td>Latitude :" + result[key].info.latitude + "</td><td>Longitude :" + result[key].info.longitude + "</td></tr>";
		    html += "<tr><td>Date: " + result[key].info.date + "</td></tr>";
		    //html += "<tr><td><input type=button data-id=" + result[key].info.id + " value='Join'></td></tr>";
		    html += "</table></td><td><input class='joinbttn' type=button data-id=" + result[key].info.id + " value='Join'></td></tr></table></div>";
		}
		$('#joinbody').html(html);
		$('#joinModal').modal('show');
		addJoinbttntoDom();
	});
}
function addJoinbttntoDom(){
    $('.joinbttn').click(function(e){
		var bttn = $(this);
	    var id = $(this).data('id');
	    $.ajax({
	        url:"join.php?join=1",
	        type:'GET',
	        data: {id: id}
	    }).done(function(result){
	        if(result === "1"){
			    bttn.prop('value', 'Joined');
			    bttn.prop('disabled', 'disabled');
			    var url = encodeURIComponent(location.href + "event.php?id=" + id);
			    bttn.after("<a href='https://www.facebook.com/sharer/sharer.php?u="+ url +"' target=_blank><img src=./img/facebook-icon.png></a>");
			}
	    });
    });
}
function getLoc_join(){
   if(navigator.geolocation){
      // timeout at 60000 milliseconds (60 seconds)
      
      var options = {timeout:60000, maximumAge: 15000};
      navigator.geolocation.getCurrentPosition(showLoc_join, 
	                                           newErrorHandler_join,
	                                           options);
   }else{
      alert("Sorry, browser does not support geolocation!");
   }
}
function newErrorHandler_join(err) {
	    if(err.code == 1) {
	      alert("Error: Access is denied!");
	    }else if( err.code == 2) {
	      alert("Error: Position is unavailable!");
	    }
}
$('#join').click(function(e){
    getLoc_join();
});
