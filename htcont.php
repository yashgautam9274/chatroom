<?php
$room = $_POST['room'];
echo $room;
// connecting to database
include 'db_connect.php';
$sql = "SELECT msg, ip, stime FROM msgs WHERE room = 'chating2'";
//$sql = "SELECT * FROM `msgs` WHERE `room` = '$room'";
$res = "";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)>0){
  // echo "yash";
  while($row = mysqli_fetch_assoc($result)){
    $res = $res . '<div class="container">';
    $res = $res . $row['ip'];
    $res = $res . "says <p>".$row['msg'];
    $res = $res . '<p> <span class="time-right">' . $row["stime"] . '</span></div>';
}
}
echo $res;
?>