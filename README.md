# API FitTech
A API FitTech consiste em ser uma API com o objetivo de auxiliar no cadastro e no gerenciamento dos dados estudantes, exercícios e treinos de uma determinada academia.

# Tecnologia Usadas
O presente projeto foi desenvolvido em php através do framework Laravel 10 e do banco de dados PostgreSQL.

# Técnicas e pastas utilizadas
Dentro desse projeto, fora utilizadas as seguintes estruturas de pastas:

| Caminho              | Função        |
| -------------------- | ------------- |
| app/Http/Controllers | apresenta todos os controllers que foram construídos para esse projeto |
| app/Http/Mail        | contém as configurações para o envio do e-mail de boas vindas |
| app/Model            | contém todos os models que foram criados nesse projeto |
| database             | apresenta todas as tabelas que foram criadas nesse projeto |
| resources/views      | contém os templates do e-mail de boas vindas e do pdf que será exportado |
| app/routes/app       | arquivo que contém todas as rotas da API devidamente separadas entre rotas públicas e privadas |

# Modelagem do Banco de Dados do SQL
Abaixo encontra-se um esquema desenvolvido via PostgreSQL com as tabelas que foram construídas e usadas para a construção do API FitTech:

![Esquema desenhado no PostgreSQL que representa a relação entre as tabelas do projeto](https://github.com/Guimariane/Projeto_Academia/assets/47523514/53c6c5aa-efec-4ed9-bf98-3e2184602bda)

## Relacionamentos entre as tabelas

| Tabela 1 | Chave Primária | Tabela 2 | Chave Primária |
| -------- | -------------- | ---------| -------------- |
| users | plan_id | plans | id |
| users | id | students | user_id |
| users | id | exercises | user_id |
| exercises | id | workouts | exercise_id |
| students | id | workouts | student_id |

# Como configurar o projeto corretamente


# Detalhamento da API

## Rotas
| Função | Tipo de requisição | Controller Relacionado | Tipo de Rota |
| ------ | ------------------ | ---------------------- | ------------ |
| S01 - Cadastro de Usuário | POST | UserController | Pública |
| S02 - Login | POST | AuthController | Pública |
| S03 - Dashboard | GET | DashboardController | Privada |
| S04 - Cadastro de Exercícios | POST | ExerciseController | Privada |
| S05 - Listagem de Exercícios | GET | ExerciseController | Privada |
| S06 - Deleção de Exercícios | DELETE | ExerciseController | Privada |
| S07 - Cadastro de Estudante | POST | StudentController | Privada |
| S08 - Listagem de Estudante | GET | StudentController | Privada |
| S09 - Deleção de Estudante | DELETE* | StudentController | Privada |
| S10 - Atualização de Estudante | UPDATE | StudentController | Privada |
| S11 - Cadastro de Treinos | POST | WorkoutController | Privada |
| S12 - Listagem de Treinos do Estudante | GET | WorkoutController | Privada |
| S13 - Listagem de Um Estudante | GET | StudentController | Privada |
| S14 - Exportação de PDF | GET | WorkoutController | Privada |

# Endpoints

## S01 - Cadastro de Usuário

```
POST - api/users
```

| Parâmetro | Tipo | Descrição |
| --------- | -----| --------- |
| id | int | **Incremental**. Refere-se ao id de cada usuário cadastrado dentro da API |
| name | string | **Obrigatório**. Nome do usuário |
| email | string | **Obrigatório**. E-mail do usuário |
| date_birth | string | **Obrigatório**. Data de Nascimento do usuário |
| cpf | string | **Obrigatório**. CPF do usuário |
| password | string | **Obrigatório**. Senha do usuário |
| plan_id | int | **Obrigatório**. Refere-se ao plano que o usuário escolheu que tem um limite de cadastro de estudantes |
| email_verified_at | date | **Preenchimento automático**. Data de Verificação do e-mail |
| remember_token | string | **Preenchimento automático.** Para gerar o token do usuário assim que ele se loga |

### Exemplo de Requisição dentro da API:
```
{
  "name": "Teste Ingrid",
  "email": "teste_ingrid@teste.com",
  "date_birth": "01/06/1994",
  "cpf": "12345698701",
  "password": "1234abcd",
  "plan_id": 1
}
```
 
### Respostas que podem ser encontradas nessa API

| Número do Erro | Response | Descrição |
| -------------- | -------- | --------- |
| 201 | CREATED | Usuário Criado com sucesso |
| 400 | BAD REQUEST | Dados colocados no corpo da requisição de maneira incorreta ou quando dá dado que já foi cadastrado|

### Imagens das requisições
![Imagem 1 - User Criado com Sucesso](https://github.com/Guimariane/Projeto_Academia/assets/47523514/375cc48a-768d-494d-80a6-5ede0af5f2ef)
![Imagem 2 - Bad Request](https://github.com/Guimariane/Projeto_Academia/assets/47523514/e646dc52-c8d2-4945-aead-2050c9fd5665)


## S02 - Login

```
POST - api/login
```

| Parâmetro | Tipo | Descrição |
| --------- | -----| --------- |
| email | string | Email do usuário para se logar |
| password | string | Senha que o usuário cadastrou para se logar e ter acesso às rotas |

### Exemplo de Requisição dentro da API:
```
{
  "email": "testando_ingrid@teste.com",
  "password": "1234abcd"
}
```

### Respostas que podem ser encontradas nessa API

| Número do Erro | Response | Descrição |
| -------------- | -------- | --------- |
| 200 | OK | Login Autorizado |
| 400 | BAD REQUEST | Dados colocados no corpo da requisição de maneira incorreta |
| 401 | UNAUTHORIZED | Login Inválido |

### Imagens das requisições
![Imagem 3 - Login Autorizado](https://github.com/Guimariane/Projeto_Academia/assets/47523514/4512266d-0f76-46e1-9dd1-4df75f37bca2)
![Imagem 4 - Bad Request](https://github.com/Guimariane/Projeto_Academia/assets/47523514/d311cca7-faed-40b0-bb1f-5cf4d51e953e)
![Imagem 5 - Unauthorized](https://github.com/Guimariane/Projeto_Academia/assets/47523514/d9c3230c-5c50-4776-aae2-f297ef64d8a8)


## S03 - Dashboard

```
GET - api/dashboard
```

| Parâmetro | Tipo | Descrição |
| --------- | -----| --------- |
| registered_students | int | Número de estudantes registrados pelo usuário |
| registeres_exercises | int | Número de exercícios registrados pelo usuário |
| description_plan | string | Tipo de plano no qual o usuário se cadastrou |
| remaining_estudants | int | Cadastros restantes que é possível o usuário fazer dentro do plano que ele se encontra |

### Respostas que podem ser encontradas nessa API

| Número do Erro | Response | Descrição |
| -------------- | -------- | --------- |
| 200 | OK | Upload do dashboard com as informações solicitadas |

### Imagens das requisições
![Imagem 6 - Dashboard](https://github.com/Guimariane/Projeto_Academia/assets/47523514/edb0f837-7be8-4172-8bf7-7ddf6f44e955)


## S04 - Cadastro de Exercícios

```
POST - api/exercises
```

| Parâmetro | Tipo | Descrição |
| --------- | -----| --------- |
| id | int | **Incremental**. Refere-se ao id de cada exercício cadastrado dentro da API |
| description | string | Descrição do exercício cadastrado |
| user_id | int | **Preenchimento automático**. Refere-se ao usuário que cadastrou o exercício |

### Exemplo de Requisição dentro da API:
```
{
  "description": "Remada Unilateral"
}
```

### Respostas que podem ser encontradas nessa API

| Número do Erro | Response | Descrição |
| -------------- | -------- | --------- |
| 201 | CREATED | Exercício criado com sucesso |
| 400 | BAD REQUEST | Requisição preenchida de maneira incorreta |
| 409 | CONFLICT | Exercício que já foi cadastrado pelo usuário |

### Imagens das requisições
![Imagem 7 - Cadastro Exercício](https://github.com/Guimariane/Projeto_Academia/assets/47523514/a656510f-1600-495f-8fba-45dc7813dfa4)
![Imagem 8 - Bad Request](https://github.com/Guimariane/Projeto_Academia/assets/47523514/2f8b5ffe-23bf-4a52-9913-16875d9b165f)
![Imagem 9 - Conflict](https://github.com/Guimariane/Projeto_Academia/assets/47523514/3a57fee7-bf1f-4ba4-b2ef-43447fe298b9)


## S05 - Listagem de exercícios

```
GET - api/exercises
```
| Parâmetro | Tipo | Descrição |
| --------- | -----| --------- |
| id | int | **Incremental**. Refere-se ao id de cada exercício cadastrado dentro da API |
| description | string | Descrição do exercício cadastrado |
| user_id | int | **Preenchimento automático**. Refere-se ao usuário que cadastrou o exercício |
| created_at | date | data de criação do exercício |
| updated_at | date | data de atualização do exercício - que é igual a data de criação por ainda não ter essa configuração |

### Respostas que podem ser encontradas nessa requisição

| Número do Erro | Response | Descrição |
| -------------- | -------- | --------- |
| 200 | OK | Lista de exercícios puxada com sucesso |

### Imagens das requisições
![Imagem 10 - Lista Exercício](https://github.com/Guimariane/Projeto_Academia/assets/47523514/00cc9a40-34ca-4871-b7f9-07127575d4a1)

## S06 - Deleção de Exercícios

```
DELETE - api/exercises/{id}
```
--> Necessário inputar o id de algum exercício para chamar essa requisição dentro da API

### Respostas que podem ser encontradas nessa requisição

| Número do Erro | Response | Descrição |
| -------------- | -------- | --------- |
| 404 | NOT FOUND | Exercício não encontrado no banco de dados |
| 403 | FORBIDDEN | Ação não autorizada por excluir exercício de outro usuário |
| 409 | CONFLICT | Por existir algum treino cadastrado com esse exercício |
| 204 | NO CONTENT | Exercício excluído com sucesso |

### Imagens das requisições
![Imagem 11 - Conflict](https://github.com/Guimariane/Projeto_Academia/assets/47523514/f620cd42-869b-485b-be0a-c9c129a22d4d)
![Imagem 12 - Forbidden](https://github.com/Guimariane/Projeto_Academia/assets/47523514/4a593a20-920a-4d80-8426-3ac687a0ffc9)
![Imagem 13 - No Content](https://github.com/Guimariane/Projeto_Academia/assets/47523514/71bbf65e-c0ef-40ed-ba1d-fa776df33b55)
![Imagem 14 - Not Found](https://github.com/Guimariane/Projeto_Academia/assets/47523514/bf3f865a-25de-40a3-bc03-a96d52d43a6b)


## S07 - Cadastro de Estudante

```
POST - api/students
```

| Parâmetro | Tipo | Descrição |
| --------- | -----| --------- |
| name | string | **Obrigatório**. Nome do Estudante |
| email | string | **Obrigatório**. Email do Estudante |
| date_birth | string | **Obrigatório**. Data de Nascimento do Estudante |
| cpf | string | **Obrigatório**. CPF do Estudante |
| contact | string | **Obrigatório**. Telefone do Estudante |
| cep | string | CEP do Estudante |
| street | string | Rua do Estudante |
| state | string | Estado do Estudante | 
| neighboorhood | string | Bairro do Estudante |
| city | string | Cidade do Estudante |
| number | string | Número da Casa do Estudante |

### Exemplo de Requisição dentro da API:
```
{
  "name": "Rogério Ceni",
  "email": "rogerio_ceni@estudante.com",
  "date_birth": "2005-01-01",
  "cpf": "199.201.993-05",
  "contact": "9237693505",
  "city": "São Paulo",
  "neighborhood": "Testando",
  "number": "0",
  "street": "Rua dos Bobos",
  "state": "PR",
  "cep": "00000001"
}
```

### Respostas que podem ser encontradas nessa API

| Número do Erro | Response | Descrição |
| -------------- | -------- | --------- |
| 201 | CREATED | Estudante criado com sucesso |
| 400 | BAD REQUEST | Requisição preenchida de maneira incorreta ou dado já existente no banco de dados|
| 403 | CONFLICT | Limite de cadastros do plano atingido |

### Imagens das requisições
![Imagem 14 - Bad Request](https://github.com/Guimariane/Projeto_Academia/assets/47523514/06401e41-3e00-49a0-8f78-c9130b747759)
![Imagem 15 - Bad Request](https://github.com/Guimariane/Projeto_Academia/assets/47523514/1177517b-124b-409d-a11b-f9b947883fac)
![Imagem 16 - Created](https://github.com/Guimariane/Projeto_Academia/assets/47523514/1fd1cc26-0af5-49fe-b4bd-016847534aa3)


## S08 - Lista de Estudantes

```
GET - api/students
```
| Parâmetro | Tipo | Descrição |
| --------- | -----| --------- |
| id | int | **Incremental**. Refere-se ao id de cada exercício cadastrado dentro da API |
| name | string | Nome do Estudante |
| email | string | Email do Estudante |
| date_birth | string | Data de Nascimento do Estudante |
| cpf | string | CPF do Estudante |
| contact | string | Telefone do Estudante |
| cep | string | CEP do Estudante |
| street | string | Rua do Estudante |
| state | string | Estado do Estudante | 
| neighboorhood | string | Bairro do Estudante |
| city | string | Cidade do Estudante |
| number | string | Número da Casa do Estudante |
| user_id | int | **Preenchimento automático**. Refere-se ao usuário que cadastrou o estudante |
| created_at | date | data de criação do estudante |
| updated_at | date | data de atualização do estudante |
| deleted_at | date | data de exclusão do estudante |

### Respostas que podem ser encontradas nessa requisição

| Número do Erro | Response | Descrição |
| -------------- | -------- | --------- |
| 200 | OK | Lista de estudantes cadastrados pelo usuário puxada com sucesso |

### Imagens das requisições
![Imagem 17 - Lista Estudantes](https://github.com/Guimariane/Projeto_Academia/assets/47523514/42b2c0e3-54f5-4d46-8b16-41529e0d2325)


## S09 - Lista de Estudantes
```
DELETE - api/students/{id}
```
--> Essa requisição usa o comando Soft Delete.
--> Necessário inputar o id de algum estuudante para chamar essa requisição dentro da API

### Respostas que podem ser encontradas nessa requisição

| Número do Erro | Response | Descrição |
| -------------- | -------- | --------- |
| 404 | NOT FOUND | Estudante não encontrado no banco de dados |
| 403 | FORBIDDEN | Ação não autorizada por excluir estudante de outro usuário |
| 204 | NO CONTENT | Estudante excluído com sucesso |

### Imagens das requisições
![Imagem 18 - Forbidden](https://github.com/Guimariane/Projeto_Academia/assets/47523514/a82bf568-7575-404b-8544-64cdf4bc83b8)
![Imagem 19 - No Content](https://github.com/Guimariane/Projeto_Academia/assets/47523514/995a415f-55fc-4fac-b067-b9ef1f18a8d4)
![Imagem 20 - Not Found](https://github.com/Guimariane/Projeto_Academia/assets/47523514/a68a8c9b-3217-4d01-9bbc-cb88a2b38092)

## S10 - Atualização de Estudante
```
UPDATE - api/students/{id}
```
| Parâmetro | Tipo | Descrição |
| --------- | -----| --------- |
| name | string | Nome do Estudante |
| email | string | Email do Estudante |
| date_birth | string | Data de Nascimento do Estudante |
| cpf | string | CPF do Estudante |
| contact | string | Telefone do Estudante |
| cep | string | CEP do Estudante |
| street | string | Rua do Estudante |
| state | string | Estado do Estudante | 
| neighboorhood | string | Bairro do Estudante |
| city | string | Cidade do Estudante |
| number | string | Número da Casa do Estudante |


### Exemplo de Requisição dentro da API:
```
{
  "name": "Rogerio Ceni",
  "email": "rogerio_00@estudante.com",
  "contact": "2005000000",
  "city": "Ponta Grossa",
  "neighborhood": "Testando",
  "number": "0",
  "street": "Rua dos Bobos",
  "state": "PR",
  "cep": "00000001"
}
```

### Respostas que podem ser encontradas nessa requisição

| Número do Erro | Response | Descrição |
| -------------- | -------- | --------- |
|200| OK | Sucesso ao atualizar o estudante |

### Imagens das requisições
![Imagem 21 - OK](https://github.com/Guimariane/Projeto_Academia/assets/47523514/414a46c9-00b0-45aa-9c17-622c48860b9d)


## S11 - Cadastro de Treinos



