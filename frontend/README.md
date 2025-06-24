# ClickBeard - Frontend

## 📋 Sobre o Projeto

Frontend do sistema ClickBeard desenvolvido em **React** com **TypeScript** e **Tailwind CSS**. Interface moderna e responsiva para gerenciamento de agendamentos de barbearia.

## 🚀 Tecnologias Utilizadas

- **React 18** - Biblioteca para interfaces de usuário
- **TypeScript** - Superset tipado do JavaScript
- **Tailwind CSS** - Framework CSS utilitário
- **React Router DOM** - Roteamento de páginas
- **Axios** - Cliente HTTP para consumir APIs
- **React Hook Form** - Gerenciamento de formulários
- **Zod** - Validação de schemas
- **Lucide React** - Biblioteca de ícones
- **date-fns** - Manipulação de datas

## 📦 Instalação e Configuração

### 1. Instalar dependências
```bash
npm install
```

### 2. Configurar variáveis de ambiente
Crie um arquivo `.env` na raiz do projeto:
```env
VITE_API_URL=http://localhost:8000/api
```

### 3. Executar em modo de desenvolvimento
```bash
npm run dev
```

A aplicação estará disponível em: `http://localhost:5173`

## 🏗️ Estrutura do Projeto

```
src/
├── components/           # Componentes React
│   ├── ui/              # Componentes de UI reutilizáveis
│   │   ├── Button.tsx
│   │   ├── Input.tsx
│   │   ├── Card.tsx
│   │   └── Alert.tsx
│   ├── pages/           # Páginas da aplicação
│   │   ├── LoginPage.tsx
│   │   ├── RegistroPage.tsx
│   │   ├── AgendamentosPage.tsx
│   │   ├── BarbeirosPage.tsx
│   │   └── EspecialidadesPage.tsx
│   ├── Layout.tsx       # Layout principal
│   └── CriarAgendamentoModal.tsx
├── contexts/            # Contextos React
│   └── AuthContext.tsx  # Contexto de autenticação
├── services/            # Serviços de API
│   └── api.ts           # Configuração do Axios e endpoints
├── types/               # Tipos TypeScript
│   └── index.ts         # Interfaces e tipos
├── lib/                 # Utilitários
│   └── utils.ts         # Funções auxiliares
├── App.tsx              # Componente raiz
├── main.tsx             # Ponto de entrada
└── index.css            # Estilos globais
```

## 🔐 Funcionalidades

### Autenticação
- ✅ Login de usuários
- ✅ Registro de novos usuários
- ✅ Logout seguro
- ✅ Proteção de rotas autenticadas
- ✅ Armazenamento seguro de tokens JWT

### Agendamentos
- ✅ Listagem de agendamentos
- ✅ Criação de novos agendamentos
- ✅ Cancelamento de agendamentos
- ✅ Filtros por data e barbeiro
- ✅ Visualização de status (agendado, cancelado, concluído)

### Gestão de Barbeiros (Admin)
- ✅ Listagem de barbeiros
- ✅ Cadastro de novos barbeiros
- ✅ Visualização de especialidades por barbeiro

### Gestão de Especialidades (Admin)  
- ✅ Listagem de especialidades
- ✅ Cadastro de novas especialidades
- ✅ Configuração de preços e tempos

## 🎨 Interface do Usuário

### Design System
- **Cores**: Esquema de cores consistente com tons de azul e cinza
- **Tipografia**: Família Inter para melhor legibilidade
- **Espaçamento**: Sistema consistente baseado no Tailwind
- **Componentes**: Biblioteca própria de componentes reutilizáveis

### Responsividade
- ✅ Layout adaptativo para desktop, tablet e mobile
- ✅ Menu lateral retrátil em dispositivos móveis
- ✅ Cards e tabelas responsivas
- ✅ Formulários otimizados para touch

## 🔒 Segurança

- **Autenticação JWT**: Tokens seguros armazenados no localStorage
- **Proteção de Rotas**: Middleware de autenticação para páginas protegidas
- **Validação de Formulários**: Validação client-side e server-side
- **Controle de Acesso**: Diferentes níveis de permissão (Cliente/Admin)

## 📱 Rotas da Aplicação

| Rota | Componente | Descrição | Proteção |
|------|------------|-----------|----------|
| `/login` | LoginPage | Página de login | Pública |
| `/registro` | RegistroPage | Página de registro | Pública |
| `/agendamentos` | AgendamentosPage | Lista de agendamentos | Autenticada |
| `/barbeiros` | BarbeirosPage | Gestão de barbeiros | Admin |
| `/especialidades` | EspecialidadesPage | Gestão de especialidades | Admin |

## 🚀 Scripts Disponíveis

```bash
# Desenvolvimento
npm run dev

# Build para produção
npm run build

# Visualizar build de produção
npm run preview

# Linting
npm run lint
```

## 🔧 Configuração do Backend

Certifique-se de que o backend Laravel esteja rodando em `http://localhost:8000` com as seguintes rotas configuradas:

- `PUT /api/registrar` - Registro de usuário
- `POST /api/login` - Login
- `POST /api/logout` - Logout
- `POST /api/agendamentos` - Listar agendamentos
- `PUT /api/agendar` - Criar agendamento
- `POST /api/cancelarAgendamento` - Cancelar agendamento
- `GET /api/barbeiros` - Listar barbeiros
- `PUT /api/cadastrarBarbeiro` - Cadastrar barbeiro (Admin)
- `PUT /api/cadastrarEspecialidade` - Cadastrar especialidade (Admin)

## 📞 Suporte

Para dúvidas ou problemas:
1. Verifique se o backend está rodando
2. Confirme se as URLs da API estão corretas
3. Verifique o console do navegador para erros
4. Certifique-se de que as dependências estão instaladas

## 🎯 Próximos Passos

- [ ] Implementar paginação na listagem de agendamentos
- [ ] Adicionar notificações push
- [ ] Implementar tema escuro
- [ ] Adicionar testes unitários
- [ ] Otimizar performance com lazy loading
