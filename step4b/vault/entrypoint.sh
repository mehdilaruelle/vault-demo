#! /bin/bash

echo "$VLT_ROLE_ID" >> /root/role-id
echo "$VLT_SECRET_ID" >> /root/.secret-id


vault agent -config=/root/config.hcl &
apache2-foreground
