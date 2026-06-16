<?php
session_start();
session_destroy();

header("Location: dashboard_nasabah.php");
exit;