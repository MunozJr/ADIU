<?php
// DataBase connection and constants
$servername = "localhost";
$username = "root";
$db = "adiu";

$con = mysqli_connect($servername, $username, "", $db);

if (!$con) {
    die('Could not connect to DataBase');
}

// First procedure
$sql = "SELECT Gender, SUM(Monthly_expenses) as Total_Expenses";
$sql .= " FROM university_students_monthly_expenses GROUP BY Gender;";
$aux1 = array();
if ($result = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($result)  > 0) {
        while ($row = $result->fetch_assoc()) {
            $aux1[] = $row;
        }
    } else {
        echo "Query failed";
    }
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
}

// Second procedure
$sql = "SELECT Gender, Age, if(Transporting = 'yes',1, 0) as transport,"; 
$sql .= "if(Smoking = 'yes',1,0) as smoking,";
$sql .= "if(Drinks = 'yes',1,0) as drinks,";
$sql .= "if(Games_Hobbies = 'yes', 1,0) as game_hobbies,";
$sql .= "if(Cosmetics_Self_care = 'yes',1, 0) as cosmetics,";
$sql .= "COALESCE(Monthly_expenses, 0) as monthly_expenses FROM university_students_monthly_expenses;";

$aux2 = array();
if ($result = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($result)  > 0) {
        while ($row = $result->fetch_assoc()) {
            $aux2[] = $row;
        }
    } else {
        echo "Query failed";
    }
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
}

// Third procedure

$sql = " SELECT Study_year,COUNT(study_year) as Course FROM university_students_monthly_expenses GROUP BY Study_year;";
$aux3 = array();
if ($result = mysqli_query($con, $sql)) {
    if (mysqli_num_rows($result)  > 0) {
        while ($row = $result->fetch_assoc()) {
            $aux3[] = $row;
        }
    } else {
        echo "Query failed";
    }
} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
}

$con->close();


$finalData[] = $aux1;
$finalData[] = $aux2;
$finalData[] = $aux3;


echo json_encode($finalData);

