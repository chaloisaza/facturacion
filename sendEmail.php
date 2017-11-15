<?php

require "php/PHPMailer/class.phpmailer.php";

function sendEmail($data)
{
    $mail = new PHPMailer;
    $mail->IsSMTP();
    $mail->Host = 'mail.ebfactory.com';
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 4;
    $mail->Port = 25;
    $mail->SMTPSecure = 'none';
    $mail->SMTPAuth = true;
    $mail->Username = "jisaza@ebfactory.com"; 
    $mail->Password = "Jisaza2017";

    //Set who the message is to be sent from
    $mail->setFrom('jisaza@ebfactory.com', 'Sistema de facturacion');
    //Set an alternative reply-to address
    $mail->addReplyTo('jisaza@ebfactory.com', 'Sistema de facturacion');

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