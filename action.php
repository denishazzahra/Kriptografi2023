<?php  
include('connect.php');
session_start();

if(isset($_POST['action'])){
    $action=$_POST['action'];
    if($action=='login'){
        $username=strtolower($_POST['username']);
        $password=$_POST['password'];
        $hashedUname=hash('sha256',$username);
        $hashedPW=hash('sha256',$password);
        $sql="SELECT * from user where username='$hashedUname' AND password='$hashedPW'";
        $query=mysqli_query($connect,$sql);
        if($query){
            $num=mysqli_num_rows($query);
            if($num!=0){
                $data=mysqli_fetch_array($query);
                $_SESSION['username']=$username;
                $_SESSION['id']=$data['id'];
                header('location:home.php');
            }else{
                header('location:index.php?message=wrong_info');
            }
        }else{
            header('location:index.php?message=error');
        }
    }else if($action=='register'){
        $action=$_POST['action'];
        $username=strtolower($_POST['username']);
        $password=$_POST['password'];
        $hashedUname=hash('sha256',$username);
        $hashedPW=hash('sha256',$password);
        $sql="SELECT username FROM user WHERE username='$hashedUname'";
        $query=mysqli_query($connect,$sql);
        if($query){
            $num=mysqli_num_rows($query);
            if($num!=0){
                header('location:register.php?message=username_taken');
            }else{
                $sql1="INSERT INTO user VALUES('','$hashedUname','$hashedPW')";
                $query1=mysqli_query($connect,$sql1);
                if($query1){
                    header('location:index.php?message=register_success');
                }
            }
        }else{
            header('location:register.php?message=error');
        }
    }else if($action=='add_event'){
        $receipt='';
        if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == UPLOAD_ERR_OK) {
            // File properties
            $file_name = $_FILES['receipt']['name'];
            $file_size = $_FILES['receipt']['size'];
            $file_tmp = $_FILES['receipt']['tmp_name'];
            $file_type = $_FILES['receipt']['type'];
            $acceptedTypes=['image/png','image/jpg','image/jpeg','image/webp'];
            // Get the file extension
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            echo $file_size;
            // Define accepted file extensions for images
            $acceptedExtensions = ['png', 'jpg', 'jpeg', 'webp'];
            // Check both file type and file extension
            if (!in_array($file_type, $acceptedTypes) || !in_array($file_ext, $acceptedExtensions)) {
                // Handle invalid file type or extension (e.g., display an error message)
                header('location:home.php?message=unsupported_type');
                exit();
            } else {
                $receipt = openssl_encrypt(base64_encode(file_get_contents($file_tmp)), $des, $key, 0, $des_iv);
            }
        }
        try {
            $name = $_POST['name'];
            $desc = $_POST['desc'];
            $amount = $_POST['amount'];
            $enc_name=superEncryption($name);
            $enc_desc=superEncryption($desc);
            $enc_amount=superEncryption($amount);

            $flow=$_POST['flow'];
            $date=$_POST['date'];
            $user_id=$_SESSION['id'];
            $sql="INSERT INTO cashflow VALUES('','$user_id','$enc_name','$enc_desc','$enc_amount','$flow','$receipt','$date')";
            $query=mysqli_query($connect,$sql);
            if($query){
                header('location:home.php?message=add_event_success');
            }else{
                header('location:home.php?message=add_event_failed');
            }
        } catch (Exception $e) {
            header('location:home.php?message=error_occured');
        }
    }else if($action=='edit_event'){
        $name = $_POST['name'];
        $desc = $_POST['desc'];
        $amount = $_POST['amount'];
        $enc_name=superEncryption($name);
        $enc_desc=superEncryption($desc);
        $enc_amount=superEncryption($amount);
        $flow=$_POST['flow'];
        $date=$_POST['date'];
        $id=$_POST['id'];
        $sql="UPDATE cashflow SET name='$enc_name', description='$enc_desc', amount='$enc_amount', flow='$flow', date='$date' WHERE id='$id'";
        $query=mysqli_query($connect,$sql);
        if($query){
            header('location:home.php?message=event_updated');
        }else{
            header('location:edit.php?id='.$event_id.'&message=update_failed');
        }
    }else if($action=='delete_receipt'){
        $event_id=$_POST['event_id'];
        $sql="UPDATE cashflow SET receipt='' WHERE id='$event_id'";
        $query=mysqli_query($connect,$sql);
        if($query){
            header('location:detail.php?id='.$event_id.'&message=delete_receipt_success');
        }else{
            header('location:detail.php?id='.$event_id.'&message=delete_receipt_failed');
        }
    }else if($action=='edit_receipt' || $action=='add_receipt'){
        $event_id=$_POST['event_id'];
        $receipt='';
        if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == UPLOAD_ERR_OK) {
            // File properties
            $file_name = $_FILES['receipt']['name'];
            $file_size = $_FILES['receipt']['size'];
            $file_tmp = $_FILES['receipt']['tmp_name'];
            $file_type = $_FILES['receipt']['type'];
            $acceptedTypes=['image/png','image/jpg','image/jpeg','image/webp'];
            // Get the file extension
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            echo $file_size;
            // Define accepted file extensions for images
            $acceptedExtensions = ['png', 'jpg', 'jpeg', 'webp'];
            // Check both file type and file extension
            if (!in_array($file_type, $acceptedTypes) || !in_array($file_ext, $acceptedExtensions)) {
                // Handle invalid file type or extension (e.g., display an error message)
                header('location:detail.php?id='.$event_id.'&message=unsupported_type');
                exit();
            } else {
                $receipt = openssl_encrypt(base64_encode(file_get_contents($file_tmp)), $des, $key, 0, $des_iv);
            }
        }
        try {
            $sql="UPDATE cashflow SET receipt='$receipt' WHERE id='$event_id'";
            $query=mysqli_query($connect,$sql);
            if($query){
                if($action=='add_receipt'){
                    header('location:detail.php?id='.$event_id.'&message=add_receipt_success');
                }else{
                    header('location:detail.php?id='.$event_id.'&message=edit_receipt_success');
                }
                
            }else{
                if($action=='add_receipt'){
                    header('location:detail.php?id='.$event_id.'&message=add_receipt_failed');
                }else{
                    header('location:detail.php?id='.$event_id.'&message=edit_receipt_failed');
                }
            }
        } catch (Exception $e) {
            header('location:detail.php?id='.$event_id.'&message=error_occured');
        }
    }else if($action=='delete_event'){
        $event_id=$_POST['event_id'];
        $sql="DELETE FROM cashflow WHERE id='$event_id'";
        $query=mysqli_query($connect,$sql);
        if($query){
            header('location:home.php?message=delete_event_success');
        }else{
            header('location:detail.php?id='.$event_id.'&message=delete_event_failed');
        }
    }
    else{
        header('location:home.php?message=access_denied');
    }
}else if(isset($_GET['action'])){
    $action=$_GET['action'];
    if($action=='logout'){
        session_destroy();
        header('location:index.php?message=logout_success');
    }
    else{
        header('location:home.php?message=access_denied');
    }
}else{
    header('location:home.php?message=access_denied');
}
?>