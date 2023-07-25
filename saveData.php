<?php
include 'conn.php';
if (isset($_POST['submit'])) {
    // Retrieve the answer from the hidden input fields
    $age = isset($_POST['age']) ? $_POST['age'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    // Retrieve other form fields using the same pattern
  
    // Process and save the answer to the database
    // ...
  }


$age = $_POST['age'];
$gender = $_POST['gender'];
$education = $_POST['education'];
$status = $_POST['status_'];
$dis_type = $_POST['dis_type'];
$tool = $_POST['tool'] ?? "ไม่มี";
$keeper = $_POST['keeper'] ?? "7";
$invest = $_POST['invest'] ?? "1";
$loan = $_POST['loan'] ?? "1";
/* if (isset($_POST['hobby'])) {
    $selectedHobbies = $_POST['hobby'];
    $selectedHobbiesString = implode(', ', $selectedHobbies);
    $hobby = $selectedHobbiesString;
} else {
    $hobby = "ไม่มี";
}
if (isset($_POST['aptitude'])) {
    $selectedAptitude = $_POST['aptitude'];
    $selectedAptitudeString = implode(', ', $selectedAptitude);
    $aptitude = $selectedAptitudeString;
} else {
    $aptitude = "ไม่มี";
}
if (isset($_POST['commute'])) {
    $selectedCommute = $_POST['commute'];
    $selectedCommuteString = implode(', ', $selectedCommute);
    $commute = $selectedCommuteString;
} else {
    $commute = "ทำงานที่บ้าน (WFH)";
}*/

$hobby = $_POST['hobby'] ?? "ไม่มี";
$aptitude = $_POST['aptitude'] ?? "ไม่มี";
$commute = $_POST['commute']  ?? "ทำงานที่บ้าน";
$occupation = $_POST['occupation'];

$sql = "INSERT INTO `data_new` (age, gender, education, status_, dis_type, tool, keeper, invest, loan, hobby, aptitude, commute, occupation)
        VALUES ('$age', '$gender', '$education', '$status', '$dis_type', '$tool','$keeper', '$invest', '$loan', '$hobby', '$aptitude', '$commute', '$occupation')";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('บันทึกข้อมูลสำเร็จ คำตอบจะถูกนำไปปรับปรุงระบบให้มีความแม่นยำมากขึ้น');</script>";
    echo "<script>window.location='homepage.html';</script>";
} else {
    echo "<script>alert('ไม่สามารถบันทึกข้อมูลได้!');</script>";
    echo "<script>window.location='calculator.php';</script>";
}

mysqli_close($conn);
?>