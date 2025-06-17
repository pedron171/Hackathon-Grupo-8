# Projeto Hackathon - API Node.js

## Descrição

Esta API foi desenvolvida em Node.js com TypeScript para gerenciar o backend do sistema de eventos acadêmicos do hackathon da Faculdade UniALFA. Ela contempla o CRUD das entidades principais como palestrantes, alunos, eventos e inscrições.

---

## Tecnologias Utilizadas

- Node.js
- TypeScript
- Express
- Knex (Query Builder)
- MySQL (banco de dados)
- ts-node (execução do TypeScript)
- dotenv (variáveis de ambiente)

---

## Instalação

1. Clone o repositório:

```bash
$ git clone <URL-do-seu-repositorio>


2. Entre na pasta do projeto:

```bash 
$ cd (nome-do-projeto)


3. Instale as dependências

```bash
$ npm install


4. Configure seu arquivo .env com os dados do banco.


5. Rode as migrations para criar as tabelas do banco:

```bash
$ npx knex migrate:latest


## COMO RODAR NO SERVIDOR ##

````bash
$ npm run dev
(O servidor vai iniciar em htpp://localhost:3333).


## EndPoints da API ##

Palestrantes

-GET /palestrantes - Lista todos os palestrantes
-POST /palestrantes - Cria um novo palestrante
-PUT /palestrantes/:id - Atualiza palestrante pelo id
-DELETE /palestrantes/:id - Remove palestrante pelo id

Alunos

-GET /alunos - Lista todos os alunos
-POST /alunos - Cria um novo aluno
-PUT /alunos/:id - Atualiza aluno pelo id
-DELETE /alunos/:id - Remove aluno pelo id

Eventos

-GET /eventos - Lista todos os eventos
-POST /eventos - Cria um novo evento
-PUT /eventos/:id - Atualiza evento pelo id
-DELETE /eventos/:id - Remove evento pelo id

Inscrições

-GET /inscricoes - Lista todas as inscrições
-POST /inscricoes - Cria uma nova inscrição
-PUT /inscricoes/:id - Atualiza inscrição pelo id
-DELETE /inscricoes/:id - Remove inscrição pelo id

Estrutura do Projeto

-/src/controllers - Contém os controllers da API
-/src/routes - Definição das rotas
-/src/database - Configuração do banco e migrations
-knexfile.ts - Configuração do Knex
-.env - Variáveis de ambiente (não subir para o GitHub)


## AUTOR - MURILO SOUSA JOAQUIM ##