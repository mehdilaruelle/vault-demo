<!-- ./php/index.php -->

<html>
    <head>
        <title>Hello World!</title>
    </head>

    <body>

    <h1>Hello World!</h1>
    Vault interaction...</br>
        <?php
            $vlt_url  = getenv('VLT_ADDR');
            $vlt_path = getenv('VLT_PATH');

            echo "Approle auth with Vault...</br>";
            $role_id   = getenv('VLT_ROLE_ID');
            $secret_id = getenv('VLT_SECRET_ID');

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $vlt_url."/v1/auth/approle/login");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, '{"role_id":"'.$role_id.'","secret_id":"'.$secret_id.'"}');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $json_return = curl_exec($ch);

            curl_close($ch);

            $json_token = json_decode($json_return);
            $token = $json_token->{'auth'}->{'client_token'};

            echo "Get database credentials from Vault...</br>";
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $vlt_url."/v1/".$vlt_path);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Vault-Token:'.$token
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $json_secrets = curl_exec($ch);

            curl_close($ch);

        ?>
    Attempting MySQL connection from php...</br>
        <?php
            $host   = getenv('DB_HOST');
            $dbname = getenv('DB_NAME');
            $user = json_decode($json_secrets)->{'data'}->{'username'};
            $pass = json_decode($json_secrets)->{'data'}->{'password'};

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
                !$conn->query("CREATE TABLE test(id INT)") ) {
                echo "Fail to create table: (" . $conn->errno . ") " . $conn->error;
            }

            echo "Encrypt value from Vault...</br>";
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $vlt_url."/v1/transit/encrypt/web");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, '{"plaintext":"'.base64_encode(4).'"}');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Vault-Token:'.$token
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);

            curl_close($ch);

            $cipher_value = json_decode($result)->{'data'}->{'ciphertext'};
            echo "Encrypted value from Vault:".$cipher_value."</br>";

            echo "Decrypt value from Vault...</br>";
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $vlt_url."/v1/transit/decrypt/web");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, '{"ciphertext":"'.$cipher_value.'"}');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'X-Vault-Token:'.$token
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);

            curl_close($ch);

            $plaintext_value = json_decode($result)->{'data'}->{'plaintext'};
            echo "Decrypted value from Vault:".base64_decode($plaintext_value)."</br>";

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
