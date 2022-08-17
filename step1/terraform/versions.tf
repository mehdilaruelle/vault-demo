terraform {
  required_providers {
    template = {
      source = "hashicorp/template"
    }
    vault = {
      source  = "hashicorp/vault"
      version = "~> 3.8.2"
    }
  }
  required_version = ">= 1.0"
}
