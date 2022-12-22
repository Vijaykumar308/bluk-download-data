<?php  
    // Load the database configuration file 
    //create your own db connection and load that
   include "../dbconn.php";
    if(isset($_POST["submitBtn"])){
    $from = $_POST["from"]." 00:00:00";
    $to = $_POST["to"]." 23:59:59";
    $campaign = $_POST["campaign"];
  
    if($campaign === "--Select--") {
        echo "<script type=\"text/javascript\">
		alert(\"Please select the campaign.\");
		window.location = \"csvReport.php\"
	      </script>";  
    }
    $selectQuery = "SELECT * FROM table1 as t1
                    WHERE
                    t1.created_at BETWEEN '$from' AND '$to' AND
                    t1.campaignct = '$campaign'";

    // Fetch records from database 
    $query = mysqli_query($conn,$selectQuery); 

    if($query->num_rows > 0){ 
        $delimiter = ","; 
        $filename = "csvReport" . date("Y-m-d") . ".csv"; 
        
        // Create a file pointer 
        $f = fopen("php://memory", "w"); 
    
        // Set column headers 
        //all campaign headers in one
        $fields = array("Honda city","Auto Mobiles","Technology","Cars"); 
    }
    fputcsv($f, $fields, $delimiter); 

// FOR EXCEL ROWS
        while($row = $query->fetch_assoc()){ 
            $lineData = array($row["honda_city"], $row["auto_mobiles"], $row["technology"], $row["cars"],
            fputcsv($f, $lineData, $delimiter); 
        } 
    
    // Move back to beginning of file 
    fseek($f, 0); 
    
    // Set headers to download file rather than displayed 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
    header('Content-type: application/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    // header("Content-Type: application/download");
    
    //output all remaining data on a file pointer 
    fpassthru($f); 
    } 
    else{
        echo "<script type=\"text/javascript\">
                alert(\"Record not Found !\");
                window.location = \"csvReport.php\"
              </script>"; 
    }
}
?>
