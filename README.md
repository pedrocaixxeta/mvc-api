# 📚 API RESTful -- Sistema de Recomendações de Livros

Este projeto é uma **API RESTful** desenvolvida em **PHP puro**,
utilizando o padrão **MVC**.\
O sistema gerencia **Usuários**, **Gêneros** e **Recomendações**, com
autenticação segura via **JWT**.

------------------------------------------------------------------------

# 🛠️ Passo 1: Instalação

## 1️⃣ Instalar dependências (Composer)

No terminal, dentro da pasta raiz do projeto:

``` bash
composer install
```

------------------------------------------------------------------------

## 2️⃣ Configurar Banco de Dados (MySQL)

Crie o banco:

``` sql
CREATE DATABASE IF NOT EXISTS banco_mvc;
USE banco_mvc;
```

Crie as tabelas:

``` sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE generos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE recomendacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT,
    genero_id INT,
    livro_recomendado VARCHAR(150),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (genero_id) REFERENCES generos(id)
);
```

Criar usuário Admin (senha: **123**):

``` sql
INSERT INTO usuarios (nome, email, senha) VALUES 
('Admin', 'admin@email.com',
'$2y$10$pRl1xV2OBzxc4nhAfW1PxeZHuRJOJ/7mRmP5hwLQWyLd8xsG9AS.O');
```

------------------------------------------------------------------------

# 🔐 Passo 2: Login (Gerar Token)

Você **deve gerar um token antes de qualquer requisição**.

**POST**

    http://localhost/mvc_13_api/login

**JSON:**

``` json
{
    "email": "admin@email.com",
    "senha": "123"
}
```

Use o token retornado em:\
**Authorization → Bearer Token**

------------------------------------------------------------------------

# 👤 Passo 3: Testar Usuários

## ➕ Cadastrar Usuário

**POST**

    http://localhost/mvc_13_api/usuario

**JSON:**

``` json
{
    "nome": "Novo Aluno",
    "email": "aluno@teste.com",
    "senha": "123"
}
```

------------------------------------------------------------------------

## 📄 Listar Usuários

**GET**

    http://localhost/mvc_13_api/usuario

------------------------------------------------------------------------

## ✏️ Alterar Usuário

**PUT**

    http://localhost/mvc_13_api/usuario

**JSON:**

``` json
{
    "id": 1,
    "nome": "Admin Editado",
    "email": "admin@email.com"
}
```

------------------------------------------------------------------------

## 🗑️ Excluir Usuário

**DELETE**

    http://localhost/mvc_13_api/usuario?id=2

------------------------------------------------------------------------

# 📚 Passo 4: Testar Gêneros

## ➕ Cadastrar Gênero

**POST**

    http://localhost/mvc_13_api/genero

**JSON:**

``` json
{
    "nome": "Ficção Científica"
}
```

------------------------------------------------------------------------

## 📄 Listar Gêneros

**GET**

    http://localhost/mvc_13_api/genero

------------------------------------------------------------------------

## ✏️ Alterar Gênero

**PUT**

    http://localhost/mvc_13_api/genero

**JSON:**

``` json
{
    "id": 1,
    "nome": "Terror e Suspense"
}
```

------------------------------------------------------------------------

## 🗑️ Excluir Gênero

**DELETE**

    http://localhost/mvc_13_api/genero?id=1

------------------------------------------------------------------------

# ⭐ Passo 5: Testar Recomendações

## ➕ Cadastrar Recomendação

**POST**

    http://localhost/mvc_13_api/recomendacao

**JSON:**

``` json
{
    "usuario_id": 1,
    "genero_id": 1,
    "livro_recomendado": "O Guia do Mochileiro das Galáxias"
}
```

------------------------------------------------------------------------

## 📄 Listar Recomendações

**GET**

    http://localhost/mvc_13_api/recomendacao

------------------------------------------------------------------------

## ✏️ Alterar Recomendação

**PUT**

    http://localhost/mvc_13_api/recomendacao

**JSON:**

``` json
{
    "id": 1,
    "usuario_id": 1,
    "genero_id": 1,
    "livro_recomendado": "Duna"
}
```

------------------------------------------------------------------------

## 🗑️ Excluir Recomendação

**DELETE**

    http://localhost/mvc_13_api/recomendacao?id=1

------------------------------------------------------------------------

# 🛡️ Tratamento de Erros

  Código        Significado
  ------------- --------------------------------
  **200/201**   Sucesso
  **400**       Dados incompletos ou inválidos
  **401**       Token inválido ou não enviado
  **404**       ID não encontrado
  **500**       Erro interno (Banco de Dados)
