<?php  
include('connect.php');
session_start();
if(empty($_SESSION['username'])){
    header('location:index.php?message=access_denied');
}
date_default_timezone_set('Asia/Jakarta');
$user_id=$_SESSION['id'];

$sql1="SELECT amount FROM cashflow WHERE flow='income' AND user_id='$user_id'";
$query1=mysqli_query($connect,$sql1);
$num_income=mysqli_num_rows($query1);
$income=0;

$sql2="SELECT amount FROM cashflow WHERE flow='expense' AND user_id='$user_id'";
$query2=mysqli_query($connect,$sql2);
$num_expense=mysqli_num_rows($query2);
$expense=0;
if($num_income!=0){
    while($data1=mysqli_fetch_array($query1)){
        $encrypted_income=$data1['amount'];
        $decrypted_income=superDecryption($encrypted_income);
        $income+=(double) $decrypted_income;
    }
}
if($num_expense!=0){
    while($data2=mysqli_fetch_array($query2)){
        $encrypted_expense=$data2['amount'];
        $decrypted_expense=superDecryption($encrypted_expense);
        $expense+=(double) $decrypted_expense;
    }
}

$sql_monthly_income="SELECT amount FROM cashflow WHERE flow='income' AND user_id='$user_id' AND MONTH(date)=MONTH(NOW()) AND YEAR(date)=YEAR(NOW())";
$query_monthly_income=mysqli_query($connect,$sql_monthly_income);
$num_monthly_income=mysqli_num_rows($query_monthly_income);
$monthly_income=0;
if($num_monthly_income!=0){
    while($data_monthly_income=mysqli_fetch_array($query_monthly_income)){
        $encrypted_monthly_income=$data_monthly_income['amount'];
        $decrypted_monthly_income=superDecryption($encrypted_monthly_income);
        $monthly_income+=(double) $decrypted_monthly_income;
    }
}

$sql_monthly_expense="SELECT amount FROM cashflow WHERE flow='expense' AND user_id='$user_id' AND MONTH(date)=MONTH(NOW()) AND YEAR(date)=YEAR(NOW())";
$query_monthly_expense=mysqli_query($connect,$sql_monthly_expense);
$num_monthly_expense=mysqli_num_rows($query_monthly_expense);
$monthly_expense=0;
if($num_monthly_income!=0){
    while($data_monthly_expense=mysqli_fetch_array($query_monthly_expense)){
        $encrypted_monthly_expense=$data_monthly_expense['amount'];
        $decrypted_monthly_expense=superDecryption($encrypted_monthly_expense);
        $monthly_expense+=(double) $decrypted_monthly_expense;
    }
}

$filter="Filter";
if(isset($_GET['filter'])){
    $filter=ucfirst($_GET['filter']);
}
$balance=$income-$expense;
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo transparent.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <title>Home</title>
</head>
<body>
    <?php
        if (isset($_GET['message'])) {
    ?>
    <div class="toast align-items-center position-fixed bottom-0 end-0 mb-2 me-2" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #23242c; color: white">
        <div class="d-flex">
            <div class="toast-body" style="display:flex; align-items:center;">
                <?php
                if($_GET['message'] === 'add_event_failed'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."Add event failed!";
                }else if($_GET['message'] === 'add_event_success'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">check_circle</span>'."Add event success!";
                }else if($_GET['message'] === 'unsupported_type'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."Unsupported file type!";
                }else if($_GET['message'] === 'an_error_occured'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."An error occured!";
                }else if($_GET['message'] === 'event_updated'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">check_circle</span>'."Event updated successfully!";
                }else if($_GET['message'] === 'delete_event_success'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">check_circle</span>'."Event deleted successfully!";
                }else if($_GET['message'] === 'access_denied'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."Access denied!";
                }else if($_GET['message'] === 'file_too_big'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."File size exceeds the maximum allowed size (64 MB)!";
                }
                ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <script>
        <!--
        // Show the toast when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            var toast = new bootstrap.Toast(document.querySelector('.toast'));
            toast.show();
        });
        -->
    </script>
    <?php } ?>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #23242c;">
        <div class="container-fluid">
            <span class="navbar-brand"><img src="img/logo horizontal.png" alt="logo" style="height:32px"></span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item" style="float:right;">
                        <a class="nav-link" href="action.php?action=logout" style="display:flex; align-items:center;">
                            <span class="material-symbols-outlined">logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="card" style="width: 100%; background-color:#0077b6; color:white; height:100%">
                    <div class="card-body">
                        <h5 class="card-title">Balance</h5>
                        <p class="card-subtitle mb-2" style="font-size:10pt">Last updated: <?=date("d/m/Y h.i A")?></p>
                        <h3>Rp<?=number_format($income-$expense,2,",",".")?></h3>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card" style="width: 100%; background-color:#37897B; color:white; height:100%">
                    <div class="card-body">
                        <h5 class="card-title"><?=date("F ")?>Income</h5>
                        <p class="card-subtitle mb-2" style="font-size:10pt">Last updated: <?=date("d/m/Y h.i A")?></p>
                        <h3>Rp<?=number_format($monthly_income,2,",",".")?></h3>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card" style="width: 100%; background-color:#D86B6B; color:white; height:100%">
                    <div class="card-body">
                        <h5 class="card-title"><?=date("F ")?>Expense</h5>
                        <p class="card-subtitle mb-2" style="font-size:10pt">Last updated: <?=date("d/m/Y  h.i A")?></p>
                        <h3>Rp<?=number_format($monthly_expense,2,",",".")?></h3>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-7">
                <div id="cashflow" class="container-content" style="height:100%;">
                    <div id="content-header" class="content-header">
                        <div class="item-group" style="display:flex; width: 100%; align-items:center; justify-content:space-between">
                            <h2 class="page-title">Cashflow</h2>
                            <div class="dropdown">
                                <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?=$filter?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li><a class="dropdown-item" href="home.php">All</a></li>
                                    <li><a class="dropdown-item" href="home.php?filter=incomes">Incomes</a></li>
                                    <li><a class="dropdown-item" href="home.php?filter=expenses">Expenses</a></li>
                                </ul>
                            </div>
                        </div>
                        <br>
                    </div>
                    <div id="scrollable-container" class="scrollable" style=" height:100%; margin-right:-17px;">
                        <div class="scrollable-content" id="scrollable">
                        <?php
                        $sql3="SELECT * from cashflow where user_id='$user_id' ORDER BY date DESC";
                        if(isset($_GET['filter'])){
                            $new_filter=substr($filter, 0, -1);
                            $sql3="SELECT * from cashflow where flow='$new_filter' AND user_id='$user_id' ORDER BY date DESC";
                        }  
                        $query3=mysqli_query($connect,$sql3);
                        $count=mysqli_num_rows($query3);
                        if($count==0){
                            echo '<p style="font-size: 10pt;">No cashflow yet.</p>';
                        }else{
                            $i=0;
                            $prev_date="";
                            while($data3=mysqli_fetch_array($query3)){ 
                                $i+=1;
                                $dec_name=superDecryption($data3['name']);
                                $dec_amount=(double)superDecryption($data3['amount']);
                                $dec_desc=superDecryption($data3['description']);
                                if($data3['flow']=='Income'){
                                    $amount="+Rp".number_format($dec_amount,2,",",".");
                                    $color="#61D4C1";
                                }else{
                                    $amount="-Rp".number_format($dec_amount,2,",",".");
                                    $color="#FFB3B3";
                                }
                                if($data3['date']!=$prev_date && $i!=0){ ?>
                                    </table>
                                <?php }
                                if($data3['date']!=$prev_date){
                                    $timestamp = strtotime($data3['date']);
                                    $formattedDate = date('l, j F Y', $timestamp);
                                    ?>
                                    <h5><?=$formattedDate?></h5>
                                    <table class="table table-hover table-dark align-middle" style="--bs-table-bg: transparent !important; background-color:transparent; table-layout: fixed;">
                                <?php } ?>
                                    <tr onclick="window.location='detail.php?id=<?=$data3['id']?>';">
                                        <td style="width:56px"><img src="img/<?=$data3['flow']?>.png" style="width: 48px;"></td>
                                        <td style="text-overflow:ellipsis; overflow: hidden; white-space:nowrap; font-size: 10pt;">
                                            <h6 style="text-overflow:ellipsis; overflow: hidden; white-space:nowrap;"><?=$dec_name?></h6>
                                            <?=$dec_desc?>
                                        </td>
                                        <td style="text-align:right; width:175px; color:<?=$color?>"><?=$amount?></td>
                                    </tr>
                                <?php if($i==$count){ ?>
                                    </table>
                                <?php } 
                                $prev_date=$data3['date'];
                            }
                        } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5">
                <div class="container-content" id="add-event-form">
                    <h2 class="page-title tertiary">Add Event</h2><br>
                    <form action="action.php" method="post" enctype="multipart/form-data" onsubmit="return checkFileSize()">
                        <label for="name" class="form-label">Event name</label><br>
                        <input id="name" class="form-control tertiary" name="name" type="text" aria-label="default input example" required><br>
                        <label for="desc" class="form-label">Description</label><br>
                        <textarea class="form-control tertiary" id="desc" name="desc" rows="3"></textarea><br>
                        <label for="amount" class="form-label">Amount</label><br>
                        <input id="amount" class="form-control tertiary" name="amount" type="number" aria-label="default input example" step="1" min="100" max="1000000000" required><br>
                        <label class="form-check-label">Flow</label><br>
                        <input class="form-check-input" type="radio" name="flow" id="flow1" value="Income" style="border-color:white; background-color:transparent; margin-right:10px" required>
                        <label class="form-check-label" for="flow1">Income</label><br>
                        <input class="form-check-input" type="radio" name="flow" id="flow2" value="Expense" style="border-color:white; background-color:transparent; margin-right:10px" required>
                        <label class="form-check-label" for="flow2">Expense</label><br><br>
                        <label for="date" class="form-label">Date</label><br>
                        <input id="date" class="form-control tertiary" name="date" type="date" aria-label="default input example" max="<?=date('Y-m-d')?>" required><br>
                        <label for="receipt" class="form-label">Receipt</label><br>
                        <div class="input-group custom-file-button" id="receipt">
                            <label class="input-group-text" for="inputGroupFile" style="display:flex; align-items:center; height:100%;"><span class="material-symbols-outlined" style="color:black">attach_file</span></label>
                            <input type="file" name="receipt" class="form-control tertiary" id="inputGroupFile">
                        </div><br>
                        <button class="btn btn-primary tertiary" type="submit" name="action" value="add_event">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        <!--
        resizeDiv()
        window.onresize=function(event){
            resizeDiv()
        };
        function resizeDiv(){
            const myElement = document.getElementById('add-event-form')
            let elementHeight = myElement.clientHeight
            const cashflow = document.getElementById('cashflow')
            const contentHeader = document.getElementById('content-header')
            const scrollableContainer = document.getElementById('scrollable-container')
            const scrollable = document.getElementById('scrollable')

            cashflow.style.height=`${elementHeight}px`

            let cashflowHeight = Number(cashflow.clientHeight)
            let contentHeaderHeight = Number(contentHeader.clientHeight)
            let scrollableContainerHeight = cashflowHeight-contentHeaderHeight-80

            scrollableContainer.style.height = `${scrollableContainerHeight}px`

            let scrollableHeight = Number(scrollable.clientHeight)
            let scrollableScrollHeight = Number(scrollable.scrollHeight)

            if(scrollableScrollHeight > scrollableHeight){
                scrollableContainer.style.marginRight = '-17px'
            }else{
                scrollableContainer.style.marginRight = '0px'
            }
        }
        function checkFileSize() {
            const fileInput = document.getElementById('inputGroupFile');
            
            if (fileInput.files.length > 0) {
                let fileSize = fileInput.files[0].size; // in bytes
                let maxSize = 67108864;

                if (fileSize > maxSize) {
                    window.location.href = "home.php?message=file_too_big"
                    return false; // Prevent form submission
                }
            }

            return true; // Allow form submission
        }
        -->
    </script>
</body>
</html>