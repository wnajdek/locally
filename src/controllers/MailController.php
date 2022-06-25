<?php

require_once 'AppController.php';
require_once('vendor/autoload.php');
require_once "config.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


class MailController extends AppController
{
    private $messages = [];

    private $mail;

    public function __construct()
    {
        parent::__construct();
        $this->mail = new PHPMailer(true);
    }


    public function contact() {
        session_start();

        if (!isset($_SESSION['userId'])) {
            $this -> render('login', ['messages' => ['You have to log in first.']]);
        }

        $this -> render('contact', ['email' => $_SESSION['userEmail']]);
    }

    public function mail()
    {
        session_start();

        if (!isset($_SESSION['userId'])) {
            $this -> render('login', ['messages' => ['You have to log in first.']]);
        }

        if ($this->isPost()) {
            $this->sendMail();
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/market");

    }

    private function sendMail() {
        $this->mail->isSMTP();                      // Set mailer to use SMTP
        $this->mail->Host = 'smtp.gmail.com';       // Specify main and backup SMTP servers
        $this->mail->SMTPAuth = true;               // Enable SMTP authentication
        $this->mail->Username = MAIL_USERNAME;   // SMTP username
        $this->mail->Password = MAIL_PASSWORD;   // SMTP password
        $this->mail->SMTPSecure = 'tls';            // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port = 587;                    // TCP port to connect to

        // Sender info
        $this->mail->setFrom($_POST['email'], 'Locally User');
//        $this->mail->setFrom('user@example.com', 'Mailer');
//        $this->mail->From = 'user@example.com';
//        $this->mail->FromName = 'Locally User';

//        $this->mail->addReplyTo('locally.contact.mail@gmail.com'', 'Locally User');

        // Add a recipient
        $this->mail->addAddress('locally.contact.mail@gmail.com');

        // Set email format to HTML
        $this->mail->isHTML(true);

        // Mail subject
        $this->mail->Subject = 'Email from Localhost by Locally User';

        // Mail body content
        $bodyContent = '<h3>' . $_POST['topic'] . '</h3>';
        $bodyContent .= '<p>' . $_POST['message'] . '</p>';
        $bodyContent .= '<p>This HTML email is sent from the localhost server using PHP by <b>' . $_POST['email'] . '</b></p>';
        $this->mail->Body = $bodyContent;

        $this->mail->send();

//        // Send email
//        try {
//            if (!$this->mail->send()) {
//                echo 'Message could not be sent. Mailer Error: ' . $this->mail->ErrorInfo;
//            } else {
//                echo 'Message has been sent.';
//            }
//        } catch (Exception $e) {
//            echo 'Message could not be sent. Mailer Error: ', $this->mail->ErrorInfo;
//        }
    }

}