
<?php
error_reporting(0);
include_once("dbconnect.php");
if (isset($_GET['cust_email'])) {
    $cust_email = $_GET['cust_email'];
}else{
    $cust_email = "guest";
}
if (isset($_POST['submit'])){
    $prid = $_POST['prid'];
    if ($cust_email == "guest"){
        echo "<script>alert('Please register an account first.');</script>";
        echo "<script> window.location.replace('register.php')</script>";
    }else{
       echo "<script> window.location.replace('tutors.php?prid=$prid')</script>";
        echo "<script>alert('OK.');</script>";
    }
}
if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'search') {
        $search = $_GET['search'];
        $sqltutor = "SELECT * FROM tbl_tutors WHERE tutor_name LIKE '%$search%'";
    }
} else {
    $sqltutor = "SELECT * FROM tbl_tutors";
}

$results_per_page = 10;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}


$stmt = $conn->prepare($sqltutor);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqltutor = $sqltutor . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqltutor);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

$conn= null;


function truncate($string, $length, $dots = "...") {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutors Page</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../js/scripts.js" defer></script>
</head>
<body>
    <header class="w3-header w3-teal w3-center w3-padding-16" style="height:80px">
        <h2>Tutors List</h2>
    </header>
<div class="w3-card w3-container w3-padding w3-margin w3-round">
<form>
    <div class="w3-bar w3-light-grey w3-border">
    <a href="main.php" class="w3-bar-item w3-button w3-mobile w3-teal" style="width:15%">Courses</a>
    <a href="tutors.php" class="w3-bar-item w3-button w3-mobile" style="width:15%">Tutors</a>
    <a href="#" class="w3-bar-item w3-button w3-mobile" style="width:15%">Subscription</a>
    <a href="profile.php" class="w3-bar-item w3-button w3-mobile"style="width:15%">Profile</a>
    <input type="search" name="search" class="w3-bar-item w3-input w3-white w3-mobile" style="width:25%" placeholder="Search..">
    <button class="w3-bar-item w3-button w3-green w3-mobile" type="submit" name="submit" value="search">Search</button>
    <a href="login.php" class="w3-bar-item w3-button w3-mobile w3-red">Logout</a>
  </div>
  </form>
</div>

<div class="w3-margin w3-border" style="overflow-x:auto;">
        <?php
        $i = 0;
        echo "<table class='w3-table w3-striped w3-bordered' style='width:100%'>
        <tr><th style='width:5%'>No</th><th style='width:30%'>Tutor's Name</th><th style='width:25%'>Phone</th><th style='width:30%'>Email</th><th>Details</th></tr>";
        foreach ($rows as $tutors) {
            $i++;
            $ttid = $tutors['tutor_id'];
            $ttname = $tutors['tutor_name'];
            $ttphone = $tutors['tutor_phone'];
            $ttemail = $tutors['tutor_email'];
            echo "<tr><td>$i</td><td>$ttname</td><td>$ttphone</td><td> $ttemail</td>
            <td><a href='tutordetails.php?ttid=$ttid'><p><button class='btn'>Details</p></a></td></button>";
        }
        echo "</table>";
        ?>
    </div>
    <br>
    <?php
    $num = 1;
    if ($pageno == 1) {
        $num = 1;
    } else if ($pageno == 2) {
        $num = ($num) + 10;
    } else {
        $num = $pageno * 10 - 9;
    }
    echo "<div class='w3-container w3-row'>";
    echo "<center>";
    for ($page = 1; $page <= $number_of_page; $page++) {
        echo '<a href = "tutors.php?pageno=' . $page . '" style=
            "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
    }
    echo " ( " . $pageno . " )";
    echo "</center>";
    echo "</div>";
    ?>
    <br>
    <footer class="w3-footer w3-center w3-bottom w3-teal">MyTutor</footer>
</body>
</html>