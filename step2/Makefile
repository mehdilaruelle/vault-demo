init:
	docker run -i -t -v $(pwd)/terraform:/app/ -w /app/ hashicorp/terraform:light init

infra:
	docker-compose up

build:
	docker-compose -f app.yml build

clean:
	docker-compose down
	rm terraform/terraform.tfstate
