<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Hplus</title>
</head>
<body class="login">
<header>
    <div class="full-container">
        <nav class="navbar" id="nav">
            <a class="navbar-brand" href="index.php"><img src="img/Hplus_logo.png" alt="Hplus_logo"></a>

            <div class="ml-auto pr-5">
                <p class="d-inline-block mr-3">
                    <a href="index.php" class="navbar-text">Home <i class="fas fa-user"></i></a>
                </p>
                <p class="d-inline-block">
                    <a href="register.php" class="navbar-text">Register <i class="fas fa-user"></i></a>
                </p>
            </div>
        </nav>
    </div>
</header>
<main>
    <div class="container pt-5">
        <form class="form" method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group pt-2">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary pt-2" name="submit">Login</button>

            <div class="pt-3">
                <p>
                    Maak <a href="register.php"><b>HIER</b></a> een account aan!
                </p>
            </div>
        </form>
    </div>
</main>
</body>
</html>
