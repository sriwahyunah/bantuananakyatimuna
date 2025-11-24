<?php
session_start();
session_destroy();
header("Location: " . BASE_URL . "?hal=loginuser");
exit();
?>
```