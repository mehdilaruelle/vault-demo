# How is it working ?

This step use Hashicorp Vault dynamic secrets with database.

Each time you will go to the website, the application will use a new couple user/password for database access.

It use also Encryption as a Service. Each time you will go to the website, the application will Encrypt value and store the encrypted data into the database.

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

## Test the EaaS

Going into the website, you will find an encrypted data from Vault. We will decrypt this value to test if the EaaS working.
Your application can only encrypt and can not decrypt (check the [web.hcl](./terraform/web.hcl)).

Vault informations access for web UI:

1. Connect with your web browser to the Vault URL
2. Use token connection and enter as a token: `root`
3. Go to `transit` path and select: `web`
4. In `key actions`, select: `Decrypt`
5. Put your encrypted value and decrypt it
6. `Decode from base64` and you will get the decrypt value who should be equel to the server name

## Cleanup

Do the following commands:

```bash
$ docker-compose down
$ docker-compose -f app.yml down
$ rm terraform/terraform.tfstate
```

Or if you can use Makefile: `make clean`
