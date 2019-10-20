<?php
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
            $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = trim($_POST["email"]);
        $phone = trim($_POST["phone"]);
        $qusetion = trim($_POST["question"]);
        $hid = trim($_POST["hid"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($phone)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Пожалуйста, заполните форму заново и попробуйте еще раз.";
            exit;
        }
        
        //Phone validation
        if(!preg_match("/^[0-9]{10,11}+$/", $_POST['phone'])) {
            echo "Телефон задан в неверном формате. Пожалуйста, введите номер начиная с 7 или 8";
            exit;
        }
        $first = substr($_POST['phone'], 0,1);
        if(($first != '7')&&($first != '8')) {
            echo "Ваш номер телефона начинается не на 7 или 8";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "fish74@mail.ru";    // Replace the email address with your email where you want to send message.

        // Set the email subject.
        $subject = "$hid";

        // Build the email content.
        $email_content = "На сайте Iron-brother оставлена новая заявка: \n\n";
        $email_content .= "Имя клиента: $name \n";
        $email_content .= "Email: $email \n";
        $email_content .= "Имя клиента: $phone \n";
        $email_content .= "Вопрос: $question \n\n";

        // Build the email headers.
        $email_headers = "From: pk.muravei.kz <info@pk.muravei.kz> \r\n";
        //$email_headers .= "Reply-To: ".$name." <".$phone.">\r\n";
         
        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Ваше сообщение отправлено. Спасибо!";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Упс! Что-то пошло не так и мы не смогли отправить Ваше сообщение.";
        }   

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Проблема с Вашим представлением, попробуйте еще раз.";
        
    }

?>

    