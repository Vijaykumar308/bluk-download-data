<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Report</title>
    <style>
        .search-panel {            
            text-align: center;
            font-family: sans-serif;
        }
        .myForm {
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            box-shadow: 1px 1px 4px 0px grey;
            padding: 43px;
        }
        input[type="date"]{
            padding: 5px 3px;
            font-size: 18px;
        }
        .myForm label{
            font-size: 21px;
        }
        .Button {
            background: #577fc0;
            padding: 12px 17px;
            border: none;
            border-radius: 5px;
            color: #fff;
            cursor: pointer;
        }

        .label-tag {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <div class="search-panel">
        <h1>Get Report</h1>

        <form method="POST" action="download_report.php" class="myForm">

            <div>
                <label style="font-size: 19px;"> Get Report: </label> 
                <select name="reportOf" style="padding: 5px 18px; font-size: 17px;">
                    <option value="--select--">--Select--</option>
                    <option value="vodafone">Vodafone Report</option>
                    <option value="ameyo">Ameyo Report</option>
                </select>
            </div>

            <div>
                <label for="from" class="label-tag">From</label>
                <input type="date" id="from" name="from" />
            </div>

            <div>
                <label for="from" class="label-tag">To</label>
                <input type="date" id="to" name="to" />
            </div>

            <div>
                <input type="submit" id="Button" value="Get Report" class="Button" />
            </div>
        </form>
    </div>
</body>
</html>