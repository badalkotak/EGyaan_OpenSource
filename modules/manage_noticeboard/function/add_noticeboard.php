<html>
<body>
<form action="insert_get_noticeboard.php" method="post" enctype="multipart/form-data">
Title: <input type=text name=title id=title placeholder="title"> </input>
Notice: <textarea name=notice id=notice placeholder=notice> </textarea>
file:<input type=file name=file id=file></input>
 <input type="radio" name="type" id="type" value="1">Branch<br>
 <input type="radio" name="type" id="type" value="2">Common<br>
 <input type="checkbox" name="u" id="u" value="u"> <br>
<input type=submit value=submit></input>
</form>
</body>
</html>