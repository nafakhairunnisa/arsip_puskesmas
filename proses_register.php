<?php
session_start();
include 'koneksi.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if(isset($_POST['register_btn']))
{
    $nama = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $salt = bin2hex(random_bytes(16)); // Menghasilkan salt acak
    $token = hash('sha256', $salt.$email.date('Y-m-d H:i:s'));

    // Mengecek email
    $check_email_query = "SELECT user_email FROM user WHERE user_email='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($koneksi, $check_email_query);

    if(mysqli_num_rows($check_email_query_run) > 0)
    {
        header("location:registrasi.php?alert=gagal");
    }
    elseif($check_email_query_run === false) {
        die("Query error: " . mysqli_error($koneksi));
    }
    else
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'nkhairunn2412@gmail.com';                     //SMTP username
            $mail->Password   = 'mczwovrjktpqgxau';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('nkhairunn2412@gmail.com', 'Verifikasi Akun');
            $mail->addAddress($email, $nama);     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Verifikasi Akun E-Arsip Puskesmas Panyileukan';
            $email_template = "
                    <h2>Halo $nama,</h2><br />
                    Terima kasih telah mendaftar di e-Arsip Puskesmas Panyileukan.        
                    Untuk menyelesaikan proses pendaftaran dan mengaktifkan akun Anda, silakan klik link verifikasi di bawah ini:<br />
                    
                    <a href='http://localhost/arsip_puskesmas/verify_email.php?token=$token'>Verifikasi Akun</a><br />
                    
                    Terima kasih,<br />
                    Tim e-Arsip Puskesmas Panyileukan<br />";
            $mail->Body    = $email_template;
            
            if($mail->send()){
                $koneksi->query("INSERT INTO user(user_nama, user_email, user_password, verify_token)VALUES('$nama', '$email', '$password', '$token')");
                
                header("location:registrasi.php?alert=sukses");
            }
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>