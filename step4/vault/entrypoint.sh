#! /bin/bash

echo "$VLT_ROLE_ID" >> ~/role-id
echo "$VLT_SECRET_ID" >> ~/.secret-id

vault agent -config=/root/config.hcl &

sleep 2

export VAULT_TOKEN=$(cat /var/www/html/.vault-token)

envconsul -upcase -vault-renew-token=false -secret="$VAULT_PATH" apache2-foreground
