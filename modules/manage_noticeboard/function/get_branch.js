$(document).ready(function(){
	$("#get_branch").submit(function(event){
		event.preventDefault();
	});

	$('#type').on('change', function() {
		var branch=$("#type").val();


		
		$.ajax({
			method:"POST",
			url:"get_branch.php",
			data:"branch="+branch,
			dataType:"json",


			success:function(json){

				var status=json.status;
				if(status=="success")
				{	

					if(json.count==0){
						$("#branch").html("No branch added yet");

					}
					else{

						var x=0;
						console.log(json.branch.length);
						var checkbox="";

						for( var i=0; i<json.branch.length;  i++)
						{
							checkbox=checkbox + "<input type=checkbox id='select_branch[]' name='select_branch[]' value="+json.branch[i].id+" />"+json.branch[i].name;
						}		
						$("#branch").html(checkbox);

					}
				}
				else
				{
					$("#errormessage").text("Something went wrong");

				}



			},
			error:function(jqxHR,textStatus,errorThrown){
				console.log(textStatus);
				console.log("error" + errorThrown);
			}


		});
		
	});
});