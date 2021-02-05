#! /bin/bash

echo "$VLT_ROLE_ID" >> /root/role-id
echo "$VLT_SECRET_ID" >> /root/.secret-id

vault agent -config=/root/config.hcl &

envconsul -vault-agent-token-file="/var/www/.vault-token"  -upcase -vault-renew-token=false -secret="$VAULT_PATH" apache2-foreground
