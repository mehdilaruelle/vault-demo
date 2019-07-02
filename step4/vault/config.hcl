pid_file = "./pidfile"

exit_after_auth = true

vault {
        address = "http://vault:8200"
}

auto_auth {
        method "approle" {
                config = {
                        role_id_file_path = "/root/role-id"
                        secret_id_file_path = "/root/.secret-id"
                        remove_secret_id_file_after_reading = true
                }
        }

        sink "file" {
                config = {
                        path = "/var/www/html/.vault-token"
                }
        }
}
