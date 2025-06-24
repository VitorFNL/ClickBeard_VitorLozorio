import axios, { type AxiosResponse } from 'axios';
import { cookieUtils } from '../lib/cookies';
import type { 
  LoginRequest, 
  LoginResponse, 
  RegistroRequest,
  CadastrarAgendamentoRequest,
  CadastrarBarbeiroRequest,
  CadastrarEspecialidadeRequest,
  VincularEspecialidadesRequest,
  Usuario,
  Agendamento,
  Barbeiro,
  Especialidade,
  FiltrosAgendamento
} from '../types';

// Configuração base do axios
const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

// Interceptor para adicionar token de autenticação
api.interceptors.request.use(
  (config: any) => {
    // Buscar token do cookie
    const token = cookieUtils.getCookie('jwt_token');
    
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error: any) => {
    return Promise.reject(error);
  }
);

// Interceptor para tratar respostas e erros
api.interceptors.response.use(
  (response: any) => response,
  (error: any) => {
    if (error.response?.status === 401) {
      // Token expirado ou inválido - limpar cookies
      cookieUtils.removeCookie('jwt_token');
      cookieUtils.removeCookie('user_data');
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);

// Serviços de autenticação
export const authService = {
  async login(dados: LoginRequest): Promise<LoginResponse> {
    const response: AxiosResponse<any> = await api.post('/login', dados);
    

    if (response.data.status === 'success' && response.data.token) {
      const token = response.data.token;
      
      const usuarioData = response.data.usuario;

      const usuario: Usuario = {
        id: usuarioData.usuarioId,
        nome: usuarioData.nome,
        email: dados.email,
        admin: usuarioData.admin || false, // Usar valor fornecido ou padrão
        tipo: usuarioData.admin ? 'admin' : 'cliente'
      };

      return {
        token,
        usuario
      };
    }
    
    throw new Error('Resposta inválida do servidor');
  },

  async registro(dados: RegistroRequest): Promise<Usuario> {
    const response: AxiosResponse<any> = await api.put('/registrar', dados);
    
    // O backend retorna: { status: 'success', message: 'Usuário criado com sucesso', nome: 'nome_usuario' }
    if (response.data.status === 'success') {
      return {
        id: Date.now(), // ID temporário
        nome: response.data.nome || dados.nome,
        email: dados.email,
        admin: dados.admin || false, // Usar valor fornecido ou padrão
        // Campos de compatibilidade
        tipo: dados.admin ? 'admin' : 'cliente'
      };
    }
    
    throw new Error('Erro ao criar usuário');
  },  async logout(): Promise<void> {
    await api.post('/logout');
    // Limpar cookies
    cookieUtils.removeCookie('jwt_token');
    cookieUtils.removeCookie('user_data');
  },
};

// Serviços de agendamentos
export const agendamentoService = {  async listar(filtros?: FiltrosAgendamento): Promise<Agendamento[]> {
    // Mapear filtros para formato esperado pelo backend
    const filtrosBackend: any = {};
    if (filtros?.data) filtrosBackend.data = filtros.data;
    if (filtros?.barbeiro) filtrosBackend.barbeiro = filtros.barbeiro;
    if (filtros?.especialidade) filtrosBackend.especialidade = filtros.especialidade;    
    try {
      const response: AxiosResponse<any> = await api.post('/agendamentos', filtrosBackend);
        // O backend retorna: { status: 'success', message: '...', agendamentos: [...] }
      if (response.data.status === 'success' && response.data.agendamentos) {
        const agendamentos = response.data.agendamentos.map((agendamento: any) => ({
          ...agendamento,
          // Mapear campos para compatibilidade com frontend
          horario: agendamento.hora_inicio,
          status: agendamento.status_agendamento?.toLowerCase()
        }));
        
        return agendamentos;
      }
        return [];
    } catch (error) {
      throw error;
    }
  },

  async criar(dados: CadastrarAgendamentoRequest): Promise<Agendamento> {
    // Ajustar os nomes dos campos para o backend
    const dadosBackend = {
      especialidade_id: dados.especialidade_id,
      barbeiro_id: dados.barbeiro_id,
      data: dados.data || dados.data_agendamento,
      hora: dados.hora || dados.horario
    };
    
    const response: AxiosResponse<any> = await api.put('/agendar', dadosBackend);
    
    // O backend retorna: { status: 'success', message: '...', agendamento: { id, status } }
    if (response.data.status === 'success' && response.data.agendamento) {
      return {
        id: response.data.agendamento.id,
        usuario_id: 0, // Será preenchido pelo backend
        barbeiro_id: dados.barbeiro_id || 0,
        especialidade_id: dados.especialidade_id,
        data_agendamento: dados.data || dados.data_agendamento || '',
        hora_inicio: dados.hora || dados.horario || '',
        hora_fim: dados.hora || dados.horario || '', // Será calculado pelo backend
        status_agendamento: response.data.agendamento.status || 'AGENDADO',
        // Campos de compatibilidade
        horario: dados.hora || dados.horario || '',
        status: response.data.agendamento.status?.toLowerCase() || 'agendado'
      };
    }
    
    throw new Error('Erro ao criar agendamento');
  },

  async cancelar(agendamentoId: number): Promise<void> {
    await api.post('/cancelarAgendamento', { agendamento_id: agendamentoId });
  },
};

// Serviços de barbeiros
export const barbeiroService = {
  async listar(filtros?: { especialidade?: number, data?: string, hora?: string }): Promise<Barbeiro[]> {
    let url = '/barbeiros';
    const params = new URLSearchParams();
    
    if (filtros?.especialidade) {
      params.append('especialidade', filtros.especialidade.toString());
    }
    if (filtros?.data) {
      params.append('data', filtros.data);
    }
    if (filtros?.hora) {
      params.append('hora', filtros.hora);
    }
    
    if (params.toString()) {
      url += '?' + params.toString();
    }
    
    const response: AxiosResponse<any> = await api.get(url);
      // O backend retorna: { status: 'success', message: '...', barbeiros: [...] }
    if (response.data.status === 'success' && response.data.barbeiros) {
      return response.data.barbeiros.map((barbeiro: any) => ({
        ...barbeiro,
        id: typeof barbeiro.id === 'string' ? parseInt(barbeiro.id) : barbeiro.id,
        barbeiro_id: typeof barbeiro.barbeiro_id === 'string' ? parseInt(barbeiro.barbeiro_id) : barbeiro.barbeiro_id
      }));
    }
    
    return [];
  },
  async criar(dados: CadastrarBarbeiroRequest): Promise<Barbeiro> {
    // O backend espera APENAS: nome, data_nascimento, data_contratacao
    const dadosBackend = {
      nome: dados.nome,
      data_nascimento: dados.data_nascimento,
      data_contratacao: dados.data_contratacao
    };
    
    const response: AxiosResponse<any> = await api.put('/cadastrarBarbeiro', dadosBackend);
    
    // O backend retorna: { status: 'success', message: '...', barbeiro: { id, nome } }
    if (response.data.status === 'success' && response.data.barbeiro) {
      return {
        id: response.data.barbeiro.id,
        nome: response.data.barbeiro.nome,
        data_nascimento: dados.data_nascimento,
        data_contratacao: dados.data_contratacao,
        ativo: true // padrão do banco
      };
    }
    
    throw new Error('Erro ao criar barbeiro');
  },

  async vincularEspecialidades(dados: VincularEspecialidadesRequest): Promise<void> {
    await api.put('/vincularEspecialidadesBarbeiro', dados);
  },
};

// Serviços de especialidades
export const especialidadeService = {  async listar(): Promise<Especialidade[]> {
    const response: AxiosResponse<any> = await api.get('/especialidades');
    
    // O backend retorna: { status: 'success', message: '...', especialidades: [...] }
    if (response.data.status === 'success' && response.data.especialidades) {
      return response.data.especialidades.map((especialidade: any) => ({
        id: especialidade.id,
        descricao: especialidade.descricao,
        data_criacao: especialidade.data_criacao,
        data_atualizacao: especialidade.data_atualizacao,
        // Campos de compatibilidade com frontend
        nome: especialidade.descricao
      }));
    }
    
    throw new Error('Erro ao listar especialidades');
  },

  async criar(dados: CadastrarEspecialidadeRequest): Promise<Especialidade> {
    // O backend espera APENAS 'descricao'
    const dadosBackend = {
      descricao: dados.descricao || dados.nome || ''
    };
    
    const response: AxiosResponse<any> = await api.put('/cadastrarEspecialidade', dadosBackend);
    
    // O backend retorna: { status: 'success', message: '...', especialidade: { id, descricao } }
    if (response.data.status === 'success' && response.data.especialidade) {
      return {
        id: response.data.especialidade.id,
        descricao: response.data.especialidade.descricao,
        // Campos de compatibilidade com frontend (valores padrão)
        nome: response.data.especialidade.descricao
      };
    }
    
    throw new Error('Erro ao criar especialidade');
  },
};

export default api;
