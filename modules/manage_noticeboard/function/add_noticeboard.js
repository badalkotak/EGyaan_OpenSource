$(document).ready(function(){
	$("#add_notice").submit(function(event){
		event.preventDefault();
	});
	$('#add_notice_submit').on('click', function() {
				var fd = new FormData($('#add_notice').get(0));
				fd.append("output",true);
				$.ajax({
					url: "insert_get_noticeboard.php",
					type: "POST",
					data: fd,
					processData: false,  
					contentType: false ,
					dataType:"json",

						  success:function(json){
						  	console.log("in");
						  	console.log(json.status);
						  	$("#errormessage").html(json.message);

						  	if(json.status=="success" )
						  	{
						  		console.log(json.status);
						  		window.location.href = 'index.php?errormessage='+json.message;

						  	}
						  	else{
						  		window.location.href = 'index.php?errormessage='+json.message;


						  	}

						  },
						  error:function(jqxHR,textStatus,errorThrown){
						  	console.log(textStatus);
						  	console.log("error" + errorThrown);
						  }


						});


			});

});