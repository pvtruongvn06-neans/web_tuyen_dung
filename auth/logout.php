<?php
require_once '../includes/functions.php';

session_destroy();
header("Location: ../candidate/index.php");
exit;