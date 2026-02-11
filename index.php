<?php
  // This is where your PHP logic goes
  $greeting = "Hello, Eunoiaverse!";
  $year = date("2026/02/11");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eunoiaverse</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f4f4f9; }
        .card { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); text-align: center; }
    </style>
</head>
<body>
    <div class="card">
        <h1><?php echo $greeting . " Hello, Eunoiaverse!"; ?></h1>
        <p>PHP server is running successfully.</p>
        <p>&copy; <?php echo $year; 2026/02/11?></p>
    </div>
</body>
</html>