{
  {{ with secret (env "VAULT_PATH") }}
  "username":"{{ .Data.username }}",
  "password":"{{ .Data.password }}"
  {{ end }}
}

