# ClickBeard - Frontend

## Instalação e Configuração

### 1. Instalar dependências
```bash
npm install
```

### 2. Executar em modo de desenvolvimento
```bash
npm run dev
```

A aplicação estará disponível em: `http://localhost:5173`

## Rotas da Aplicação

| Rota | Componente | Descrição | Proteção |
|------|------------|-----------|----------|
| `/login` | LoginPage | Página de login | Pública |
| `/registro` | RegistroPage | Página de registro | Pública |
| `/agendamentos` | AgendamentosPage | Lista de agendamentos | Autenticada |
| `/barbeiros` | BarbeirosPage | Gestão de barbeiros | Admin |
| `/especialidades` | EspecialidadesPage | Gestão de especialidades | Admin |
