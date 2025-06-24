# ClickBeard - Backend API

## Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- **PHP >= 8.2**
- **Composer**
- **MySQL/MariaDB**
- **Node.js & NPM** (para assets front-end, se necessário)

## Instalação e Configuração

### 1. Clone o repositório
```bash
git clone https://github.com/VitorFNL/ClickBeard_VitorLozorio
cd ClickBeard_VitorLozorio/backend
```

### 2. Instale as dependências PHP
```bash
composer install
```


### 3. Configure o banco de dados

Execute o script SQL fornecido no projeto:
```bash
mysql -u seu_usuario -p < ../banco.sql
```

Execute as migrações:
```bash
php artisan migrate
```

## Executando a Aplicação

### Servidor de Desenvolvimento
```bash
php artisan serve
```

A API estará disponível em: `http://localhost:8000`

## Endpoints da API

### Autenticação
- `PUT /api/registrar` - Registrar novo usuário
- `POST /api/login` - Fazer login
- `POST /api/logout` - Fazer logout (requer autenticação)

### Agendamentos
- `POST /api/agendamentos` - Listar agendamentos (com filtros)
- `PUT /api/agendar` - Criar novo agendamento
- `POST /api/cancelarAgendamento` - Cancelar agendamento

### Barbeiros
- `GET /api/barbeiros` - Listar barbeiros disponíveis
- `PUT /api/cadastrarBarbeiro` - Cadastrar barbeiro (Admin)
- `PUT /api/vincularEspecialidadesBarbeiro` - Vincular especialidades (Admin)

### Especialidades (Admin)
- `PUT /api/cadastrarEspecialidade` - Cadastrar especialidade

### Como usar:
1. Faça login em `/api/login`
2. Inclua o token no header das requisições:
```http
Authorization: Bearer SEU_TOKEN_JWT
```

### Middleware de Admin
Algumas rotas requerem privilégios de administrador (`admin: true` no usuário).


## Exemplos de Uso

### Registrar Usuário
```http
PUT /api/registrar
Content-Type: application/json

{
    "nome": "João Silva",
    "email": "joao@email.com",
    "senha": "123456",
    "data_nascimento": "1990-01-01"
}
```

### Criar Agendamento
```http
PUT /api/agendar
Authorization: Bearer TOKEN
Content-Type: application/json

{
    "especialidade_id": 1,
    "barbeiro_id": 3,
    "data": "2025-06-25",
    "hora": "14:30"
}
```

### Listar Agendamentos com Filtros
```http
POST /api/agendamentos
Authorization: Bearer TOKEN
Content-Type: application/json

{
    "data": "2025-06-25",
    "barbeiro": 3,
    "especialidade": 1
}
```