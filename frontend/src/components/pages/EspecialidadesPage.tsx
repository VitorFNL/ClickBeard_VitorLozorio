import React, { useState, useEffect } from 'react';
import { Plus, Scissors, X } from 'lucide-react';
import { useAuth } from '../../contexts/AuthContext';
import { especialidadeService } from '../../services/api';
import Layout from '../Layout';
import { Button } from '../ui/Button';
import { Input } from '../ui/Input';
import { Card, CardContent, CardHeader, CardTitle } from '../ui/Card';
import { Alert, AlertDescription } from '../ui/Alert';
import type { Especialidade, CadastrarEspecialidadeRequest } from '../../types';

const EspecialidadesPage: React.FC = () => {
  const [especialidades, setEspecialidades] = useState<Especialidade[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [showCreateModal, setShowCreateModal] = useState(false);
  
  const { isAdmin } = useAuth();

  useEffect(() => {
    if (isAdmin) {
      carregarEspecialidades();
    }
  }, [isAdmin]);
  const carregarEspecialidades = async () => {
    try {
      setLoading(true);
      setError('');
      const especialidadesData = await especialidadeService.listar();
      setEspecialidades(especialidadesData);
    } catch (err: any) {
      setError(err.response?.data?.message || 'Erro ao carregar especialidades');
    } finally {
      setLoading(false);
    }
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
            <h1 className="text-2xl font-bold text-gray-900">Especialidades</h1>
            <p className="text-sm text-gray-600">
              Gerencie os serviços oferecidos pela barbearia
            </p>
          </div>
          <Button onClick={() => setShowCreateModal(true)}>
            <Plus className="h-4 w-4 mr-2" />
            Nova Especialidade
          </Button>
        </div>

        {error && (
          <Alert variant="destructive" closeable onClose={() => setError('')}>
            <AlertDescription>{error}</AlertDescription>
          </Alert>
        )}

        {/* Lista de Especialidades */}
        {loading ? (
          <div className="text-center py-8">
            <p className="text-gray-500">Carregando especialidades...</p>
          </div>
        ) : especialidades.length === 0 ? (
          <Card>
            <CardContent className="text-center py-8">
              <Scissors className="h-12 w-12 text-gray-400 mx-auto mb-4" />
              <p className="text-gray-500">Nenhuma especialidade cadastrada.</p>
              <Button 
                className="mt-4" 
                onClick={() => setShowCreateModal(true)}
              >
                Cadastrar Primeira Especialidade
              </Button>
            </CardContent>
          </Card>
        ) : (
          <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            {especialidades.map((especialidade) => (
              <Card key={especialidade.id}>                <CardHeader>
                  <CardTitle className="flex items-center">
                    <Scissors className="h-5 w-5 mr-2" />
                    {especialidade.descricao || especialidade.nome}
                  </CardTitle>
                </CardHeader>
                <CardContent>
                  <div className="space-y-2">
                    <div className="text-sm text-gray-600">
                      <p className="font-medium">ID:</p>
                      <p>{especialidade.id}</p>
                    </div>
                    <div className="text-xs text-gray-500 mt-3">
                      {especialidade.data_criacao && (
                        <p>Criado em: {new Date(especialidade.data_criacao).toLocaleDateString('pt-BR')}</p>
                      )}
                    </div>
                  </div>
                </CardContent>
              </Card>
            ))}
          </div>
        )}
      </div>

      {/* Modal de Criar Especialidade */}
      <CriarEspecialidadeModal
        isOpen={showCreateModal}
        onClose={() => setShowCreateModal(false)}
        onSuccess={carregarEspecialidades}
      />
    </Layout>
  );
};

// Modal para criar especialidade
interface CriarEspecialidadeModalProps {
  isOpen: boolean;
  onClose: () => void;
  onSuccess: () => void;
}

const CriarEspecialidadeModal: React.FC<CriarEspecialidadeModalProps> = ({
  isOpen,
  onClose,
  onSuccess,
}) => {  const [formData, setFormData] = useState<CadastrarEspecialidadeRequest>({
    descricao: '',
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
      await especialidadeService.criar(formData);
      onSuccess();
      onClose();      // Reset form
      setFormData({
        descricao: '',
      });
    } catch (err: any) {
      setError(err.response?.data?.message || 'Erro ao cadastrar especialidade');
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
              <Scissors className="h-5 w-5 mr-2" />
              Nova Especialidade
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
            )}            <div>
              <label className="block text-sm font-medium text-gray-700 mb-1">
                Descrição da Especialidade
              </label>
              <Input
                name="descricao"
                required
                value={formData.descricao}
                onChange={handleChange}
                placeholder="Ex: Corte de cabelo masculino + Barba"
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

export default EspecialidadesPage;
