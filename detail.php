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
$user_id=$_SESSION['id'];
$flow=$data['flow'];
$dec_name=superDecryption($data['name']);
$dec_desc=superDecryption($data['description']);
$dec_amount=superDecryption($data['amount']);
$binaryImageData = openssl_decrypt($data['receipt'],$des,$key,0,$des_iv);
$timestamp = strtotime($data['date']);
$formattedDate = date('l, j F Y', $timestamp);
$color;
$amount;
if($flow=='Income'){
    $amount="+Rp".number_format($dec_amount,2,",",".");
    $color="#61D4C1";
}else{
    $amount="-Rp".number_format($dec_amount,2,",",".");
    $color="#FFB3B3";
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
    <title>Event Detail</title>
</head>
<body>
    <?php
        if (isset($_GET['message'])) {
    ?>
    <div class="toast align-items-center position-fixed bottom-0 end-0 mb-2 me-2" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #23242c; color: white">
        <div class="d-flex">
            <div class="toast-body" style="display:flex; align-items:center;">
                <?php
                if($_GET['message'] === 'delete_receipt_success'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">check_circle</span>'."Receipt deleted successfully!";
                }else if($_GET['message'] === 'delete_receipt_failed'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."Delete receipt failed!";
                }else if($_GET['message'] === 'unsupported_type'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."Unsupported file type!";
                }else if($_GET['message'] === 'add_receipt_success'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">check_circle</span>'."Add receipt success!";
                }else if($_GET['message'] === 'edit_receipt_success'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">check_circle</span>'."Receipt updated successfully!";
                }else if($_GET['message'] === 'add_receipt_failed'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."Add receipt failed!";
                }else if($_GET['message'] === 'edit_receipt_failed'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."Update receipt failed!";
                }else if($_GET['message'] === 'error_occured'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."An error occured!";
                }else if($_GET['message'] === 'delete_event_failed'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."Delete event failed!";
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
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col 3"></div>
            <div class="col-6">
                <div class="container-content">
                    <center>
                        <img src="img/<?=$flow?>.png" style="width:48px"><br><br>
                        <h4 style="color:<?=$color?>"><?=$amount?></h2>
                        <h6><?=$dec_name?></h4><hr>
                    </center>
                    <h6>Detail</h6>
                    <table class="table-secondary" style="width:100%; vertical-align:top">
                        <tr>
                            <td>Flow</td>
                            <td style="text-align:right"><?=$flow?></td>
                        </tr>
                        <tr>
                            <td>Date</td>
                            <td style="text-align:right"><?=$formattedDate?></td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td style="text-align:right"><?=$dec_desc?></td>
                        </tr>
                    </table>
                    <hr>
                    <table style="width:100%">
                        <tr>
                            <td><h6>Total</h6></td>
                            <td style="text-align:right"><h6><?=substr($amount,1)?></h6></td>
                        </tr>
                    </table>
                    <br>
                    <button class="btn btn-outline-light" style="width:100%" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Show Receipt</button>
                    <br><br>
                    <div class="row">
                        <div class="col-6"><a href="edit.php?id=<?=$event_id?>" class="btn btn-outline-info" style="width:100%; color:white;">Edit</a></div>
                        <div class="col-6">
                            <button class="btn btn-outline-danger" style="width:100%; color:white;" data-bs-toggle="modal" data-bs-target="#staticBackdrop3">Delete</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color:#23242c;">
                <div class="modal-header" style="border-color:#23242c">
                    <h6 class="modal-title fs-5" id="staticBackdropLabel">Receipt</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    if($binaryImageData!=""){ ?>
                        <img src="data:image/png;base64,<?=$binaryImageData?>" alt="Image" style="width:100%"><br><br>
                        <div class="container" style="width:100%; padding:0;">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-info" style="width:100%; color:white; margin-bottom:15px" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">Edit</button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-outline-danger" style="width:100%; color:white; margin-bottom:15px" data-bs-toggle="modal" data-bs-target="#staticBackdrop1">Delete</button>
                                </div>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <form action="action.php" method="post" class="w-100"  enctype="multipart/form-data" onsubmit="return checkFileSizeAdd()">
                            <input type="text" name="event_id" value="<?=$event_id?>" hidden>
                            <label for="receipt" class="form-label">Receipt</label><br>
                            <div class="input-group custom-file-button" id="receipt">
                                <label class="input-group-text" for="inputGroupFile" style="display:flex; align-items:center; height:100%;"><span class="material-symbols-outlined" style="color:black">attach_file</span></label>
                                <input type="file" name="receipt" class="form-control tertiary" id="inputGroupFile" required>
                            </div><br>
                            <button class="btn btn-outline-light" style="width:100%; margin-bottom:15px;" type="submit" name="action" value="add_receipt">Add Receipt</button>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color:#23242c;">
                <div class="modal-header" style="border-color:#23242c">
                    <h6 class="modal-title fs-5" id="staticBackdropLabel">Delete Receipt</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the receipt? You can't undo your action after you click delete.
                </div>
                <div class="modal-footer" style="border-color:#23242c">
                    <div class="container" style="width:100%; padding:0;">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-secondary" style="width:100%;" data-bs-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-6">
                                <form action="action.php" method="post" class="w-100">
                                    <input type="text" name="event_id" value="<?=$event_id?>" hidden>
                                    <button type="submit"  name="action" class="btn btn-danger" style="width:100%;" value="delete_receipt">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color:#23242c;">
                <div class="modal-header" style="border-color:#23242c">
                    <h6 class="modal-title fs-5" id="staticBackdropLabel">Edit Receipt</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="action.php" method="post" class="w-100" enctype="multipart/form-data" onsubmit="return checkFileSizeEdit()">
                        <input type="text" name="event_id" value="<?=$event_id?>" hidden>
                        <label for="receipt" class="form-label">Receipt</label><br>
                        <div class="input-group custom-file-button" id="receipt">
                            <label class="input-group-text" for="inputGroupFile" style="display:flex; align-items:center; height:100%;"><span class="material-symbols-outlined" style="color:black">attach_file</span></label>
                            <input type="file" name="receipt" class="form-control tertiary" id="inputGroupFile1" required>
                        </div><br>
                        <button class="btn btn-outline-info" style="width:100%; margin-bottom:15px; color:white" type="submit" name="action" value="edit_receipt">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color:#23242c;">
                <div class="modal-header" style="border-color:#23242c">
                    <h6 class="modal-title fs-5" id="staticBackdropLabel">Delete Event</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this event? You can't undo your action after you click delete.
                </div>
                <div class="modal-footer" style="border-color:#23242c">
                    <div class="container" style="width:100%; padding:0;">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-secondary" style="width:100%;" data-bs-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-6">
                                <form action="action.php" method="post" class="w-100">
                                    <input type="text" name="event_id" value="<?=$event_id?>" hidden>
                                    <button type="submit" name="action" class="btn btn-danger" style="width:100%;" value="delete_event">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        <!--
        const myModal = document.getElementById('myModal')
        const myInput = document.getElementById('myInput')

        myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus()
        })

        function checkFileSizeEdit() {
            const fileInput1 = document.getElementById('inputGroupFile1');
            return checkFileSize(fileInput1);
        }

        function checkFileSizeAdd() {
            const fileInput = document.getElementById('inputGroupFile');
            return checkFileSize(fileInput);
        }

        function checkFileSize(fileInput) {
            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id');
            const maxSize = 67108864; // 64 MB
            if (fileInput.files.length > 0) {
                const fileSize = fileInput.files[0].size;
                if (fileSize > maxSize) {
                    window.location.href = `detail.php?id=${id}&message=file_too_big`
                    return false; // Prevent form submission
                }
            }
            return true; // Allow form submission
        }
        -->
    </script>
</body>
</html>