<?php
include "../dbconn.php";

$from = $_POST['from']." 00:00:00";
$to = $_POST['to']." 23:59:59";
$reportOf = $_POST['reportOf'];
if($from > $to) {
    echo "<script type=\"text/javascript\">
            alert(\"Invalid date !\");
            window.location = \"csv-report.php\";
        </script>";
}
else {
     $selectQuery = "SELECT * FROM $reportOf";  

    $resultObj = mysqli_query($conn,$selectQuery);

    if($resultObj->num_rows > 0) { 
        $delimiter = ","; 
        $filename = "csvReports" . date("Y-m-d").".csv"; 
        
        $rowData = array();
        //Create a file pointer 
        $filePointer = fopen("php://memory", "w"); 
        
        // rows data
        while ($row = mysqli_fetch_assoc($resultObj)) {
            array_push($rowData,$row);
        }

        $header = get_header($rowData[0]);
        fputcsv($filePointer, $header, $delimiter); 

        //creating csv 
        for($index = 0; $index < count($rowData); $index++) {
           $rowForCSV = get_values($rowData[$index]);
           fputcsv($filePointer, $rowForCSV, $delimiter);
        }

        fseek($filePointer, 0); 

        header('Content-Disposition: attachment; filename="' . $filename . '";'); 
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");

        fpassthru($filePointer); 
        // die;
    }
    else {
        echo "<script type=\"text/javascript\">
            alert(\"Record not Found !\");
            window.location.reload = 'csv-report.php'; 
        </script>"; 
    } 
}

function get_values($arr) {
    $temp = array();
    foreach ($arr as $key => $value) {
        array_push($temp,$value);
    }
    return $temp;
}

function modifyHeader($str) {
    return ucwords(str_replace("_", " ", $str));
}

function get_header($data) {
    $header = array();
   foreach ($data as $key => $value) {
        array_push($header,$key);
   }
   return $header;
}

?>
