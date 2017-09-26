<?php

require "php/PHPMailer/class.phpmailer.php";

function sendEmail($data)
{
    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "chaloisaza@gmail.com"; 
    $mail->Password = "*3579510chalo!?*";

    //Set who the message is to be sent from
    $mail->setFrom('from@example.com', 'Sistema de facturacion');
    //Set an alternative reply-to address
    $mail->addReplyTo('replyto@example.com', 'Sistema de facturacion');

    //Set who the message is to be sent to
    $mail->addAddress('jisaza@ebfactory.com', '');

    //Set the subject line
    $mail->Subject = 'Recibo de factura del mes tal';

    //Attach an image file
    $mail->addAttachment($data);

    //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML("<p> Este es un mensaje de prueba. </p>");

    if (!$mail->send()) {
        return false;
    } else {
        return true;        
        //Section 2: IMAP
        //Uncomment these to save your message in the 'Sent Mail' folder.
        #if (save_mail($mail)) {
        #    echo "Message saved!";
        #}
    }
}