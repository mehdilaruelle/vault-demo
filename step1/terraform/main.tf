resource "vault_auth_backend" "approle" {
  type = "approle"
}

data "template_file" "web_policies" {
  template = "${file("${var.policy_path}")}"

  vars = {
    entity_name = "${var.entity_name}"
  }
}

resource "vault_policy" "web_policies" {
  name = "${var.entity_name}"

  policy = "${data.template_file.web_policies.rendered}"
}

resource "vault_approle_auth_backend_role" "project_role" {
  backend            = "${vault_auth_backend.approle.path}"
  role_name          = "role-${var.entity_name}"
  secret_id_num_uses = "${var.token_num_uses}"
  secret_id_ttl      = "${var.secret_id_ttl}"
  token_num_uses     = "${var.token_num_uses}"
  token_ttl          = "${var.token_ttl}"
  token_max_ttl      = "${var.token_max_ttl}"
  token_policies     = ["default", "${var.entity_name}"]
}

# The pipeline should generate this one
resource "vault_approle_auth_backend_role_secret_id" "id" {
  backend   = "${vault_auth_backend.approle.path}"
  role_name = "${vault_approle_auth_backend_role.project_role.role_name}"
}
