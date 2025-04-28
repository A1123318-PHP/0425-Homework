<html>
    <head>
        <title>Success</title>
        <meta charset="utf-8">
    </head>
    <body>
        <?php
        $link = @mysqli_connect(
            'localhost',
            'root',
            '',
            'users'
        );
        mysqli_set_charset($link, 'utf8');

        $sql = "SELECT * FROM data";
        if($result = mysqli_query($link , $sql)){
            echo "<table border='1'>";
            echo "<tr><td>Name</td><td>Email</td><td>Photo</td></tr>";

            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>".$row['Name']."</td>";
                echo "<td>".$row['Email']."</td>";
                echo "<td>"."<img src='pic/".$row['Photo']."' width='200' height='200'></td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<input type='Button' value='返回' onclick=\"location.href='register.php'\">";
        }
        ?>
    </body>
</html>