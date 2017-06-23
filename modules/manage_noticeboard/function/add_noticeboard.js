$(document).ready(function(){
	$("#add_notice").submit(function(event){
		event.preventDefault();
	});
	$('#add_notice_submit').on('click', function() {



		    	//var formData = new FormData($(this)[0]); for file data:formdata, this is how data is passed
     	/*		var branch = new Array(); 		for checkbox
		var select_branch=$("#select_branch").val();
		branch.push(select_branch);
		output=true;*/ 
		var type = $('input:radio[name=type]:checked').val();
		var title=$("#title").val();
		var notice=$("#notice").val();
		var urgent=$("#u").val();
		var file=$("#file").val();
		var branch = new Array();
		var select_branch=$("#select_branch").val();
		branch.push(select_branch);
		output=true;

		if(type=="" || title=="" || notice=="" )
		{
			$("#errormessage").html("Please input all fields");
		}
		else{
			$.ajax({
				method:"POST",
				url:"insert_get_noticeboard.php",
				data: {type:type, title:title, u:urgent,  select_branch:branch, notice:notice, file:file,output:output},
				dataType:"json",

				success:function(json){
					console.log("in");
						console.log(json.status);
						$("#errormessage").html(json.message);

					if(json.status=="success" )
					{
						console.log(json.status);
						$("#errormessage").html(json.message);

					}
					else{
						$("#errormessage").html(json.message);

					}
					
				},
				error:function(jqxHR,textStatus,errorThrown){
					console.log(textStatus);
					console.log("error" + errorThrown);
				}


			});
		}
		
	});

});