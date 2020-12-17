<?php

echo(" ");

// ouvre un fichier en mode binaire
$name = './images/MorseCode.jpg';
$fp = fopen($name, 'rb');

// envoie les bons en-têtes
header("Content-Type: image/jpeg");
header("Content-Length: " . filesize($name));

// envoie le contenu du fichier, puis stoppe le script
fpassthru($fp);
exit;

?>