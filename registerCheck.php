<!-- 
此作業需正確設定電子郵件帳號及應用程式密碼，否則將無法正常運作。
請依下列步驟操作：
1. 開啟專案根目錄下的 config.php 。
2. 將 mail_username 改為您的電子郵件帳號。
3. 將 mail_password 改為您的電子郵件服務提供的應用程式密碼。
-->

<html>
    <head>
        <meta charset="utf-8">
        <title>Register Check</title>
    </head>
    <body>
        <?php
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';
        
        $link = @mysqli_connect(
            'localhost',
            'root',
            '',
            'users'
        );
        mysqli_set_charset($link, 'utf8');

        $userName = $_POST["name"];
        $userEmail = $_POST["email"];
        $fileName = "pic\\" . $userName . ".png";
        $filePath = $userName . ".png";
        $config = require 'config.php';
        if ($config['mail_username'] === 'your_email@example.com') {
            echo "請先到 config.php 修改您的電子郵件帳號！";
            exit;
        }

        try{
            $sql = "INSERT INTO data (Name, Email, Photo) VALUES ('$userName', '$userEmail', '$filePath')";
            if(mysqli_query($link, $sql)){
                if(rename($_FILES["photo"]["tmp_name"],$fileName)) {
                    // Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                        //Server settings
                        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = $config['mail_username'];                     //SMTP username
                        $mail->Password   = $config['mail_password'];                     //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                        $mail->CharSet = "UTF-8";

                        //Recipients
                        $mail->setFrom($config["mail_username"], '0425 Homework Mailer');
                        // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
                        $mail->addAddress($userEmail);               //Name is optional
                        // $mail->addReplyTo('info@example.com', 'Information');
                        // $mail->addCC('cc@example.com');
                        // $mail->addBCC('bcc@example.com');

                        //Attachments
                        $mail->addAttachment($fileName);         //Add attachments
                        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = '恭喜註冊成功！';
                        $mail->Body = $userName . ' 恭喜註冊成功！<br>';
                        $mail->send();
                        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                    header("Location:registerSuccess.php");
                 }else{
                    echo "檔案上傳失敗<br/>";
                    header("Refresh:3; url='register.php'");
                 }
            }
        }catch(Exception $e){
            echo "註冊失敗，請重新註冊！<br/>";
            header("Refresh:3; url='register.php'");
        }
        ?>
    </body>
</html>