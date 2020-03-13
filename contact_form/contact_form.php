<?php

// configure
$from = 'Contact form <jerome.le.champion@gmail.com>';
$sendTo = 'jerome.le.champion@gmail.com';
$subject = 'Nouveau message de contact via Site Web';
$fields = array('name' => 'Name', 'email' => 'Email', 'message' => 'Message'); // array variable name => Text to appear in the email
$okMessage = 'Votre demande de contact a bien été prise en compte, je reviendrais vers vous dès que possible !';
$errorMessage = 'Une erreur est survenue durant l\'envoie du formulaire, veuillez me contacter directement à l\'adresse : jerome.le.champion@gmail.com';

// let's do the sending

try
{
    $emailText = nl2br("You have new message from Contact Form\n");

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= nl2br("$fields[$key]: $value\n");
        }
    }

    $headers = array('Content-Type: text/html; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
