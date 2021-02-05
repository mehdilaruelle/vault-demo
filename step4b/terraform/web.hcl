path "database/creds/${entity_name}" {
  capabilities = ["read"]
}

path "transit/encrypt/${entity_name}" {
  capabilities = ["create", "update"]
}
