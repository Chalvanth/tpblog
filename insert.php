<?php

if (isset($_POST['submit'])) {
    if (isset($_POST['firstname']) && isset($_POST['email']) &&
        isset($_POST['subject'])) {

$firstname = $_POST['firstname'];
$email = $_POST['email'];
$subject = $_POST['subject'];



if (!empty($firstname) || !empty($email) || !empty($subject)) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "tpform";

    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die('Could not correct to the database.');
    }

}else{
    $Select = "SELECT email FROM register WHERE email = ? LIMIT 1";
    $Insert = "INSERT INTO register(firstname, email, subject) values(?, ?, ?)";
   
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($email);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("sss",$firstname, $email, $subject);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }

        $stmt->close();
        $conn->close();
    }
}
else {
    echo "All field are required.";
    die();
}
}
else {
echo "Submit button is not set";
}
?>


