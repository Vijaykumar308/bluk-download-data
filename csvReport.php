<?php
    include "../dbconn.php";
    if($_COOKIE['auth-username'] != "admin"){
        die("Your don't have permission !");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" sizes="196x196" href="../../../../../client/img/favicon.ico">
    <title>Report</title>
    <!-- bootstrap and jquery link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <!-- jQuery UI cdn links  -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <!-- <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Josefin Sans', sans-serif;
        }

        @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400&display=swap');

        html {
            font-size: 62.5%;
        }
        .container{
            width: 100vw;
            height: 100vh;
            /* background-color: #ddd; */
            text-align: center;
        }
        .heading-h1{
            height: 20rem;
            line-height: 20rem;
            font-size: 5rem;
            /* background-color: red; */
        }
        .box{
            width: 50vw;
            height: 45vh;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
        }
        table{
            font-size: 2rem;
            width: 100%;
        }
        .input-date{
            padding: 0.5rem 1.6rem;
            margin: 2rem 0.5rem;
        }
        .btn{
            padding: 1rem 4rem;
            font-size: 1.7rem;
            background: none;
            border-radius: 0.5rem;
            margin-top: 2rem;
            background: #5de586;

        }
    </style> -->
    <script>
        $( function() {
            $( ".datepicker" ).datepicker({
                maxDate: new Date(),
                dateFormat: 'yy-mm-dd'
            });
        } );
  </script>
</head>
<body>
     <div class="container">
        <p style="width: 100%;padding: 0;margin-bottom: 20px;font-size: 21px;/*line-height: inherit; */
        color: #333;text-transform:uppercase;letter-spacing:1px;border: 0;border-bottom: 1px solid #e5e5e5;">Report</p>
        <form action="csvReportsBackend.php" method="post">
           <div class="row" style="display: flex; justify-content:center">
                <div class="col-md-3">
                    <label for="from" style="display:block;">From<span style="color:red;font-size:17px">*</span></label>
                    <!-- <input type="date" name="from" id="from" class="input-date"> -->
                    <input type="text" required autocomplete="off" placeholder="yyyy-mm-dd" name="from" class="datepicker" id="from">
                </div>

                <div class="col-md-3">
                <label for="to" style="display:block;">To<span style="color:red;font-size:17px">*</span></label>
                <!-- <input type="date" name="to" id="to" class="input-date"> -->
                <input type="text" placeholder="yyyy-mm-dd" required autocomplete="off" name="to" class="datepicker">
                
                </div>

                <div class="col-md-3">
                    <label for="campaign" style="display:block;">Campaign<span style="color:red;font-size:17px">*</span></label>
                    <select name="campaign" id="campaign" class="input-date" style="padding: 3px 2px;">
                        <option value="--Select--">--Select--</option>
                        <option value="Happy Calling">Happy Calling</option>
                        <option value="samsungIB">samsungIB</option>
                        <option value="CUG">CUG</option>
                        <option value="OOW">OOW</option>
                        <option value="Cart Drop">Cart Drop</option>
                        <option value="Payment Failure/Cancellation">Payment Failure/Cancellation</option>
                        <option value="BYOD">BYOD</option>
                        <option value="Flagship">Flagship</option>
                        <option value="Offline">Offline</option>
                        <option value="Click to Call">Click to Call</option>
                    </select>
                </div>
            </div>   
            <div class="row">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-primary" value="submit" name="submitBtn" style="margin-left: 13%;
    margin-top: 1%;">
                </div>
            </div>
        </form>
</body>
</html>