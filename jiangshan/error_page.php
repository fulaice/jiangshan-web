<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
</head>
<body>
    <h1>Error</h1>
    <p><?php echo $_SESSION['error']; ?></p>
    <p>按任意键返回上一页。</p>
    <script>
    document.body.addEventListener('keydown', function () {
        history.back();
    });
    </script>
</body>
</html>