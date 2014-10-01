var lati;
var long;

function validateDate(dd, mm, yy){  
  // Create list of days of a month [assume there is no leap year by default]  
  var ListofDays = [31,28,31,30,31,30,31,31,30,31,30,31];  
  var today = new Date();
  var today_dd = today.getDate();
  var today_mm = today.getMonth()+1; //January is 0!
  var today_yy = today.getFullYear();
  
  if(mm<=0 || mm>12){
      return false;
  }
  if (mm==1 || mm>2)  {  
	  if (dd>ListofDays[mm-1]){  
		  return false;  
	  }  
  }  
  if (mm==2) {  
	  var lyear = false;  
	  if ( (!(yy % 4) && yy % 100) || !(yy % 400)){  
	      lyear = true;  
	  }  
	  if ((lyear==false) && (dd>=29))  
	  {   
		  return false;  
	  }  
	  if ((lyear==true) && (dd>29)){  
		  return false;  
	  }  
  }
  if(yy < today_yy){
	  return false;
  } else if(yy == today_yy){
	  if(mm < today_mm){
	      return false;
	  } else if(mm == today_mm){
		  if(dd <= today_dd){
		      return false;
		  } else {
		       return true;
		  }
	  } else{
	      return true;
	  }
  } else {
      return true;
  }
  return true;  
}

function showLoc(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    $('#latitude_text').text(latitude);
    $('#longitude_text').text(longitude);
	//$('#planForm').submit();
}

function getLoc(){
   if(navigator.geolocation){
      // timeout at 60000 milliseconds (60 seconds)
      
      var options = {timeout:60000, maximumAge: 15000};
      navigator.geolocation.getCurrentPosition(showLoc, 
	                                           newErrorHandler,
	                                           options);
   }else{
      alert("Sorry, browser does not support geolocation!");
   }
}
function newErrorHandler(err) {
	    if(err.code == 1) {
	      alert("Error: Access is denied!");
	    }else if( err.code == 2) {
	      alert("Error: Position is unavailable!");
	    }
}

function validateTime(hh, min){
	console.log(hh + "---" + min);
 if(hh>=0 && hh<=23 && min>=0 && min<=59)
     return true;
 return false;
}
$("#plansubmit").click(function(e){
    e.preventDefault();
    var dd  = parseInt($('#dd').val());
    var mm  = parseInt($('#mm').val());
    var yy  = parseInt($('#yy').val());
    var hh  = parseInt($('#hh').val());
    var min = parseInt($('#min').val());
    if(validateDate(dd,mm,yy) && validateTime(hh, min)){
		if(validateForm(hh, min)){
	        $('#planForm').submit();
		} else {
		    alert("Some entries may be blank");
		}
	} else {
	    alert("Please Check your date and time");
	    return false;
	}
});

function validateForm(){
	var continueInvoke = true;
    $("form input[required]").each(function(){
        /* If the element has no value. */
        if($(this).val() == ""){
            continueInvoke = false;     /* Set the variable to false, to indicate that the form should not be submited. */
        }
    });
    return continueInvoke;
}
$('#rev_geocode').click(function(e){
    var geocoder;
    geocoder = new google.maps.Geocoder();
    var address = $('#txt_add').val();
    geocoder.geocode( { 'address': address}, function(results, status) {
	    if (status == google.maps.GeocoderStatus.OK) {
			console.log(results[0].geometry.location);
			$('#longitude_text').val(results[0].geometry.location.B);
			$('#latitude_text').val(results[0].geometry.location.k);
			
		} else {
		    alert('Geocode was not successful for the following reason: ' + status + '. Please enter the latitude and longitude manually');
		}
	});
});


