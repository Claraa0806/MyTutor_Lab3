<?php
include_once("dbconnect.php");
if (isset($_GET['cust_email'])) {
    $cust_email = $_GET['cust_email'];
}else{
    $cust_email = "guest";
}

if (isset($_GET['ttid'])) {
    $ttid = $_GET['ttid'];
    $sqltutor = "SELECT * FROM tbl_tutors WHERE tutor_id = '$ttid'";
    $stmt = $conn->prepare($sqltutor);
    $stmt->execute();
    $number_of_result = $stmt->rowCount();
    if ($number_of_result > 0) {
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();
    } else {
        echo "<script>alert('Product not found.');</script>";
        echo "<script> window.location.replace('tutors.php')</script>";
    }
} else {
    echo "<script>alert('Page Error.');</script>";
    echo "<script> window.location.replace('tutors.php')</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Details</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/scripts.js" defer></script>
</head>

<body>
    <header class="w3-header w3-teal w3-center w3-padding-16" style="height:80px">
        <h2>Tutor Details</h2>
    </header>
<div class="w3-card w3-container w3-padding w3-margin w3-round">
<form>
    <div class="w3-bar w3-light-grey w3-border">
    <a href="main.php" class="w3-bar-item w3-button w3-mobile w3-teal" style="width:23%">Courses</a>
    <a href="tutors.php" class="w3-bar-item w3-button w3-mobile" style="width:23%">Tutors</a>
    <a href="#" class="w3-bar-item w3-button w3-mobile" style="width:23%">Subscription</a>
    <a href="profile.php" class="w3-bar-item w3-button w3-mobile"style="width:23%">Profile</a>
    <a href="tutors.php" class="w3-bar-item w3-button w3-mobile w3-red">Back</a>
  </div>
  </form>
</div>
    <div>
    <?php
        foreach ($rows as $tutors) {
            $ttid = $tutors['tutor_id'];
            $ttemail = $tutors['tutor_email'];
            $ttphone = $tutors['tutor_phone'];
            $ttname = $tutors['tutor_name'];
            $ttdesc = $tutors['tutor_description'];
            $ttdatereg = $tutors['tutor_datereg'];
        }
        echo "<div class='w3-center'><img class='w3-image resimg' src=../../mytutor/assets/tutors/$ttid.jpg" .
        " onerror=this.onerror=null;this.src='../../assets/images/error.png'"
        . " ><hr></div>";
        echo "<div class='w3-container w3-padding-large'><h4><b>$ttname</b></h4>";
        echo " <div><p><b>Phone:</b> $ttphone</p><p><b>Email:</b> $ttemail</p><p><b>Description:</b> $ttdesc</p><p><b>Register Date:</b> $ttdatereg</p>
        </div></div>";

    ?>
    </div>
    <footer class="w3-footer w3-center w3-bottom w3-teal">MyTutor</footer>
</body>

</html>