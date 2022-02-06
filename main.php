<?php
require 'humanReadable.php';

$json = file_get_contents('contacts.json');

echo humanReadable($json);
