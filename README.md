# Vault demonstration

This repository is dedicated to the talk: **Be secret like a ninja with Vault Hashicorp**.

**Disclaimer**: The repository is here for demonstration purpose. Meaning: No best practice and a lot of review.

For the demonstration, we will based on a basic website using the following LAMP stack:

* APACHE
* MYSQL
* PHP

You can learn more with the [related blog post](https://blog.mehdilaruelle.ninja/posts/2019/03/migrate-your-application-secrets-in-vault-step-1/)

## Steps ? Which steps ?

Based on website [in step0](./step0/README.md), which is our starting point website, we will integrate the Vault step by step.

### Step 0: Find secrets

Our starting point website.

We will find secrets inside the code.

See more on the [REAME.md](./step0/README.md).

Related blog post: [MIGRATE YOUR SECRETS APPLICATION - PART1](https://blog.mehdilaruelle.ninja/posts/2019/03/migrate-your-application-secrets-in-vault-step-1/)

### Step 1: Static Secrets

In this step, we add a entrypoint dealing with Vault (Authentication + retrieve secrets) inside the application without changing the code.

See more on the [REAME.md](./step1/README.md).

Related blog post: [MIGRATE YOUR SECRETS APPLICATION - PART1](https://blog.mehdilaruelle.ninja/posts/2019/03/migrate-your-application-secrets-in-vault-step-1/)

### Step 2: Dynamic Secrets

In this step, we remove the entrypoint in the previous step and changing the applications code.

The goal is to use, at each time, a new database user (username+password) access.

See more on the [REAME.md](./step2/README.md).

Related blog post: [MIGRATE YOUR SECRETS APPLICATION - PART2](https://blog.mehdilaruelle.ninja/posts/2019/03/migrate-your-application-secrets-in-vault-step-2/)

### Step 3: Encryption as a Service

In this step, based on the previous step, we will add encryption and decryption process.

The goal is to encrypt the data into the database.

See more on the [REAME.md](./step3/README.md).

Related blog post: [ENCRYPTION AS A SERVICE](https://blog.mehdilaruelle.ninja/posts/2019/03/migrate-your-application-secrets-in-vault-step-3/)

### Step 4 (bonus): Vault agent & Consul Env

In this step, based on the previous step, we will use Vault agent to authentication with
Vault server and Consul Env to populate secrets into environment variables.

The goal is to interact with the Vault transparently for an application (no app change).

See more on the [REAME.md](./step4/README.md).

Related blog post: [VAULT AGENT](https://blog.mehdilaruelle.ninja/posts/2021/02/how-to-reduce-code-dependency-with-vault-agent/)

### Step 4b (bonus): Vault agent only

In this step, based on the step 3, we will use Vault agent to authentication with
Vault server and to render template file with secrets. It's an alternative to the step 4.
The step 4 is a way to implement secret through environment variables and step 4b is a way to implement secret through a file.

The goal is to interact with the Vault transparently for an application (no app change).

See more on the [REAME.md](./step4b/README.md).

Related blog post: [VAULT AGENT](https://blog.mehdilaruelle.ninja/posts/2021/02/how-to-reduce-code-dependency-with-vault-agent/)

## Contact

You see something wrong ? You want extra information or more ?

Contact me: <3exr269ch@mozmail.com>
