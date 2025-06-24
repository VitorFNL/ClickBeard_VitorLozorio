// Tipos para o sistema ClickBeard - Baseados nas migrations do banco de dados

export interface Usuario {
  // Campos reais do banco (tabela: usuarios)
  id: number; // usuario_id
  nome: string;
  email: string;
  admin: boolean; // campo boolean, não enum
  data_criacao?: string;
  data_atualizacao?: string;
  // Campos de compatibilidade com frontend existente
  tipo?: 'admin' | 'cliente'; // derivado do campo 'admin'
}

export interface Especialidade {
  // Campos reais do banco (tabela: especialidades)
  id: number; // especialidade_id
  descricao: string; // campo real no banco
  data_criacao?: string;
  data_atualizacao?: string;
  // Campos de compatibilidade com frontend existente (NÃO EXISTEM NO BANCO)
  nome?: string; // mapeado de 'descricao'
  preco?: number; // campo fictício para compatibilidade
  tempo_estimado?: number; // campo fictício para compatibilidade
}

export interface Barbeiro {
  // Campos reais do banco (tabela: barbeiros)
  id: number; // barbeiro_id
  nome: string;
  data_nascimento: string; // campo obrigatório no banco
  data_contratacao: string; // campo obrigatório no banco
  ativo: boolean; // status do barbeiro
  data_criacao?: string;
  data_atualizacao?: string;
  especialidades?: Especialidade[]; // relacionamento via tabela pivot
  // CAMPOS REMOVIDOS: email, telefone (NÃO EXISTEM NO BANCO)
}

export interface Agendamento {
  // Campos reais do banco (tabela: agendamentos)
  id: number; // agendamento_id
  usuario_id: number;
  barbeiro_id: number;
  especialidade_id: number;
  data_agendamento: string; // date
  hora_inicio: string; // time
  hora_fim: string; // time
  status_agendamento: 'AGENDADO' | 'CANCELADO' | 'CONCLUIDO'; // enum real do banco
  data_criacao?: string;
  data_atualizacao?: string;
  // Relacionamentos
  usuario?: Usuario;
  barbeiro?: Barbeiro;
  especialidade?: Especialidade;
  // Campos de compatibilidade com frontend existente
  horario?: string; // mapeado de hora_inicio
  status?: 'agendado' | 'cancelado' | 'concluido'; // mapeado de status_agendamento (lowercase)
}

// Tipos para requisições
export interface LoginRequest {
  email: string;
  senha: string;
}

export interface RegistroRequest {
  // Campos reais esperados pelo backend
  nome: string;
  email: string;
  senha: string;
  admin?: boolean; // campo real do banco para determinar se é admin
  // CAMPOS REMOVIDOS: telefone, senha_confirmation (não existem no banco)
}

export interface CadastrarAgendamentoRequest {
  // Campos reais esperados pelo backend
  barbeiro_id: number; // obrigatório
  especialidade_id: number;
  data: string; // data_agendamento (formato Y-m-d)
  hora: string; // hora_inicio (formato H:i)
  // Campos de compatibilidade para frontend existente
  data_agendamento?: string;
  horario?: string;
}

export interface CadastrarBarbeiroRequest {
  // Campos reais do banco
  nome: string;
  data_nascimento: string; // obrigatório (formato Y-m-d)
  data_contratacao: string; // obrigatório (formato Y-m-d)
  // CAMPOS REMOVIDOS: email, telefone, senha (NÃO EXISTEM NO BANCO)
}

export interface CadastrarEspecialidadeRequest {
  // Campo real do banco
  descricao: string; // campo real no banco
  // Campos de compatibilidade
  nome?: string; // mapeado para 'descricao'
  // CAMPOS REMOVIDOS: preco, tempo_estimado (NÃO EXISTEM NO BANCO)
}

export interface VincularEspecialidadesRequest {
  barbeiro_id: number;
  especialidades: number[];
}

// Tipos para respostas da API
export interface ApiResponse<T = any> {
  success: boolean;
  message: string;
  data?: T;
  errors?: Record<string, string[]>;
}

export interface LoginResponse {
  token: string;
  usuario: Usuario;
}

// Tipos para contexto de autenticação
export interface AuthContextType {
  usuario: Usuario | null;
  token: string | null;
  login: (email: string, senha: string) => Promise<void>;
  registro: (dados: RegistroRequest) => Promise<void>;
  logout: () => void;
  isAdmin: boolean; // baseado no campo 'admin' do usuário
  loading: boolean;
}

// Tipos para formulários
export interface FormErrors {
  [key: string]: string;
}

// Tipos para filtros e ordenação
export interface FiltrosAgendamento {
  data?: string; // data_agendamento (formato Y-m-d)
  barbeiro?: number; // barbeiro_id
  especialidade?: number; // especialidade_id
  // Compatibilidade com frontend existente
  data_inicio?: string;
  data_fim?: string;
  barbeiro_id?: number;
  status?: string;
}
