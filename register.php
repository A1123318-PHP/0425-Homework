<html>
    <head>
        <meta charset="utf-8">
        <title>Register</title>
    </head>
    <body>
        <form action = "registerCheck.php" method = "post" enctype="multipart/form-data">
            Name: <input type = "text" name = "name" required><br>
            Email: <input type = "email" name = "email" required><br>
            Photo: <input type = "file" name = "photo" accept = "image/*" required><br>
            <input type = "submit">
        </form>
    </body>
</html>