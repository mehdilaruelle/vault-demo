# Vault demonstration

This repository is dedicated to the talk: **Be secret like a ninja with Vault Hashicorp**.

**Disclaimer**: The repository is here for demonstration purpose. Meaning: No best practice and a lot of review.

For the demonstration, we will based on a basic website using the following LAMP stack:

* APACHE
* MYSQL
* PHP

## Steps ? Which steps ?

Based on website [in step0](./step0/README.md), which is our starting point website, we will integrate the Vault step by step.

### Step 0: Find secrets

Our starting point website.

We will find secrets inside the code.

See more on the [REAME.md](./step0/README.md).

### Step 1: Static Secrets

In this step, we add a entrypoint dealing with Vault (Authentication + retrieve secrets) inside the application without changing the code.

See more on the [REAME.md](./step1/README.md).

### Step 2: Dynamic Secrets

In this step, we remove the entrypoint in the previous step and changing the applications code.

The goal is to use, at each time, a new database user (username+password) access.

See more on the [REAME.md](./step2/README.md).

### Step 3: Encryption as a Service

In this step, based on the previous step, we will add encryption and decryption process.

The goal is to encrypt the data into the database.

See more on the [REAME.md](./step3/README.md).

## Contact

You see something wrong ? You want extra information or more ?

Contact me: <mehdi.laruelle@d2si.io>
