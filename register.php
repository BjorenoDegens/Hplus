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
                    <a href="login.php" class="navbar-text">Login <i class="fas fa-user"></i></a>
                </p>
            </div>
        </nav>
    </div>
</header>
<main>
    <div class="container pt-5">
        <form class="form" method="post" action="">
            <div class="form-group">
                <label for="username">Naam:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Wachtwoord:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" class="form-control" id="age" name="age" required min="0">
            </div>
            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Register</button>
        </form>
    </div>
</main>
</body>
</html>
