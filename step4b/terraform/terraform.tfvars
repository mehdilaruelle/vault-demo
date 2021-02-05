entity_name = "web"

policy_path = "web.hcl"

# Adjust the ttl to test renew secrets and token

db_secret_ttl = 10

token_ttl = 15

token_max_ttl = 60
