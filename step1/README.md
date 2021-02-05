# How is it working ?

This step use Hashicorp Vault for static secrets.

You need to put secrets inside the Vault before your application start.

## Initialisation

First, init your terraform folder:

```bash
$ docker run --rm -v $(pwd)/terraform:/app/ -w /app/ hashicorp/terraform:light init
```

Or if you can use Makefile: `make init`

## Infrastructure

As an Ops, you need to deploy the infrastructure:

```bash
$ docker-compose up
```

Or if you can use Makefile: `make infra`

### Service access

* Vault address: [http://127.0.0.1:8200](http://127.0.0.1:8200)

### Insert secrets in Vault

Use a script or Vault web UI to put your secrets.

Vault informations access for web UI:

1. Connect with your web browser to the Vault URL
2. Use token connection and enter as a token: `root`
3. In secret path, create a secret inside this default project path: `web`
4. Put the 2 keys: `username` and `password`.
5. Put the value into both keys: `dev`
6. Add secret and save it.

## Application

As an Dev, you need to deploy the infrastructure. In this case, using Vault, your application use [Approle](https://www.vaultproject.io/docs/auth/approle.html) and need **Role_ID** and **Secret_ID**.

Here how to retrieve **Role_ID** and **Secret_ID**:

```bash
$ role_id=$(docker run --rm -v $(pwd)/terraform:/app/ -w /app/ hashicorp/terraform:light output -raw approle_role_id)
$ secret_id=$(docker run --rm -v $(pwd)/terraform:/app/ -w /app/ hashicorp/terraform:light output -raw approle_secret_id)
```

And launch your application:

```
$ docker-compose -f app.yml run -e VLT_ROLE_ID=$role_id -e VLT_SECRET_ID=$secret_id --service-ports web
```

Or if you can use Makefile: `make app`

### Service access

* Application address: [http://127.0.0.1:8080](http://127.0.0.1:8080)

## Cleanup

Do the following commands:

```bash
$ docker-compose down
$ docker-compose -f app.yml down
$ rm terraform/terraform.tfstate
```

Or if you can use Makefile: `make clean`
