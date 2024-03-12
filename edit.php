<?php
include('connect.php');
session_start();
$event_id=$_GET['id'];
$sql="SELECT * FROM cashflow WHERE id='$event_id'";
$query=mysqli_query($connect,$sql);
$data=mysqli_fetch_array($query);
if(empty($_SESSION['username']) || $data['user_id']!=$_SESSION['id']){
    header('location:home.php?message=access_denied');
}
$name=$data['name'];
$desc=$data['description'];
$amount=$data['amount'];
$dec_name=superDecryption($name);
$dec_desc=superDecryption($desc);
$dec_amount=superDecryption($amount);
$flow=$data['flow'];
$date=$data['date'];
$income_select="";
$expense_select="";
if($flow=='Income'){
    $income_select="checked";
}else{
    $expense_select="checked";
}
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
    <title>Edit Event</title>
</head>
<body>
    <?php
        if (isset($_GET['message'])) {
    ?>
    <div class="toast align-items-center position-fixed bottom-0 end-0 mb-2 me-2" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #23242c; color: white">
        <div class="d-flex">
            <div class="toast-body" style="display:flex; align-items:center;">
                <?php
                if($_GET['message'] === 'update_failed'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."Update event failed!";
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
                    <li class="nav-item">
                        <a class="nav-link" href="home.php" style="display:flex; align-items:center;">
                            Home
                        </a>
                    </li>
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
    <br>
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6"><div class="container-content">
                <div class="header-content" style="display:flex; align-items:center; justify-content:space-between">
                    <a href="detail.php?id=<?=$event_id?>"><span class="material-symbols-outlined">arrow_back_ios</span></a>
                    <h2>Edit Event</h2>
                    <span class="material-symbols-outlined" style="color:#23242c">arrow_back_ios</span>
                </div>
                <br>
                <form action="action.php" method="post" enctype="multipart/form-data">
                    <label for="name" class="form-label">Event name</label><br>
                    <input id="name" class="form-control tertiary" name="name" type="text" value=<?=$dec_name?> aria-label="default input example" required><br>
                    <label for="desc" class="form-label">Description</label><br>
                    <textarea class="form-control tertiary" id="desc" name="desc" rows="3"><?=$dec_desc?></textarea><br>
                    <label for="amount" class="form-label">Amount</label><br>
                    <input id="amount" class="form-control tertiary" name="amount" value="<?=$dec_amount?>" type="number" aria-label="default input example" step="1" min="100" max="1000000000" required><br>
                    <label class="form-check-label">Flow</label><br>
                    <input class="form-check-input" type="radio" name="flow" id="flow1" value="Income" style="border-color:white; background-color:transparent; margin-right:10px" <?=$income_select?> required>
                    <label class="form-check-label" for="flow1">Income</label><br>
                    <input class="form-check-input" type="radio" name="flow" id="flow2" value="Expense" style="border-color:white; background-color:transparent; margin-right:10px" <?=$expense_select?> required>
                    <label class="form-check-label" for="flow2">Expense</label><br><br>
                    <label for="date" class="form-label">Date</label><br>
                    <input id="date" class="form-control tertiary" name="date" type="date" value=<?=$date?> aria-label="default input example" max="<?=date('Y-m-d')?>" required><br>
                    <input type="text" name="id" value="<?=$event_id?>" hidden>
                    <button class="btn btn-outline-info" style="color:white; width:100%; margin-bottom:15px" type="submit" name="action" value="edit_event">Save Changes</button>
                </form>
            <div class="col-3"></div>
        </div>
        <br><br>
    </div>
</body>
</html>