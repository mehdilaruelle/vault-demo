terraform {
  required_providers {
    template = {
      source = "hashicorp/template"
    }
    vault = {
      source = "hashicorp/vault"
      version = "~> 2.24.1"
    }
  }
  required_version = ">= 1.0"
}
