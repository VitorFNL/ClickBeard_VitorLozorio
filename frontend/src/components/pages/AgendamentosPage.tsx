import React, { useState, useEffect } from 'react';
import { Plus } from 'lucide-react';
import { useAuth } from '../../contexts/AuthContext';
import { agendamentoService } from '../../services/api';
import Layout from '../Layout';
import NovoAgendamentoModal from '../NovoAgendamentoModal';
import { Button } from '../ui/Button';
import type { Agendamento } from '../../types';

const AgendamentosPage: React.FC = () => {
  const [agendamentos, setAgendamentos] = useState<Agendamento[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');
  const [showNovoAgendamentoModal, setShowNovoAgendamentoModal] = useState(false);
  const [cancelandoId, setCancelandoId] = useState<number | null>(null);
  
  const { usuario, loading: authLoading } = useAuth();  const carregarDados = async () => {
    try {
      setLoading(true);
      setError('');
      
      const agendamentosData = await agendamentoService.listar({});
      setAgendamentos(agendamentosData);
    } catch (err: any) {
      setError(err.response?.data?.message || err.message || 'Erro ao carregar dados');
    } finally {
      setLoading(false);
    }
  };

  const cancelarAgendamento = async (agendamentoId: number) => {
    if (!confirm('Tem certeza que deseja cancelar este agendamento?')) {
      return;
    }

    try {
      setCancelandoId(agendamentoId);
      setError('');
      
      await agendamentoService.cancelar(agendamentoId);
      
      // Recarregar a lista de agendamentos
      await carregarDados();
    } catch (err: any) {
      setError(err.response?.data?.message || err.message || 'Erro ao cancelar agendamento');
    } finally {
      setCancelandoId(null);
    }
  };

  useEffect(() => {
    carregarDados();
  }, []);

  // Se ainda está carregando a autenticação, mostrar loading
  if (authLoading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <p className="text-gray-500">Carregando...</p>
      </div>
    );
  }
  // Se não há usuário, o Layout vai redirecionar
  if (!usuario) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <p className="text-gray-500">Redirecionando...</p>
      </div>
    );
  }

  return (
    <Layout>
      <div className="space-y-6">
        {/* Header com botão de novo agendamento */}
        <div className="flex justify-between items-center">
          <div>
            <h1 className="text-2xl font-bold text-gray-900">Agendamentos</h1>
            <p className="text-sm text-gray-600">
              Gerencie seus agendamentos de barbearia
            </p>
          </div>
          <Button
            onClick={() => setShowNovoAgendamentoModal(true)}
            className="flex items-center gap-2"
          >
            <Plus className="h-4 w-4" />
            Novo Agendamento
          </Button>
        </div>

        {error && (
          <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <strong>Erro:</strong> {error}
          </div>
        )}

        {loading ? (
          <div className="text-center py-8">
            <p className="text-gray-500">Carregando agendamentos...</p>
          </div>
        ) : (
          <div className="space-y-4">
            {agendamentos.length === 0 ? (
              <div className="bg-gray-50 p-6 rounded-lg text-center">
                <p className="text-gray-500 mb-4">Nenhum agendamento encontrado.</p>
                <Button
                  onClick={() => setShowNovoAgendamentoModal(true)}
                  className="flex items-center gap-2"
                >
                  <Plus className="h-4 w-4" />
                  Criar Primeiro Agendamento
                </Button>
              </div>
            ) : (
              <div className="space-y-3">
                <div className="flex justify-between items-center">
                  <h2 className="text-lg font-semibold">Seus Agendamentos ({agendamentos.length})</h2>
                </div>
                {agendamentos.map((agendamento, index) => (
                  <div key={agendamento.id || index} className="bg-white p-6 rounded-lg border shadow-sm">
                    <div className="flex justify-between items-start">
                      <div className="space-y-2">
                        <div className="flex items-center gap-4">
                          <h3 className="font-semibold text-lg">
                            {agendamento.especialidade?.descricao || agendamento.especialidade?.nome || 'Especialidade'}
                          </h3>
                          <span className={`px-2 py-1 text-xs font-medium rounded-full ${
                            agendamento.status === 'agendado' || agendamento.status_agendamento === 'AGENDADO'
                              ? 'bg-green-100 text-green-800'
                              : agendamento.status === 'cancelado' || agendamento.status_agendamento === 'CANCELADO'
                              ? 'bg-red-100 text-red-800'
                              : 'bg-gray-100 text-gray-800'
                          }`}>
                            {agendamento.status || agendamento.status_agendamento || 'Agendado'}
                          </span>
                        </div>                        <div className="text-gray-600 space-y-1">
                          <p><strong>Data:</strong> {
                            agendamento.data_agendamento 
                              ? new Date(agendamento.data_agendamento + 'T00:00:00').toLocaleDateString('pt-BR')
                              : 'Data não disponível'
                          }</p>
                          <p><strong>Horário:</strong> {
                            agendamento.hora_inicio || agendamento.horario || 'Horário não disponível'
                          }</p>
                          {agendamento.barbeiro && <p><strong>Barbeiro:</strong> {agendamento.barbeiro.nome}</p>}
                        </div>
                      </div>                      {(agendamento.status === 'agendado' || agendamento.status_agendamento === 'AGENDADO') && (
                        <Button 
                          variant="destructive" 
                          size="sm"
                          onClick={() => cancelarAgendamento(agendamento.id)}
                          disabled={cancelandoId === agendamento.id}
                        >
                          {cancelandoId === agendamento.id ? 'Cancelando...' : 'Cancelar'}
                        </Button>
                      )}
                    </div>
                  </div>
                ))}
              </div>
            )}
          </div>
        )}

        {/* Modal de Novo Agendamento */}
        <NovoAgendamentoModal
          isOpen={showNovoAgendamentoModal}
          onClose={() => setShowNovoAgendamentoModal(false)}
          onSuccess={() => {
            setShowNovoAgendamentoModal(false);
            carregarDados(); // Recarregar a lista
          }}
        />
      </div>
    </Layout>
  );
};

export default AgendamentosPage;
