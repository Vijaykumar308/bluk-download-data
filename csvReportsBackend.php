<?php  
    // Load the database configuration file 
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
    $selectQuery = "SELECT c.id,c.name,u.user_name, u.first_name, u.last_name, ct.created_at,  
                    FROM_BASE64(c.mobile_no) as mobile, FROM_BASE64(c.email) as email, 
                    ct.campaignct, c.device, c.store, c.created_at as created_customer_date, c.amount, c.sku, c.pincode, c.link, c.coupon_code, c.addition_info1, c.addition_info2,
                    -- cug campaign
                    ct.final_disposition, ct.l1, ct.l2, ct.l3, ct.call_back_time, ct.pin_code,
                    -- happy calling
                    ct.l_o_b, ct.type, ct.sub_category, ct.sub_sub_category,
                    ct.disposition, ct.action_done, ct.customer_expectation,
                    -- IB campaign
                    ct.final_disposition_i_b, ct.l1_i_b, ct.l2_i_b, ct.call_status,
                    ct.call_sub_status, ct.call_category, 
                    -- common to all 
                    ct.user_remarks, ct.current_time
                    FROM customer as c
                    JOIN customer_ticket as ct ON c.id=ct.customerid
                    LEFT JOIN user AS u on u.id=ct.created_by_id
                    WHERE
                    ct.created_at BETWEEN '$from' AND '$to' AND
                    ct.campaignct = '$campaign'";

    // Fetch records from database 
    $query = mysqli_query($conn,$selectQuery); 

    if($query->num_rows > 0){ 
        $delimiter = ","; 
        $filename = "csvReport" . date("Y-m-d") . ".csv"; 
        
        // Create a file pointer 
    $f = fopen("php://memory", "w"); 
    
    // Set column headers 
    //all campaign headers in one
    // $fields = array("Mobile No", "Customer NAME", "Customer Email", "Campaign","Final Disposition","L1", "L2","L3","Call Back Time","Pin code",
    // "LOB","Type","Sub Category","Sub sub category","Disposition","Action Done","Customer Expectation",

    // "Final Disposition IB","L1 IB","L2 IB","Call status", "Call sub status","Call Category",
    // "user_remarks","created_at","created_by_id","created_by_name"); 
    
    // Campaign == Happy Calling
// FOR HEADER 
    switch($campaign){
        case "Happy Calling":
            $fields = array("Phone number", "Customer NAME", " Customer email", "Campaign",
            "Product/Device","Store","Date","Amount","SKU/Model code","Pincode","Link","Coupon Code",
            "Additional Info1","Additional Info2",
            "LOB","Type","Sub Category","Sub sub category","Call Back Time","Disposition","Action Done",       "Customer Expectation", "user_remarks","created_at","created_by_id","created_by_name");
            break;

            case "CUG":
            $fields = array("Mobile No", "Customer NAME", "Customer Email", "Campaign",
            "Product/Device","Store","Date","Amount","SKU/Model code","Pincode","Link","Coupon Code",
            "Additional Info1","Additional Info2",
            "Final Disposition","L1", "L2","L3","Call Back Time","Pin code",
            "user_remarks","created_at","created_by_id","created_by_name"); 
            break;
        case "samsungIB":
            $fields = array("Mobile No", "Customer NAME", "Customer Email", "Campaign",
            "Product/Device","Store","Date","Amount","SKU/Model code","Pincode","Link","Coupon Code",
            "Additional Info1","Additional Info2",
            "Final Disposition IB","L1 IB","L2 IB","Call status", "Call sub status","Call Category",
            "user_remarks","created_at","created_by_id","created_by_name"); 
            break;
        default:
            $fields = array("Phone number", "Customer NAME", " Customer email", "Campaign",
            "Product/Device","Store","Date","Amount","SKU/Model code","Pincode","Link","Coupon Code",
            "Additional Info1","Additional Info2",
            "LOB","Type","Sub Category","Sub sub category","Call Back Time","Disposition","Action Done",       "Customer Expectation", "user_remarks","created_at","created_by_id","created_by_name");
            break;
    }
    fputcsv($f, $fields, $delimiter); 

// FOR ROWS
   switch($campaign){
       case "Happy Calling":
        while($row = $query->fetch_assoc()){ 
            $createByName = $row['first_name']." ".$row['last_name'];
            $lineData = array($row["mobile"], $row["name"], $row["email"], $row["campaignct"],
            $row['device'],  $row['store'], $row['created_customer_date'], $row['amount'], $row['sku'], 
            $row['pincode'], $row['link'], $row['coupon_code'], $row['addition_info1'], $row['addition_info2'],
            // HC
            $row['l_o_b'],$row['type'],$row['sub_category'],$row['sub_sub_category'], $row['call_back_time'],$row['disposition'], $row['action_done'], $row['customer_expectation'],
            $row["user_remarks"],$row['current_time'],$row['user_name'],$createByName); 
    
            fputcsv($f, $lineData, $delimiter); 
        } 
        break;

       case "CUG":
            while($row = $query->fetch_assoc()){ 
            $createByName = $row['first_name']." ".$row['last_name'];

            $lineData = array($row["mobile"], $row["name"], $row["email"], $row["campaignct"], 
            $row['device'],  $row['store'], $row['created_customer_date'], $row['amount'], $row['sku'], 
            $row['pincode'], $row['link'], $row['coupon_code'], $row['addition_info1'], $row['addition_info2'],
            // cug
            $row["final_disposition"], $row["l1"],$row['l2'],$row['l3'],$row['call_back_time'],
            $row['pin_code'],
            $row["user_remarks"],$row['current_time'],$row['user_name'],$createByName); 

            fputcsv($f, $lineData, $delimiter); 
        } 

        break;

       case "samsungIB":
            while($row = $query->fetch_assoc()){ 
            $createByName = $row['first_name']." ".$row['last_name'];

            $lineData = array($row["mobile"], $row["name"], $row["email"], $row["campaignct"], 
            $row['device'],  $row['store'], $row['created_customer_date'], $row['amount'], $row['sku'], 
            $row['pincode'], $row['link'], $row['coupon_code'], $row['addition_info1'], $row['addition_info2'],

            // IB
            $row["final_disposition_i_b"], $row["l1_i_b"],$row['l2_i_b'],$row['call_status'],
            $row['call_sub_status'], $row['call_category'],

            $row["user_remarks"],$row['current_time'],$row['user_name'],$createByName); 

            fputcsv($f, $lineData, $delimiter); 
          }
        break;
       default:
        while($row = $query->fetch_assoc()){ 
            $createByName = $row['first_name']." ".$row['last_name'];
            $lineData = array($row["mobile"], $row["name"], $row["email"], $row["campaignct"],
            $row['device'],  $row['store'], $row['created_customer_date'], $row['amount'], $row['sku'], 
            $row['pincode'], $row['link'], $row['coupon_code'], $row['addition_info1'],
            $row['addition_info2'], 
            // HC
            $row['l_o_b'],$row['type'],$row['sub_category'],$row['sub_sub_category'], $row['call_back_time'],$row['disposition'], $row['action_done'], $row['customer_expectation'],
            $row["user_remarks"],$row['current_time'],$row['user_name'],$createByName); 
    
            fputcsv($f, $lineData, $delimiter); 
        } 
        break;
   } 
// Common for all campaign
// Output each row of the data, format line as csv and write to file pointer 
    // while($row = $query->fetch_assoc()){ 
    //     $createByName = $row['first_name']." ".$row['last_name'];
    //     $lineData = array($row["mobile"], $row["name"], $row["email"], $row["campaign"], 
    //     // cug
    //     $row["final_disposition"], $row["l1"],$row['l2'],$row['l3'],$row['call_back_time'],$row['pin_code'],

    //     // HC
    //     $row['l_o_b'],$row['type'],$row['sub_category'],$row['sub_sub_category'],$row['disposition'],
    //     $row['action_done'], $row['customer_expectation'],    

    //     // IB
    //     $row["final_disposition_i_b"], $row["l1_i_b"],$row['l2_i_b'],$row['call_status'],
    //     $row['call_sub_status'], $row['call_category'],

    //     $row["user_remarks"],$row['current_time'],$row['user_name'],$createByName); 

    //     fputcsv($f, $lineData, $delimiter); 
    // } 
    
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
