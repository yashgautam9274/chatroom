<?php
// get parameters
$roomname = $_GET['roomname'];
// connecting to database
include 'db_connect.php';

// Execute sql to check whether room exist
$sql = "SELECT * FROM `rooms` WHERE roomname='$roomname";
$result = mysqli_query($conn,$sql);
if($result)
{
    // check room exists
    if(mysqli_num_rows($result)==0){
        $message = "This room does not exist. Try creating a new one";
        echo '<script language="javascript">';
        echo 'alert("'.$message.'");';
        echo 'window.location="http://localhost/chatroom";';
        echo '</script>';
    }
    else{
        echo "Error :". mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<link href="css/product.css" rel="stylesheet">
<style>
body {
  margin: 0 auto;
  max-width: 800px;
  padding: 0 20px;
}

.container {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}

.darker {
  border-color: #ccc;
  background-color: #ddd;
}

.container::after {
  content: "";
  clear: both;
  display: table;
}

.container img {
  float: left;
  max-width: 60px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
}

.container img.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}

.time-right {
  float: right;
  color: #aaa;
}

.time-left {
  float: left;
  color: #999;
}
.anyclass{
  height: 350px;
  overflow-y: scroll;
  background-color: white;
}
</style>
</head>
<body>

<h2>Chat Messages - <?php echo $roomname;?></h2>
<div class="container">
<div class="anyclass">
</div>
</div>
<input type="text" class="form-control" name="usermsg" id="usermsg" placeholder="Add message"><br>
<button class="btn btn-default" name="submiting" id="submitmsg">Send</button>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript">
  // check for new message every 1 second
  setInterval(runFunction,1000);
  function runFunction()
  {
    $.post("htcont.php",{room:'<php echo $roomname ?>'},
    function(data, status){
      document.getElementsByClassName('anyclass')[0].innerHTML = data;
    }
    )
  }
  // if user send message
  // Get the input field
var input = document.getElementById("usermsg");

// Execute a function when the user releases a key on the keyboard
input.addEventListener("keyup", function(event) {
  // Number 13 is the "Enter" key on the keyboard
  if (event.keyCode === 13) {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    document.getElementById("submitmsg").click();
  }
});
 
  $("#submitmsg").click(function(){
    var clientmsg = $("#usermsg").val();
  $.post("postmsg.php", {text: clientmsg, room:'<?php echo $roomname ?>', ip:'<?php echo $_SERVER['REMOTE_ADDR']?>'},
  function(data, status){
    document.getElementsByClassName('anyclass')[0].innerHTML = data;});
    $("#usermsg").val("");
    return false;
  });
</script>
</body>
</html>
