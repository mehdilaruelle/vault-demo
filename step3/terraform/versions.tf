terraform {
  required_providers {
    template = {
      source = "hashicorp/template"
    }
    vault = {
      source = "hashicorp/vault"
      version = "~> 2.14.0"
    }
  }
  required_version = ">= 0.14"
}
