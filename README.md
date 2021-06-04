# TESTE BACK-END PHP/LARAVEL | WEXARK TECNOLOGIA

Projeto criado para 2ª fase do Processo Seletivo para vaga de **DESENVOLVIMENTO BACK-END** na **WEXARK TECNOLOGIA**.

> **TECNOLOGIAS UTILIZADAS**: PHP + LARAVEL + MySQL + Docker

----------------------------------------------------------------------
## Tecnologias Necessárias

- Docker (https://www.docker.com/get-started)
----------------------------------------------------------------------
## Informações Iniciais e Iniciando o Projeto

Toda a configuração do projeto, desde instalação do banco de dados, composer e inicialização do servidor do projeto, estão todos configurados através do Docker. 

Para inicializar o projeto:

**1. CONFIGURAÇÃO DO ENV** (O arquivo .env já configurado para o Docker segue no e-mail enviado)

**2. INSTALAÇÃO DO SERVIDOR + BANCO**: Rode o comando abaixo no terminal

``` bash
$ docker-compose up -d
```

**3. CONFIGURAÇÃO DO SCRIPT SQL**: 

Na pasta DATABASE, haverá um arquivo "script.sql", onde deverá ser rodado na url (http://localhost:8090/). 

    CREDENCIAIS: root | docker

**4. LINK POSTMAN COLLECTION**: (https://www.getpostman.com/collections/fef218e67be5ac845bf1)