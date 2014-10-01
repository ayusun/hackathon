<?php
    session_start();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>SpotFix</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script src="./js/jquery.js"></script>
    <script src="./js/bootstrap-modal.js"></script>
    <script src="./js/bootstrap-modalmanager.js"></script>
    <script>
	function showLocation(position) {
	    var latitude = position.coords.latitude;
	    var longitude = position.coords.longitude;
	    
	    $('#latitude_text').val(latitude);
        $('#longitude_text').val(longitude);
	    var myLatlng = new google.maps.LatLng(latitude,longitude);
	    var mapOptions = {
	      zoom: 8,
	      center: myLatlng
	    }
	    
	    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	    var marker = new google.maps.Marker({
	        position: myLatlng,
	        map: map,
	        title: 'Your location'
	    });
	    google.maps.event.addListener(marker, 'click', function() {
			alert("Home Location");
        });
	    
	    $.ajax({
	        url:"join.php?toplist=1",
	        type:'GET',
	        data: {lat: latitude, lon: longitude},
	        dataType:'json'
	    }).done(function(data){
		    for(var key in data){
				var visitedLatlng = new google.maps.LatLng(data[key].info.latitude,data[key].info.longitude);
		        var availMarker = new google.maps.Marker({
	                position: visitedLatlng,
	                map: map,
	                title: 'Available Spot',
	                icon: 'img/available.png'
	            });
	            with ({ id: data[key].info.id }) {
		            google.maps.event.addListener(availMarker, 'click', function() {
				        location.href = 'event.php?id=' + id;
	                });
			    }
		    }
	    });
	    
	    $.ajax({
	        url:'location.php',
	        dataType:'json'
	    }).done(function(data){
	        for(var key in data){
		        var visitedLatlng = new google.maps.LatLng(data[key].latitude,data[key].longitude);
		        var visitedMarker = new google.maps.Marker({
	                position: visitedLatlng,
	                map: map,
	                title: 'Visited Spot',
	                icon: 'img/x-mark-13.png'
	                
	            });
	            with ({ id: data[key].id }) {
		            google.maps.event.addListener(visitedMarker, 'click', function() {
				        location.href = 'event.php?id=' + id;
	                });
                }
		    }
	    });
	}
	
	
	function errorHandler(err) {
	    if(err.code == 1) {
	      alert("Error: Access is denied!");
	    }else if( err.code == 2) {
	      alert("Error: Position is unavailable!");
	    }
	}
	
	function getLocation(){
	   if(navigator.geolocation){
	      // timeout at 60000 milliseconds (60 seconds)
	      var options = {timeout:60000};
	      navigator.geolocation.getCurrentPosition(showLocation, 
	                                               errorHandler,
	                                               options);
	   }else{
	      alert("Sorry, browser does not support geolocation!");
	   }
	}		
	
	function initialize() {
	    getLocation();
	}


    </script>
    <link rel="stylesheet" href="./css/bootstrap-modal.css">
    <link rel="stylesheet" href="./css/bootstrap-modal-bs3patch.css">
    <link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/index.css">
    <script>
		google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
	
	<?php 
	    if(isset($_SESSION['id']) && isset($_SESSION['name'])){
	?>
	<div id="top-bar" id="topBar">
		<div id="welcome">Welcome <?=$_SESSION['name']?>!!!</div>
		<div id="control">
			<input type="button" onclick="location.href='logout.php'" value="Logout">
		    <input type="button" value="Plan" data-toggle="modal" data-target="#myModal">
		    <input type="button" value="Join" id="join">
		    <input type="button" value="Report" id="report">
		    <input type="button" value="Profile" onclick="location.href='profile.php'">
		</div>
	</div>
	<div id="map-canvas"></div>  
	<!-- Plan Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:-999;">
	  <div class="modal-dialog">
	    <div class="modal-content">
		  <form id="planForm" action="plan.php" method="POST" enctype="multipart/form-data">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
		        <h4 class="modal-title" id="myModalLabel">Plan A Spot Fix</h4>
		      </div>
		      <div class="modal-body" id="planForm-body">
				  <table>
				    <tr><td><label for="image">Image</label></td><td><input id="image" type="file" name="image" accept="image/*" capture required></td></tr>
				    <tr><td><label for="txt_desc">Description</label></td><td><textarea id="txt_desc" name="txt_desc" required></textarea></td></tr>
				    <tr><td><label for="dd">Date(DD-MM-YYYY)</label></td><td><input type="text" name="dd" id="dd" class="input-mini" placeholder="DD" required><input class="input-mini" type="text" id="mm" name="mm" placeholder="MM" required><input class="input-mini" type="text" id="yy" name="yy" placeholder="YYYY" required></td></tr>
				    <tr><td><label for="hh">Time (HH:MM)</label></td><td><input type="text" name="hh" id="hh" class="input-mini" placeholder="HH" required><input class="input-mini" type="text" id="min" name="min" placeholder="MIN" required></td></tr>
				    <tr><td><label for="txt_add">Address</label></td><td><textarea id="txt_add" name="txt_add" required></textarea><input type=button value="Reverse Geo Code" id="rev_geocode"></td></tr>
				    <tr><td><label for="latlng_div">Latitude/Longitude(By default Current Postion)</label></td><td><div id="latlng_div"><input type=text name="latitude" id="latitude_text" placeholder="latitude" required><input type=text name="longitude" id="longitude_text" placeholder="longitude" required></div></td></tr>
				  </table> 
	          </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <input type="button" id="plansubmit" name="plansubmit" class="btn btn-primary" value="Plan">
		        <script src="./js/planform.js"></script>
		      </div>
	      </form>
	    </div>
	  </div>
	</div> <!-- Plan Modal End -->
	<!-- JOIN MODAL BOX -->
	<div class="modal fade" id="joinModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:-999;">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
	        <h4 class="modal-title" id="myModalLabel">Join a Plan!!!</h4>
	      </div>
	      <div class="modal-body" id="join-body">
			  <h4>These are the top Spot Fixing plans that are in your vicinity</h4>
			  <div id="joinbody">
			  </div> 
          </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div><!-- Join modal box end -->
	
	<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index:-999;">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"></span></button>
	        <h4 class="modal-title" id="myModalLabel">Report a Fix!!!</h4>
	      </div>
	      <div class="modal-body" id="report-body">
			  <div id="reportbody">
			  </div> 
          </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <!--<input type="button" id="plansubmit" name="plansubmit" class="btn btn-primary" value="Plan"> -->
	      </div>
	    </div>
	  </div>
	</div>
	  
  <script src="./js/join.js"></script>
  <script src="./js/report.js"></script>
	
    <?php
	    } else {
	?>
	<div>
		<form name="loginForm" method="POST" action="authenticate.php" style="text-align:-webkit-center;">
			<table>
			<tr><td>Username : <input name="username" type="text" placeholder="username"></td></tr>
			<tr><td>Password :<input name="passwd" type="password"></td></tr>
			<tr><td><input type="submit" class="btn input-medium"><input type=button value="New Register" class="btn input-medium" onclick="alert('This part needs to be implemented');"></td></tr>
			</table>
		</form>
	</div>
	<!-- Modal -->
	
	<?php
	    }
	?>
  </body>
</html>
