<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Authorization User</title>
    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="ajax.js"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid d-flex align-items-center flex-column vh-100">
        <noscript>
            <p class="mt-3">You cannot login without javascript enabled.</p>
        </noscript>
        <div class="hello_user"></div>
        <div id="form" style="display: none">
            <h3 class="mt-4 mb-4">Authorization User</h3>
            <div class="bg-dark p-3 rounded">
                <div class="exception d-flex flex-column"></div>
                <form class="d-flex flex-column" id="formAuth" action="" method="post" onsubmit="return false;">
                    <label class="text-info" for="login">Login:</label>
                    <input class="m-2 ms-0" type="text" placeholder="Login" id="login" name="login" required>
                    <label class="text-info" for="password">Password:</label>
                    <input class="m-2 ms-0" type="password" placeholder="Password" id="password" name="password" required>
                    <input class="btn btn-info m-2 ms-0" type="submit" value="Sign In" onclick="signIn()">
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        document.getElementById('form').style.display = 'block';
    </script>
</body>
</html>