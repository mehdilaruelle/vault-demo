pid_file = "./pidfile"

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

template {
  source = "/var/www/secrets.tpl"
  destination = "/var/www/secrets.json"
}
