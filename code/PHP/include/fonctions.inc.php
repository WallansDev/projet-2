<?php

// function my_autoloader($class)
// {
//     include './classes/' . $class . '.class.php';
// }

// spl_autoload_register('my_autoloader');

function alertBox($couleur, $message, $link, $time)
{
    echo ("<div class='alert alert-$couleur' role='alert'>$message</div>");
    if (strlen($link) > 1 && strlen($time) > 1) {
        echo ("<script>setTimeout(function() { window.location.href = './$link';}, $time);</script>");
    }
}

function Logs($message)
{
    $date = new DateTime();
    $file = "logs.log";
    $heure = $date->format("h:i:s");
    $date = $date->format("y:m:d");
    $timestamp = strtotime($date);
    $date = date('d/m/Y', $timestamp);

    $text = file($file, FILE_IGNORE_NEW_LINES);

    array_unshift($text, "[" . $date . " " . $heure . "] " . $message . "\n");

    file_put_contents($file, implode(PHP_EOL, $text) . PHP_EOL);
}
