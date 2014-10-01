$('#report').click(function(e){
     $.ajax({
	    url:"report.php?toplist=1",
	    type:'GET',
	    dataType:'json'
	}).done(function(result){
		var html = "";
		for(var key in result){
		    html += "<div><table><tr><td><table>";
		    html += "<tr><td><img src='" + result[key].photo + "' width=60 height=60></td></tr>";
		    html += "<tr><td>" + result[key].description + "</td></tr>";
		    html += "<tr><td> Address :" + result[key].address + "</td></tr>";
		    html += "<tr><td>Latitude :" + result[key].latitude + "</td><td>Longitude :" + result[key].longitude + "</td></tr>";
		    html += "<tr><td>Date: " + result[key].date + "</td></tr>";
		    html += "</table></td><td><input class='reportbttn' type=button data-id=" + result[key].id + " value='Report'></td></tr></table></div>";
		}
		$('#reportbody').html(html);
		$('#reportModal').modal('show');
		addReportBttnToDom();
	});
});

function addReportBttnToDom(){
    $('.reportbttn').click(function(e){
	    var eventid = $(this).data('id');
	    var html = "";
	    html += '<form method=post action=report.php enctype="multipart/form-data">';
	    html += '<input type=hidden name=eventid value=' + eventid + '>';
	    html += '<input type=hidden name=reportevent value=1>';
	    html += '<table>';
	    html += '<tr><td>Before Picture</td><td><input id="beforepic" type="file" name="beforepic" accept="image/*" capture></td></tr>';
	    html += '<tr><td>After Picture</td><td><input id="afterpic" type="file" name="afterpic" accept="image/*" capture></td></tr>';
	    html += '<tr><td>Completed Date(YYYY-MM-DD): <input type=text name=comp_date></td><td>Completion Time (HH:MIN): <input type=text name=comp_time></td></tr>';
	    html += '<tr><td>Description of Fix</td><td><textarea name=desc></textarea></td></tr>';
	    html += '</table>';
	    html += '<input type=submit value=Report class="btn btn-primary">';
	    html += '</form>';
	    $('#reportbody').html(html);
	});
}
