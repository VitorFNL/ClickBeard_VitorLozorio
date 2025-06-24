import React, { useState, useEffect } from 'react';
import { Plus, Users, X, Settings, Calendar } from 'lucide-react';
import { useAuth } from '../../contexts/AuthContext';
import { barbeiroService, especialidadeService } from '../../services/api';
import Layout from '../Layout';
import { Button } from '../ui/Button';
import { Input } from '../ui/Input';
import { Card, CardContent, CardHeader, CardTitle } from '../ui/Card';
import { Alert, AlertDescription } from '../ui/Alert';
import type { Barbeiro, CadastrarBarbeiroRequest, Especialidade } from '../../types';

const BarbeirosPage: React.FC = () => {
  const [barbeiros, setBarbeiros] = useState<Barbeiro[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [showCreateModal, setShowCreateModal] = useState(false);
  const [showEditModal, setShowEditModal] = useState(false);
  const [barbeiroSelecionado, setBarbeiroSelecionado] = useState<Barbeiro | null>(null);
  
  const { isAdmin } = useAuth();

  useEffect(() => {
    if (isAdmin) {
      carregarBarbeiros();
    }
  }, [isAdmin]);
  const carregarBarbeiros = async () => {
    try {
      setLoading(true);
      const barbeirosData = await barbeiroService.listar();
      setBarbeiros(barbeirosData);
    } catch (err: any) {
      setError(err.response?.data?.message || 'Erro ao carregar barbeiros');
    } finally {
      setLoading(false);
    }
  };

  const abrirModalEdicao = (barbeiro: Barbeiro) => {
    setBarbeiroSelecionado(barbeiro);
    setShowEditModal(true);
  };

  const fecharModalEdicao = () => {
    setBarbeiroSelecionado(null);
    setShowEditModal(false);
  };

  if (!isAdmin) {
    return (
      <Layout>
        <div className="text-center py-8">
          <Alert variant="warning">
            <AlertDescription>
              Você não tem permissão para acessar esta página.
            </AlertDescription>
          </Alert>
        </div>
      </Layout>
    );
  }

  return (
    <Layout>
      <div className="space-y-6">
        {/* Header */}
        <div className="flex justify-between items-center">
          <div>
            <h1 className="text-2xl font-bold text-gray-900">Barbeiros</h1>
            <p className="text-sm text-gray-600">
              Gerencie os barbeiros da barbearia
            </p>
          </div>
          <Button onClick={() => setShowCreateModal(true)}>
            <Plus className="h-4 w-4 mr-2" />
            Novo Barbeiro
          </Button>
        </div>

        {error && (
          <Alert variant="destructive" closeable onClose={() => setError('')}>
            <AlertDescription>{error}</AlertDescription>
          </Alert>
        )}

        {/* Lista de Barbeiros */}
        {loading ? (
          <div className="text-center py-8">
            <p className="text-gray-500">Carregando barbeiros...</p>
          </div>
        ) : barbeiros.length === 0 ? (
          <Card>
            <CardContent className="text-center py-8">
              <Users className="h-12 w-12 text-gray-400 mx-auto mb-4" />
              <p className="text-gray-500">Nenhum barbeiro cadastrado.</p>
              <Button 
                className="mt-4" 
                onClick={() => setShowCreateModal(true)}
              >
                Cadastrar Primeiro Barbeiro
              </Button>
            </CardContent>
          </Card>
        ) : (
          <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            {barbeiros.map((barbeiro) => (
              <Card key={barbeiro.id}>
                <CardHeader>                  <CardTitle className="flex items-center justify-between">
                    <div className="flex items-center">
                      <Users className="h-5 w-5 mr-2" />
                      {barbeiro.nome}
                    </div>
                    <Button 
                      variant="ghost" 
                      size="sm"
                      onClick={() => abrirModalEdicao(barbeiro)}
                      title="Editar barbeiro"
                    >
                      <Settings className="h-4 w-4" />
                    </Button>
                  </CardTitle>
                </CardHeader>                <CardContent>
                  <div className="space-y-2 text-sm">
                    <div className="flex items-center text-gray-600">
                      <Calendar className="h-4 w-4 mr-2" />
                      Nascimento: {new Date(barbeiro.data_nascimento).toLocaleDateString('pt-BR')}
                    </div>
                    <div className="flex items-center text-gray-600">
                      <Calendar className="h-4 w-4 mr-2" />
                      Contratação: {new Date(barbeiro.data_contratacao).toLocaleDateString('pt-BR')}
                    </div>
                    <div className="flex items-center">
                      <div className={`h-2 w-2 rounded-full mr-2 ${barbeiro.ativo ? 'bg-green-500' : 'bg-red-500'}`} />
                      <span className={`text-xs font-medium ${barbeiro.ativo ? 'text-green-700' : 'text-red-700'}`}>
                        {barbeiro.ativo ? 'Ativo' : 'Inativo'}
                      </span>
                    </div>
                    {barbeiro.especialidades && barbeiro.especialidades.length > 0 && (
                      <div className="mt-3">
                        <p className="text-xs font-medium text-gray-700 mb-1">Especialidades:</p>
                        <div className="flex flex-wrap gap-1">
                          {barbeiro.especialidades.map((esp) => (
                            <span
                              key={esp.id}
                              className="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full"
                            >
                              {esp.nome}
                            </span>
                          ))}
                        </div>
                      </div>
                    )}
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        )}
      </div>      {/* Modal de Criar Barbeiro */}
      <CriarBarbeiroModal
        isOpen={showCreateModal}
        onClose={() => setShowCreateModal(false)}
        onSuccess={carregarBarbeiros}
      />

      {/* Modal de Editar Barbeiro */}
      {barbeiroSelecionado && (
        <EditarBarbeiroModal
          isOpen={showEditModal}
          barbeiro={barbeiroSelecionado}
          onClose={fecharModalEdicao}
          onSuccess={() => {
            carregarBarbeiros();
            fecharModalEdicao();
          }}
        />
      )}
    </Layout>
  );
};

// Modal para criar barbeiro
interface CriarBarbeiroModalProps {
  isOpen: boolean;
  onClose: () => void;
  onSuccess: () => void;
}

const CriarBarbeiroModal: React.FC<CriarBarbeiroModalProps> = ({
  isOpen,
  onClose,
  onSuccess,
}) => {  const [formData, setFormData] = useState<CadastrarBarbeiroRequest>({
    nome: '',
    data_nascimento: '',
    data_contratacao: new Date().toISOString().split('T')[0], // Data atual por padrão
  });
  
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError('');

    try {
      await barbeiroService.criar(formData);
      onSuccess();
      onClose();      // Reset form
      setFormData({
        nome: '',
        data_nascimento: '',
        data_contratacao: new Date().toISOString().split('T')[0],
      });
    } catch (err: any) {
      setError(err.response?.data?.message || 'Erro ao cadastrar barbeiro');
    } finally {
      setLoading(false);
    }
  };

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
      <Card className="w-full max-w-md">
        <CardHeader>
          <CardTitle className="flex items-center justify-between">
            <div className="flex items-center">
              <Users className="h-5 w-5 mr-2" />
              Novo Barbeiro
            </div>
            <Button
              variant="ghost"
              size="sm"
              onClick={onClose}
            >
              <X className="h-4 w-4" />
            </Button>
          </CardTitle>
        </CardHeader>
        <CardContent>
          <form onSubmit={handleSubmit} className="space-y-4">
            {error && (
              <Alert variant="destructive">
                <AlertDescription>{error}</AlertDescription>
              </Alert>
            )}

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Nome
              </label>
              <Input
                name="nome"
                required
                value={formData.nome}
                onChange={handleChange}
                placeholder="Nome do barbeiro"
              />
            </div>            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Data de Nascimento
              </label>
              <Input
                type="date"
                name="data_nascimento"
                required
                value={formData.data_nascimento}
                onChange={handleChange}
              />
            </div>

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Data de Contratação
              </label>
              <Input
                type="date"
                name="data_contratacao"
                required
                value={formData.data_contratacao}
                onChange={handleChange}
              />
            </div>

            <div className="flex justify-end space-x-2 pt-4">
              <Button
                type="button"
                variant="outline"
                onClick={onClose}
              >
                Cancelar
              </Button>
              <Button
                type="submit"
                disabled={loading}
              >
                {loading ? 'Cadastrando...' : 'Cadastrar'}
              </Button>
            </div>
          </form>
        </CardContent>
      </Card>
    </div>
  );
};

// Modal para editar barbeiro (vincular especialidades)
interface EditarBarbeiroModalProps {
  isOpen: boolean;
  barbeiro: Barbeiro;
  onClose: () => void;
  onSuccess: () => void;
}

const EditarBarbeiroModal: React.FC<EditarBarbeiroModalProps> = ({
  isOpen,
  barbeiro,
  onClose,
  onSuccess,
}) => {
  const [especialidades, setEspecialidades] = useState<Especialidade[]>([]);
  const [especialidadesSelecionadas, setEspecialidadesSelecionadas] = useState<number[]>([]);
  const [loading, setLoading] = useState(false);
  const [loadingEspecialidades, setLoadingEspecialidades] = useState(false);
  const [error, setError] = useState('');

  useEffect(() => {
    if (isOpen) {
      carregarEspecialidades();
      // Inicializar com as especialidades já vinculadas ao barbeiro
      const especialidadesVinculadas = barbeiro.especialidades?.map(esp => esp.id) || [];
      setEspecialidadesSelecionadas(especialidadesVinculadas);
    }
  }, [isOpen, barbeiro]);

  const carregarEspecialidades = async () => {
    try {
      setLoadingEspecialidades(true);
      const especialidadesData = await especialidadeService.listar();
      setEspecialidades(especialidadesData);
    } catch (err: any) {
      setError('Erro ao carregar especialidades');
    } finally {
      setLoadingEspecialidades(false);
    }
  };

  const toggleEspecialidade = (especialidadeId: number) => {
    setEspecialidadesSelecionadas(prev => {
      if (prev.includes(especialidadeId)) {
        return prev.filter(id => id !== especialidadeId);
      } else {
        return [...prev, especialidadeId];
      }
    });
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError('');

    try {      await barbeiroService.vincularEspecialidades({
        barbeiro_id: barbeiro.id,
        especialidades: especialidadesSelecionadas
      });
      onSuccess();
    } catch (err: any) {
      setError(err.response?.data?.message || 'Erro ao vincular especialidades');
    } finally {
      setLoading(false);
    }
  };

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50">
      <Card className="w-full max-w-md max-h-[80vh] overflow-y-auto">
        <CardHeader>
          <CardTitle className="flex items-center justify-between">
            <div className="flex items-center">
              <Settings className="h-5 w-5 mr-2" />
              Editar Barbeiro: {barbeiro.nome}
            </div>
            <Button
              variant="ghost"
              size="sm"
              onClick={onClose}
            >
              <X className="h-4 w-4" />
            </Button>
          </CardTitle>
        </CardHeader>
        <CardContent>
          <form onSubmit={handleSubmit} className="space-y-4">
            {error && (
              <Alert variant="destructive">
                <AlertDescription>{error}</AlertDescription>
              </Alert>
            )}

            <div>
              <label className="block text-sm font-medium text-gray-700 mb-3">
                Especialidades do Barbeiro
              </label>
              
              {loadingEspecialidades ? (
                <div className="text-center py-4">
                  <p className="text-gray-500">Carregando especialidades...</p>
                </div>
              ) : especialidades.length === 0 ? (
                <div className="text-center py-4">
                  <p className="text-gray-500">Nenhuma especialidade disponível</p>
                </div>
              ) : (
                <div className="space-y-2 max-h-60 overflow-y-auto">
                  {especialidades.map((especialidade) => (
                    <div
                      key={especialidade.id}
                      className="flex items-center space-x-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer"
                      onClick={() => toggleEspecialidade(especialidade.id)}
                    >
                      <input
                        type="checkbox"
                        checked={especialidadesSelecionadas.includes(especialidade.id)}
                        onChange={() => toggleEspecialidade(especialidade.id)}
                        className="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                      />
                      <label className="flex-1 text-sm cursor-pointer">
                        {especialidade.descricao || especialidade.nome}
                      </label>
                    </div>
                  ))}
                </div>
              )}
            </div>

            <div className="text-sm text-gray-600 bg-gray-50 p-3 rounded">
              <p><strong>Especialidades selecionadas:</strong> {especialidadesSelecionadas.length}</p>
            </div>

            <div className="flex justify-end space-x-2 pt-4">
              <Button
                type="button"
                variant="outline"
                onClick={onClose}
              >
                Cancelar
              </Button>
              <Button
                type="submit"
                disabled={loading || loadingEspecialidades}
              >
                {loading ? 'Salvando...' : 'Salvar Especialidades'}
              </Button>
            </div>
          </form>
        </CardContent>
      </Card>
    </div>
  );
};

export default BarbeirosPage;
