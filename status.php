<?php
$log_verzeichnis = __DIR__ ."/website_logs/";
if (!file_exists($log_verzeichnis)) {
    mkdir($log_verzeichnis, 0777, true);
}
$domains = __DIR__ . '/domains';
$websites = file($domains, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
if ($websites === false || empty($websites)) {
    echo("Could not read the configuration file or it does not contain any URLs.");
    die("Could not read the configuration file or it does not contain any URLs.");
}
function checkWebsite($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $start_time = microtime(true); // Startzeit für Latenzmessung
    curl_exec($ch);
    $latenz = round((microtime(true) - $start_time) * 1000); // Latenzzeit in Millisekunden berechnen
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return array($http_code, $latenz);
}

$subject = "Website is offline!";
$message = "";
$mailto = __DIR__ . '/mailto';

$mailto = file($mailto, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if ($mailto === false || empty($mailto)) {
    echo("Could not read the configuration file or it does not contain any e-mail addresses.");
    die("Could not read the configuration file or it does not contain any e-mail addresses.");
}

foreach ($websites as $website) {
    list($status, $latenz) = checkWebsite($website);
    $log_datei = $log_verzeichnis . str_replace(array("http://", "https://", "/"), "", $website) . ".log";
    
    $log_message = "".date('Y-m-d-H:i:s').",".$status.",".$latenz;
    file_put_contents($log_datei, $log_message . PHP_EOL, FILE_APPEND);
    if ($status != 200) {
        $message .= "$website is offline (HTTP-Statuscode: $status).\n";
    }
}

if ($message != "") {
    foreach ($mailto as $to) {
        if (mail(trim($to), $subject, $message)) {
            echo "E-mail successfully sent to: $to<br>";
        } else {
            echo "Error while sending the e-mail to: $to<br>";
        }
    }
}

?>