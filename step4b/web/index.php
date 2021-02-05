<!-- ./web/index.php -->

<html>
    <head>
        <title>Hello World!</title>
    </head>

    <body>

    <h1>Hello World!</h1>
    Attempting MySQL connection from php...</br>
        <?php
            if (file_exists("/var/www/secrets.json")) {
              $secrets_json = file_get_contents("/var/www/secrets.json", "r");
              $user = json_decode($secrets_json)->{'username'};
              $pass = json_decode($secrets_json)->{'password'};
            }
            else{
              echo "Secrets not found.";
              exit;
            }

            $vlt_url        = getenv('VAULT_ADDR');
            $vlt_path       = getenv('VAULT_PATH');
            $host           = getenv('DB_HOST');
            $dbname         = getenv('DB_NAME');

            if (file_exists("/var/www/.vault-token")) {
              $token = file_get_contents("/var/www/.vault-token", "r");
            }
            else{
              echo "Token not found.";
              exit;
            }

            echo "Using database user: <b>".$user."</b></br>";

            // Create connection
            $conn = new mysqli($host, $user, $pass, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
             }
             echo "Connected successfully.</br>";

            echo "</br>Data test into DB:<br>";
            if (!$conn->query("DROP TABLE IF EXISTS test") ||
                !$conn->query("CREATE TABLE test(id INT, value VARCHAR(255))") ) {
                echo "Fail to create table: (" . $conn->errno . ") " . $conn->error;
            }

            echo "Encrypt value from Vault...</br>";
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $vlt_url . "/v1/transit/encrypt/web");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, '{"plaintext":"' . base64_encode($_SERVER['SERVER_NAME']) . '"}');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
               'X-Vault-Token: '.$token
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);

            curl_close($ch);

            $cipher_value = json_decode($result)->{'data'}->{'ciphertext'};
            echo "Encrypted value from Vault:" . $cipher_value . "</br>";

            echo "Put data into database...</br>";

            if (!$conn->query('INSERT INTO test(id, value) VALUES (1,"Hello"), (2,"World!"), (3,"' . $cipher_value . '")')) {
                echo "Fail to insert into table: (" . $conn->errno . ") " . $conn->error;
            }

            echo "Get data from database:</br>";

            if(! $res = $conn->query("SELECT id, value FROM test ORDER BY id ASC")) {
                echo "Fail to select ids in table: (" . $conn->errno . ") " . $conn->error;
            }

            for ($row_no = $res->num_rows - 1; $row_no >= 0; $row_no--) {
                $res->data_seek($row_no);
                $row = $res->fetch_assoc();
                echo " id = " . $row['id'] . " & value = " . $row['value'] . "</br>";
            }
            ?>
    </body>
</html>
