<?php

$password = "TestPassword123";
$hash = password_hash($password, PASSWORD_BCRYPT);

// Display the hash
echo $hash;
?>
