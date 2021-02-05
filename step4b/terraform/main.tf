resource "vault_auth_backend" "approle" {
  type = "approle"
}

resource "vault_mount" "db" {
  type = "database"
  path = "database"
}

resource "vault_mount" "transit" {
  type = "transit"
  path = "transit"
}

data "template_file" "web_policies" {
  template = file(var.policy_path)

  vars = {
    entity_name = var.entity_name
  }
}

resource "vault_policy" "web_policies" {
  name = var.entity_name

  policy = data.template_file.web_policies.rendered
}

resource "vault_approle_auth_backend_role" "project_role" {
  backend            = vault_auth_backend.approle.path
  role_name          = "role-${var.entity_name}"
  secret_id_num_uses = var.secret_id_num_uses
  secret_id_ttl      = var.secret_id_ttl
  token_num_uses     = var.token_num_uses
  token_ttl          = var.token_ttl
  token_max_ttl      = var.token_max_ttl
  token_policies     = ["default", var.entity_name]
}

# The pipeline should generate this one
resource "vault_approle_auth_backend_role_secret_id" "id" {
  backend   = vault_auth_backend.approle.path
  role_name = vault_approle_auth_backend_role.project_role.role_name
}

resource "vault_database_secret_backend_connection" "mysql" {
  backend       = vault_mount.db.path
  name          = "mysql"
  allowed_roles = [var.entity_name]

  mysql {
    connection_url = "${var.db_user}:${var.db_password}@tcp(mysql:3306)/"
  }
}

resource "vault_database_secret_backend_role" "role" {
  backend             = vault_mount.db.path
  name                = var.entity_name
  db_name             = vault_database_secret_backend_connection.mysql.name
  creation_statements = ["CREATE USER '{{name}}'@'%' IDENTIFIED BY '{{password}}';GRANT ALL PRIVILEGES ON *.* TO '{{name}}'@'%';"]
  default_ttl         = var.db_secret_ttl
}

resource "vault_generic_secret" "transit_key" {
  path = "${vault_mount.transit.path}/keys/${var.entity_name}"

  data_json = <<EOT
{
  "type": "aes256-gcm96"
}
EOT
}
