$(document).ready(function(){
	$("#add_notice").submit(function(event){
		event.preventDefault();
	});
	$('input:radio[name=type]').on('change', function() {
		var branch=$("input:radio[name=type]:checked").val();	
		$.ajax({
			method:"POST",
			url:"get_branch.php",
			data:"output="+true,
			dataType:"json",


			success:function(json){
				var status=json.status;
				if(status=="success")
				{	

					if(json.count==0){
						$("#branch").html("No branch added yet");

					}
					else{
						if(branch=="b"){
						var checkbox="";
						for( var i=0; i<json.branch.length;  i++)
						{
							checkbox=checkbox + "<label class='col-md-6' for=select_branch[]><input type=checkbox id='select_branch[]' name='select_branch[]' value="+json.branch[i].id+"  />&nbsp;"+json.branch[i].name+"</label>";
						}		
						$("#branch").html(checkbox);
					}
					else
					{
						$("#branch").html("");

					}


					}
				}
				else if(status=="failed")
				{

				}
				else{
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