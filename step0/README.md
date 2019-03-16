# How is it working ?

This our starting point website with secret divulgation.

You can find the website code in the folder `web/`. Where there is only one file [index.php](./web/index.php). Inside this file, in **line 16**, you can find the database password in cleartext.

Our goal is to secure this website with [Hashicorp Vault](https://www.vaultproject.io/).

## Run it

Run this command : `$ docker-compose up`

Go to [http://127.0.0.1:8080](http://127.0.0.1:8080) to see the website.

## Clean it

Run this command : `$ docker-compose down`
