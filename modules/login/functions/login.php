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

<noscript>
<div style='font-family: sans-serif; color:white; position: fixed; bottom:0; right:0; background:red; padding: 0 20px'>
<p>JavaScript is Disabled. For Best Experience, Enable JavasScript and Login!</p>
</div>
</noscript>