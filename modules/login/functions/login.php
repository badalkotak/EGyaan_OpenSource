<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login | EGyaan</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../../../Resources/AdminLTE-2.3.11/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="../../../Resources/AdminLTE-2.3.11/dist/css/login.css">
    </head>
    <body>
        <div class="container ">
            <div class="form-registration login-form col-md-4 col-md-offset-4 clearfix">
                <div class="form-group">
                    <center><img src="../../../Resources/images/EGYAAN_logo_transparent_small.png"></center>
                </div>                
                <form action="" method="post" id="login">
                    <div class="form-group">
                        <input type="text" name="email" id="email" class="form-control" placeholder="Username/Email ">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="form-group">
                        <input type="password" name="passwd" class="form-control" id="passwd" placeholder="Password">
                        <i class="fa fa-lock"></i>
                    </div>
                    <div style="color:#f56954" id="error"></div>
                    <!-- <a class="link" href="#">Lost your password?</a> -->
                    <div class="form-group">
                        <button type="submit" class="log-btn" style="width:100%" value="Login" id="submit" >Log in</button>
                    </div>    
            </form>
        </div>
        <script src='../../../Resources/AdminLTE-2.3.11/plugins/jQuery/jquery-2.2.3.min.js'>
        </script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script src="../../../Resources/AdminLTE-2.3.11/bootstrap/js/bootstrap.min.js"></script>
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
        var alert_icon = document.createElement('i');
        alert_icon.setAttribute('class', 'fa fa-exclamation-triangle');
      $("#error").html(alert_icon).append("Please input all the fields!");
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
            var alert_icon = document.createElement('i');
            alert_icon.setAttribute('class', 'fa fa-exclamation-triangle');
            $("#error").html(alert_icon).append("Invalid Username/Password!");
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
<div class="row pull-right" style='color:white; position: fixed; bottom:0; right:0; background:#d33724; padding: 0 20px; border-radius: 4px'>
<h5>JavaScript is Disabled. For Best Experience, Enable JavaScript and Login!</h5>
</div>
</noscript>