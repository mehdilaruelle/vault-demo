<!-- ./php/index.php -->

<html>
    <head>
        <title>Hello World!</title>
    </head>

    <body>

    <h1>Hello World!</h1>
    Attempting MySQL connection from php...</br>
        <?php
            $host   = getenv('DB_HOST');
            $dbname = getenv('DB_NAME');
            $user   = getenv('DB_USER');
            $pass   = getenv('DB_PASSWORD');

            // Create connection
            $conn = new mysqli($host, $user, $pass, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
             }
             echo "Connected successfully.</br>";

            echo "</br>Data test into DB:<br>";
            if (!$conn->query("DROP TABLE IF EXISTS test") ||
                !$conn->query("CREATE TABLE test(id INT)") ) {
                echo "Fail to create table: (" . $conn->errno . ") " . $conn->error;
            }

            if (!$conn->query("INSERT INTO test(id) VALUES (1), (2), (3)")) {
                echo "Fail to insert into table: (" . $conn->errno . ") " . $conn->error;
            }

            if(! $res = $conn->query("SELECT id FROM test ORDER BY id ASC")) {
                echo "Fail to select ids in table: (" . $conn->errno . ") " . $conn->error;
            }

            for ($row_no = $res->num_rows - 1; $row_no >= 0; $row_no--) {
                $res->data_seek($row_no);
                $row = $res->fetch_assoc();
                echo " id = " . $row['id'] . "</br>";
            }
            ?>
    </body>
</html>
