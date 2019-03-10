#! /bin/bash

if (! [ -z $VLT_SECRET_ID ]) && (! [ -z $VLT_ROLE_ID ]); then
  role_id=$VLT_ROLE_ID
  secret_id=$VLT_SECRET_ID
else
  echo "No Vault credentials found."
  exit 1
fi

VLT_TOKEN=$(curl -s -X POST -d '{"role_id":"'$role_id'","secret_id":"'$secret_id'"}' $VLT_ADDR/v1/auth/approle/login | jq -r '.auth.client_token')

DB_KEYS=$(curl -s -H "X-Vault-Token:$VLT_TOKEN" ${VLT_ADDR}/v1/${VLT_PATH})

export DB_USER="$(echo $DB_KEYS | jq -r '.data.data.username')"
export DB_PASSWORD="$(echo $DB_KEYS | jq -r '.data.data.password')"

apache2-foreground
