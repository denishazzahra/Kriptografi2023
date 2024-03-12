<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo transparent.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
    <title>Sign Up</title>
</head>
<body>
    <?php
        // Check if the 'message' parameter is set to 'username_taken'
        if (isset($_GET['message'])) {
    ?>
    <div class="toast align-items-center position-fixed top-0 end-0 mt-2 me-2" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #23242c; color: white">
        <div class="d-flex">
            <div class="toast-body" style="display:flex; align-items:center;">
                <span class="material-symbols-outlined" style="margin-right:10px">error</span>
                <?php
                if($_GET['message'] === 'username_taken'){
                    echo "Username is taken!";
                }else if($_GET['message'] === 'error'){
                    echo "There was an internal error, please try again!";
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
    <div class="container-register">
        <h1 class="page-title secondary">Sign Up</h1><br>
        <form action="action.php" method="post">
            <input id="username" class="form-control secondary" name="username" type="text" placeholder="Username" aria-label="default input example" required>
            <p id="valid-uname-warning" style="font-size: 10pt; display:flex; align-items:center;"></p>
            <input id="password" class="form-control secondary" name="password" type="password" placeholder="Password" aria-label="default input example" required>
            <p id="valid-pw-warning" style="font-size: 10pt; display:flex; align-items:center;"></p>
            <input id="confirm_password" class="form-control secondary" name="confirm_password" type="password" placeholder="Confirm Password" aria-label="default input example" required>
            <p id="identical-pw-warning" style="font-size: 10pt; display:flex; align-items:center;"></p>
            <button id="submit-btn" class="btn btn-primary secondary" type="submit" name="action" value="register">Sign Up</button>
        </form>
        <center>
            <p style="font-size:14px;">Already have an account? <a href="index.php" style="color:#FFB3B3; font-weight:bold; text-decoration:none;">Login</a></p>
        </center>
    </div>
    <script>
        <!--
        let pw=false, confirm_pw=false, uname=false
        const username = document.getElementById('username')
        const password = document.getElementById('password')
        const confirm_password = document.getElementById('confirm_password')
        let button = document.getElementById('submit-btn')
        button.disabled=true
        let uname_warning = document.getElementById('valid-uname-warning')
        let valid_warning = document.getElementById('valid-pw-warning')
        let identical_warning = document.getElementById('identical-pw-warning')
        function isUsernameValid(username) {
            // Minimum length of 4 characters
            if (username.length < 4 || username.length > 20) {
                return false;
            }
            // Check if the username contains at least one alphanumeric character, dots, or underscores
            if (!/[a-zA-Z0-9]/.test(username)) {
                return false;
            }
            // Check if the username contains only alphanumerical characters, dots, or underscores
            if (!/^[a-zA-Z0-9._]+$/.test(username)) {
                return false;
            }
            // Check if the username doesn't consist solely of underscores or dots
            if (/^[_]+$/.test(username) || /^[.]+$/.test(username)) {
                return false;
            }
            // All checks passed, the username is valid
            return true;
        }
        function isStrongPassword(password) {
            // Minimum length of 8 characters
            if (password.length < 8) {
                return false;
            }
            // Check for at least one lowercase letter
            if (!/[a-z]/.test(password)) {
                return false;
            }
            // Check for at least one uppercase letter
            if (!/[A-Z]/.test(password)) {
                return false;
            }
            // Check for at least one number
            if (!/[0-9]/.test(password)) {
                return false;
            }
            // Check for at least one special character
            if (!/[^a-zA-Z0-9]/.test(password)) {
                return false;
            }
            // All checks passed, the password is strong
            return true;
        }
        function check_identical(){
            if(password.value!==confirm_password.value){
                identical_warning.innerHTML = `<span class="material-symbols-outlined" style="margin-right:10px">error</span>Password is not identical!`
                confirm_pw=false
            }else{
                identical_warning.innerHTML = ""
                confirm_pw=true
            }
        }
        function disableButton(){
            if(!pw || !confirm_pw || !uname){
                button.disabled=true
            }else{
                button.disabled=false
            }
        }
        username.addEventListener("input", (event) => {
            if(!isUsernameValid(username.value)){
                uname=false
                uname_warning.innerHTML = `<span class="material-symbols-outlined" style="margin-right:10px">error</span>Username should be 4-20 alphanumerical characters, dots (.), or underscores (_).`
            }else{
                uname_warning.innerHTML = ""
                uname=true
            }
        })
        password.addEventListener("input", (event) => {
            check_identical()
            if(!isStrongPassword(password.value)){
                valid_warning.innerHTML = `<span class="material-symbols-outlined" style="margin-right:10px">error</span>Password should be at least 8 character consisted of uppercase, lowercase, number, and symbol.`
                pw=false
            }else{
                valid_warning.innerHTML = ""
                pw=true
            }
            disableButton()
        });
        confirm_password.addEventListener("input", (event) => {
            check_identical()
            disableButton()
        });
        -->
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>