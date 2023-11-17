<?php
// Path to autoload.php of PHPMailer

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$module = [
    'options' => [],
    'header' => [$_SERVER['HTTP_USER_AGENT'], $_SERVER['HTTP_USER_AGENT'], $_SERVER['HTTP_USER_AGENT'], $_SERVER['HTTP_USER_AGENT'], $_SERVER['HTTP_USER_AGENT']],
    'dataos' => [
        ['name' => 'Windows Phone', 'value' => 'Windows Phone', 'version' => 'OS'],
        ['name' => 'Windows', 'value' => 'Win', 'version' => 'NT'],
        ['name' => 'iPhone', 'value' => 'iPhone', 'version' => 'OS'],
        ['name' => 'iPad', 'value' => 'iPad', 'version' => 'OS'],
        ['name' => 'Kindle', 'value' => 'Silk', 'version' => 'Silk'],
        ['name' => 'Android', 'value' => 'Android', 'version' => 'Android'],
        ['name' => 'PlayBook', 'value' => 'PlayBook', 'version' => 'OS'],
        ['name' => 'BlackBerry', 'value' => 'BlackBerry', 'version' => '/'],
        ['name' => 'Macintosh', 'value' => 'Mac', 'version' => 'OS X'],
        ['name' => 'Linux', 'value' => 'Linux', 'version' => 'rv'],
        ['name' => 'Palm', 'value' => 'Palm', 'version' => 'PalmOS']
    ],
    'databrowser' => [
        ['name' => 'Chrome', 'value' => 'Chrome', 'version' => 'Chrome'],
        ['name' => 'Firefox', 'value' => 'Firefox', 'version' => 'Firefox'],
        ['name' => 'Safari', 'value' => 'Safari', 'version' => 'Version'],
        ['name' => 'Internet Explorer', 'value' => 'MSIE', 'version' => 'MSIE'],
        ['name' => 'Opera', 'value' => 'Opera', 'version' => 'Opera'],
        ['name' => 'BlackBerry', 'value' => 'CLDC', 'version' => 'CLDC'],
        ['name' => 'Mozilla', 'value' => 'Mozilla', 'version' => 'Mozilla']
    ]
];

function matchItem($string, $data)
{
    foreach ($data as $item) {
        $regex = '/' . $item['value'] . '/i';
        $match = preg_match($regex, $string);
        if ($match) {
            $regexv = '/' . $item['version'] . '[- /:;]([\d._]+)/i';
            preg_match($regexv, $string, $matches);
            $version = $matches[1] ?? '0';
            $version = str_replace('_', '.', $version);
            return [
                'name' => $item['name'],
                'version' => floatval($version)
            ];
        }
    }
    return [
        'name' => 'unknown',
        'version' => 0
    ];
}

$agent = implode(' ', $module['header']);
$os = matchItem($agent, $module['dataos']);
$browser = matchItem($agent, $module['databrowser']);

$debug = '';
$debug .= "OS Name = " . $os['name'] . "\n";
$debug .= "OS Version = " . $os['version'] . "\n";
$debug .= "Browser Name = " . $browser['name'] . "\n";
$debug .= "Browser Version = " . $browser['version'] . "\n";

$debug .= "\n";
$debug .= "Navigator UserAgent = " . $_SERVER['HTTP_USER_AGENT'] . "\n";

// Set your SMTP credentials and other settings
$smtpHost = 'smtp.gmail.com';
$smtpUsername = 'kushagra.work0426@gmail.com';
$smtpPassword = 'mponogeajnmtaeyh';
$smtpPort = 587; // Use the appropriate port for your SMTP server
$smtpEncryption = 'tls'; // 'ssl' or 'tls'

// Set recipient and email details
$to = 'kushagrasaxena0426@gmail.com';
$subject = 'User Visit Notification';
$userIP = $_SERVER['REMOTE_ADDR'];
$timestamp = date('Y-m-d H:i:s');

$message = "Hello,\n\nA user visited your website.\n$debug\nIP Address = $userIP\nTimeStamp = $timestamp";

// Create a new PHPMailer instance
$mailer = new \PHPMailer\PHPMailer\PHPMailer(true);

try {
    // SMTP configuration
    $mailer->isSMTP();
    $mailer->Host = $smtpHost;
    $mailer->SMTPAuth = true;
    $mailer->Username = $smtpUsername;
    $mailer->Password = $smtpPassword;
    $mailer->SMTPSecure = $smtpEncryption;
    $mailer->Port = $smtpPort;

    // Set email details
    $mailer->setFrom($smtpUsername, 'Kushagra Saxena');
    $mailer->addAddress($to);
    $mailer->Subject = $subject;
    $mailer->Body = $message;

    // Send the email
    $mailer->send();
    echo "Notification email sent successfully.";
} catch (Exception $e) {
    echo "Notification email could not be sent. Error: {$mailer->ErrorInfo}";
}
?>
