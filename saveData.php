<?php
include 'conn.php';

$question1 = $_POST["question1"];
$question2 = $_POST["question2"];
$question3 = $_POST["question3"];
$question4 = $_POST["question4"];
$question5 = $_POST["question5"];
$question6 = $_POST["question6"];
$comment = $_POST["comment"];

$sql = "INSERT INTO feedback (question1, question2, question3, question4, question5, question6, comment)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "iiiiiss", $question1, $question2, $question3, $question4, $question5, $question6, $comment);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('บันทึกข้อมูลสำเร็จ คำตอบจะถูกนำไปปรับปรุงระบบให้มีความแม่นยำมากขึ้น');</script>";
        echo "<script>window.location='index.php';</script>";
    } else {
        echo "<script>alert('ไม่สามารถบันทึกข้อมูลได้! " . mysqli_error($conn) . "');</script>";
        echo "<script>window.location='result.php';</script>";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "<script>alert('ไม่สามารถเตรียมคำสั่ง SQL ได้!');</script>";
    echo "<script>window.location='result.php';</script>";
}

mysqli_close($conn);
?>
