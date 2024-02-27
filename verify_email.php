<?php
session_start();
include 'koneksi.php';

// $token = $_GET['token'];

// if(isset($token)){
//     $qry = $koneksi->query("SELECT * FROM user WHERE verify_token='$token'");
//     $result = $qry->fetch_assoc();

//     $koneksi->query("UPDATE user SET verify_status=1 WHERE user_id='".$result['user_id']."'");
//     echo "<script>alert('Verifikasi berhasil! Silakan login!');window.location='user_login.php'</script>";
// }

if(isset($_GET['token']))
{
    $token = $_GET['token'];
    $verify_query = "SELECT verify_token, verify_status FROM user WHERE verify_token='$token' LIMIT 1";
    $verify_query_run = mysqli_query($koneksi, $verify_query);

    if(mysqli_num_rows($verify_query_run) > 0)
    {
        $row = mysqli_fetch_array($verify_query_run);
        if($row['verify_status'] == 0)
        {
            $clicked_token = $row['verify_token'];
            $update_query = "UPDATE user SET verify_status='1' WHERE verify_token='$clicked_token' LIMIT 1 ";
            $update_query_run = mysqli_query($koneksi, $update_query);

            if($update_query_run)
            {
                $_SESSION['status'] = "VERIFIKASI BERHASIL! SILAKAN LOGIN!";
                header("Location: user_login.php");
                exit(0);
            }
            else
            {
                $_SESSION['status'] = "VERIFIKASI GAGAL.";
                header("Location: user_login.php");
                exit(0);
            }
        }
        else
        {
            $_SESSION['status'] = "Email Already Verified. Please Login.";
            header("Location: user_login.php");
            exit(0);
        }
    }
    else
    {
        $_SESSION['status'] = "This Token  does not Exists.";
        header("Location: user_login.php");
    }
}
else
{
    $_SESSION['status'] = "Not Allowed";
    header("Location: user_login.php");
}

?>