init:
	docker run --rm -v $$(pwd)/terraform:/app/ -w /app/ hashicorp/terraform:light init

infra:
	docker-compose up

app:
	ROLE_ID=$$(docker run --rm -v $$(pwd)/terraform:/app/ -w /app/ hashicorp/terraform:light output -raw approle_role_id); \
SECRET_ID=$$(docker run --rm -v $$(pwd)/terraform:/app/ -w /app/ hashicorp/terraform:light output -raw approle_secret_id); \
docker-compose -f app.yml run -e VLT_ROLE_ID=$$ROLE_ID -e VLT_SECRET_ID=$$SECRET_ID --service-ports web

build:
	docker-compose -f app.yml build

clean:
	docker-compose down
	docker-compose -f app.yml down
	rm terraform/terraform.tfstate
