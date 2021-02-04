terraform {
  required_providers {
    template = {
      source = "hashicorp/template"
    }
    vault = {
      source = "hashicorp/vault"
    }
  }
  required_version = ">= 0.14"
}
