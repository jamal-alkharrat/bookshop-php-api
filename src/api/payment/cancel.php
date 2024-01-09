<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cancel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<div class="container">
        <div class="py-5 text-center">
            <h2>Bookstore</h2>
            <p class="lead">Payment process was canceled.</p>
        </div>

        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">User Details</h4>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">User ID</h6>
                        </div>
                        <span class="text-muted"><?php echo $_GET['user_id']; ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">Stripe Session ID</h6>
                        </div>
                        <span class="text-muted"><?php echo $_GET['session_id']; ?></span>
                    </li>
                </ul>
                <a href="http://localhost:3000" class="btn btn-primary btn-lg btn-block">Back to shop</a>
            </div>
        </div>
    </div>
    <?php
    # Redirect to shop after 10 seconds
    require_once '../../admin/config.php';
    header("refresh:10;url=".BASE_URL."/");
    ?>
    <p id="countdown" class="text-center">Redirecting in 10 seconds...</p>
    <script>
        var timeleft = 10;
        var countdownTimer = setInterval(function(){
            document.getElementById("countdown").innerHTML = "Redirecting in " + timeleft + " seconds...";
            timeleft -= 1;
            if(timeleft <= 0){
                clearInterval(countdownTimer);
                document.getElementById("countdown").innerHTML = "Redirecting..."
            }
        }, 1000);
    </script>
</body>
</html>