<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo transparent.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <title>Login</title>
</head>
<body>
    <?php
        // Check if the 'message' parameter is set to 'username_taken'
        if (isset($_GET['message'])) {
    ?>
    <div class="toast align-items-center position-fixed top-0 end-0 mt-2 me-2" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #23242c; color: white">
        <div class="d-flex">
            <div class="toast-body" style="display:flex; align-items:center;">
                <?php
                if($_GET['message'] === 'wrong_info'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."Wrong username or password!";
                }else if($_GET['message'] === 'error'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."There was an internal error, please try again!";
                }else if($_GET['message'] === 'access_denied'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">error</span>'."Access denied, please login first!";
                }else if($_GET['message'] === 'logout_success'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">check_circle</span>'."Logout success!";
                }else if($_GET['message'] === 'register_success'){
                    echo '<span class="material-symbols-outlined" style="margin-right:10px">check_circle</span>'."Sign up success!";
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
    <div class="container-login">
        <div class="container" style="width:100%; margin:0">
            <div class="row">
                <div class="col-7">
                    <h1 class="page-title">Login</h1><br>
                    <form action="action.php" method="post">
                        <label for="text-box 1" class="form-label">Username</label><br>
                        <input id="text-box 1" class="form-control" name="username" type="text" aria-label="default input example" required><br>
                        <label for="text-box 2" class="form-label">Password</label><br>
                        <input id="text-box 2" class="form-control" name="password" type="password" aria-label="default input example"required><br>
                        <button class="btn btn-primary" type="submit" name="action" value="login">Login</button>
                    </form>
                    <center>
                        <p style="font-size:14px;">Don't have an account yet? <a href="register.php" style="color:#53BAA9; font-weight:bold; text-decoration:none;">Sign Up</a></p>
                    </center>
                </div>
                <div class="col-5">
                    <div style="display:flex; height:100%; align-items:center; justify-content:center;">
                        <img src="img/logo full.png" alt="logo" style="width:90%">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>