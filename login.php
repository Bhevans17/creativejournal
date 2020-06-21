<?php session_start(); ?>
<?php include "db.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Bloggr</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="create_account.php">Create Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
            </div>
        </div>
    </nav>
    <?php
    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $stmt = $pdo->prepare("SELECT username, password FROM user WHERE username=?");
        $stmt->execute([$username]);
        if ($user = $stmt->fetch()) {
            if (password_verify($password, $user["password"])) {
                $_SESSION["user"] = $username;
                header("location: dashboard.php");
            }
        } else {
            echo "<script>";
            echo "setTimeout(function () {
                let postCreated = document.getElementById('post-created');
                postCreated.style.display = 'none';
              }, 2000);
              ";
            echo "</script>";
            echo "<div id='post-created' class='alert alert-danger'><div class='container'>Wrong Credentials</div></div>";
        }
    }

    ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <h1>Login</h1>
                <form class="mt-3" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="username">Enter Username</label>
                        <input id="username" name="username" type="text" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Enter Password</label>
                        <input id="password" name="password" type="password" class="form-control" required>
                    </div>
                    <input class="btn btn-success btn-block" type="submit">
                </form>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>

</html>