First, init your terraform folder:

```bash
cd terraform
$ docker run -i -t -v $(pwd):/app/ -w /app/ hashicorp/terraform:light init
cd -
```

```
$ role_id=$(docker run -i -t -v $(pwd)/terraform:/app/ -w /app/ hashicorp/terraform:light output approle_role_id)
$ secret_id=$(docker run -i -t -v $(pwd)/terraform:/app/ -w /app/ hashicorp/terraform:light output approle_secret_id)
$ docker-compose -f app.yml run -e VLT_ROLE_ID=$role_id -e VLT_SECRET_ID=$secret_id --service-ports web
```

Vault ADDR: http://127.0.0.1:8200/
App ADDR: http://127.0.0.1:8080/
