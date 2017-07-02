<!-- <<<<<<< HEAD
<html>
<head>
  <title>Login</title>
  <script src="../../../Resources/jquery.min.js"></script>
</head>
<body>
  <center><h1><b><u>Welcome to EGyaan!!</u></b></h1></center><br><br>
  <center>
    <form action="" method="post" id="login">
      <input type="text" name="email" id="email" placeholder="Enter Email ID"><br><br>
      <input type="password" name="passwd" id="passwd" placeholder="Enter Password"><br><br>
      <input type="submit" value="Login" id="submit">
      <div id="error"></div>
    </form>
  </center>
</body>
</html>
======= -->
<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <title>Login | EGyaan</title>
        <link rel="stylesheet prefetch" href="../../../Resources/AdminLTE-2.3.11/plugins/font-awesome-4.7.0/css/font-awesome.min.css">

        <link rel="stylesheet" href="../../../Resources/AdminLTE-2.3.11/dist/css/style.css">
	<script src="../../../Resources/jquery.min.js"></script>
    <style>
        .form-control{
            border: 1px solid #FFA737;
        }
        .form-control:focus, .form-control:focus + .fa {
            border-color: #FFA737;
            color: #FFA737;
        }
        .log-btn {
            background: #FFA737;
        }
    </style>

</head>
<body>
<div class="login-form">
    <h1>EGyaan</h1>
		<form action="" method="post" id="login">
            <div class="form-group ">
			<input type="text" name="email" id="email" class="form-control" placeholder="Username/Email ">
                <i class="fa fa-user"></i>
            </div>
            <div class="form-group">
			<input type="password" name="passwd" class="form-control" id="passwd" placeholder="Password">
                <i class="fa fa-lock"></i>
            </div>
            <div id="error" style="color: #07C57F"></div>
            <a class="link" href="#">Lost your password?</a>
            <button type="submit" class="log-btn" value="Login" id="submit" >Log in</button>
		</form>
</div>
<script src='../../../Resources/AdminLTE-2.3.11/plugins/jQuery/jquery-2.2.3.min.js'></script>

<!--<script src="../../../Resources/AdminLTE-2.3.11/dist/js/login.js"></script>-->
<!-- >>>>>>> 7588d4c67a65ce89188a99a92c87b5c44fe53b0f -->

<script>

$(document).ready(function(){

  $("#login").submit(function(event){
    event.preventDefault();
  });

  $("#submit").click(function(){
    var email=$("#email").val();
    var passwd=$("#passwd").val();

    if(email=="" || passwd=="")
    {
      $("#error").text("Please input all the fields!");
    }

    else
    {
      $.ajax({
        type: "POST",
      url: "check_login.php",
      data: "email="+email+"&passwd="+passwd,
      datatype: "json",

      success:function(json)
      {
        var login=json.login;
        console.log(login);

        if(login==="success")
        {
          window.location.replace("Dashboard.php");
        }
        else
        {
          $("#error").text("Invalid Username/Password!");
        }
      }
      });
    }
  });
});

</script>
</body>
</html>

<noscript>
<div style='font-family: sans-serif; color:white; position: fixed; bottom:0; right:0; background:red; padding: 0 20px'>
<p>JavaScript is Disabled. For Best Experience, Enable JavasScript and Login!</p>
</div>
</noscript>