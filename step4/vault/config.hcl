pid_file = "./pidfile"

exit_after_auth = true

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
                        path = "/var/www/.vault-token"
                        mode = 0644
                }
        }
}
