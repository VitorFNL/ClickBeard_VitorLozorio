# ClickBeard

## Pré-requisitos

Antes de começar, certifique-se de ter instalado:

### Backend (Laravel)
- **PHP >= 8.2**
- **Composer**
- **MySQL/MariaDB**

### Frontend (React/TypeScript)
- **Node.js >= 18**
- **NPM ou Yarn**

## Instalação e Configuração

### 1. Clone o repositório
```bash
git clone https://github.com/VitorFNL/ClickBeard_VitorLozorio
cd ClickBeard_VitorLozorio
```

### 2. Configuração do Backend

#### 2.1. Navegar para o diretório do backend
```bash
cd backend
```

#### 2.2. Instalar dependências PHP
```bash
composer install
```

#### 2.3. Configurar banco de dados
Execute o script SQL fornecido no projeto:
```bash
mysql -u seu_usuario -p < ../banco.sql
```
Caso esteja no windows esse comando deverá ser executado no cmd, o mysql também deve estar no path

#### 2.4. Executar migrações
```bash
php artisan migrate
```

#### 2.5. Iniciar servidor do backend
```bash
php artisan serve
```

O backend estará disponível em: `http://localhost:8000`

### 3. Configuração do Frontend

#### 3.1. Navegar para o diretório do frontend (em outro terminal)
```bash
cd frontend
```

#### 3.2. Instalar dependências Node.js
```bash
npm install
```

#### 3.3. Iniciar servidor de desenvolvimento
```bash
npm run dev
```

O frontend estará disponível em: `http://localhost:5173`

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

### Especialidades
- `GET /api/especialidades` - Listar especialidades
- `PUT /api/cadastrarEspecialidade` - Cadastrar especialidade (Admin)

## Rotas do Frontend

| Rota | Componente | Descrição | Proteção |
|------|------------|-----------|----------|
| `/login` | LoginPage | Página de login | Pública |
| `/registro` | RegistroPage | Página de registro | Pública |
| `/agendamentos` | AgendamentosPage | Lista de agendamentos | Autenticada |
| `/barbeiros` | BarbeirosPage | Gestão de barbeiros | Admin |
| `/especialidades` | EspecialidadesPage | Gestão de especialidades | Admin |

## Autenticação

O sistema utiliza JWT (JSON Web Tokens) para autenticação:

1. Faça login em `/api/login`
2. O projeto é iniciado com o usuário admin@admin.com | admin123 com permissões de admin
3. O token é automaticamente armazenado em cookies
4. Todas as requisições autenticadas incluem o token automaticamente

### Middleware de Admin
Algumas rotas requerem privilégios de administrador (`admin: true` no usuário).

## Exemplos de Uso da API

### Registrar Usuário
```http
PUT /api/registrar
Content-Type: application/json

{
    "nome": "João Silva",
    "email": "joao@email.com",
    "senha": "123456"
}
```

### Fazer Login
```http
POST /api/login
Content-Type: application/json

{
    "email": "joao@email.com",
    "senha": "123456"
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