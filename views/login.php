<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script defer src="../assets/js/login.js"></script> 
</head>
<body>
    <form id="loginForm">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <a href="index.html" class="">
                <h3 class="text-primary"><i class="fa fa-truck me-2"></i>LogistikQ</h3>
            </a>
            <h3>Sign In</h3>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="username" placeholder="Username">
            <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating mb-4">
            <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <a href="">Forgot Password</a>
        </div>
        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
        <p class="text-center mb-0">Don't have an Account? <a href="register.php">Sign Up</a></p>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
