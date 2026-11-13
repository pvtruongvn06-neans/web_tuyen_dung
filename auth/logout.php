<?php
require_once __DIR__ . '/../includes/functions.php';

session_destroy();
header("Location: ../candidate/index.php");
exit;