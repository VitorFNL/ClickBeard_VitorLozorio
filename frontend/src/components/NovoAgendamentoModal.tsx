import React, { useState, useEffect } from 'react';
import { X, Calendar, User, ChevronRight, ChevronLeft } from 'lucide-react';
import { barbeiroService, agendamentoService, especialidadeService } from '../services/api';
import { Button } from './ui/Button';
import { Input } from './ui/Input';
import { Card, CardContent, CardHeader, CardTitle } from './ui/Card';
import { Alert, AlertDescription } from './ui/Alert';
import type { Barbeiro, Especialidade, CadastrarAgendamentoRequest } from '../types';

interface NovoAgendamentoModalProps {
  isOpen: boolean;
  onClose: () => void;
  onSuccess: () => void;
}

const NovoAgendamentoModal: React.FC<NovoAgendamentoModalProps> = ({
  isOpen,
  onClose,
  onSuccess,
}) => {
  // Estados do fluxo
  const [step, setStep] = useState(1); // 1: Especialidade e Horário, 2: Barbeiros Disponíveis, 3: Confirmação
  const [especialidades, setEspecialidades] = useState<Especialidade[]>([]);
  const [barbeirosDisponiveis, setBarbeirosDisponiveis] = useState<Barbeiro[]>([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState('');

  // Dados do agendamento
  const [selectedEspecialidade, setSelectedEspecialidade] = useState<number>(0);
  const [selectedData, setSelectedData] = useState('');
  const [selectedHora, setSelectedHora] = useState('');
  const [selectedBarbeiro, setSelectedBarbeiro] = useState<number>(0);

  // Reset do modal
  const resetModal = () => {
    setStep(1);
    setSelectedEspecialidade(0);
    setSelectedData('');
    setSelectedHora('');
    setSelectedBarbeiro(0);
    setBarbeirosDisponiveis([]);
    setError('');
  };

  useEffect(() => {
    if (isOpen) {
      carregarEspecialidades();
      resetModal();
    }
  }, [isOpen]);

  const carregarEspecialidades = async () => {
    try {
      setLoading(true);
      const especialidadesData = await especialidadeService.listar();
      setEspecialidades(especialidadesData);
    } catch (err: any) {
      setError('Erro ao carregar especialidades');
    } finally {
      setLoading(false);
    }
  };  const buscarBarbeirosDisponiveis = async () => {
    try {
      setLoading(true);
      setError('');
      setSelectedBarbeiro(0); // Reset da seleção de barbeiro
      
      // Buscar barbeiros disponíveis para a especialidade, data e hora selecionadas
      const barbeirosData = await barbeiroService.listar({
        especialidade: selectedEspecialidade,
        data: selectedData,
        hora: selectedHora
      });
      
      setBarbeirosDisponiveis(barbeirosData);
      setStep(2);
    } catch (err: any) {
      setError('Erro ao buscar barbeiros disponíveis para este horário');
    } finally {
      setLoading(false);
    }
  };

  const confirmarAgendamento = async () => {
    try {
      setLoading(true);
      setError('');

      const agendamentoData: CadastrarAgendamentoRequest = {
        especialidade_id: selectedEspecialidade,
        barbeiro_id: selectedBarbeiro,
        data: selectedData,
        hora: selectedHora,
      };

      await agendamentoService.criar(agendamentoData);
      onSuccess();
      onClose();
      resetModal();
    } catch (err: any) {
      setError(err.response?.data?.message || 'Erro ao criar agendamento');
    } finally {
      setLoading(false);
    }
  };

  const podeAvancarStep1 = selectedEspecialidade > 0 && selectedData && selectedHora;
  const podeAvancarStep2 = selectedBarbeiro > 0;

  const horarios = [
    '08:00', '08:30', '09:00', '09:30', '10:00', '10:30',
    '11:00', '11:30', '14:00', '14:30', '15:00', '15:30',
    '16:00', '16:30', '17:00', '17:30', '18:00'
  ];

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center">
      {/* Overlay */}
      <div 
        className="absolute inset-0 bg-black bg-opacity-50" 
        onClick={onClose}
      />
      
      {/* Modal */}
      <div className="relative bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <Card>
          <CardHeader>
            <div className="flex items-center justify-between">
              <CardTitle className="flex items-center gap-2">
                <Calendar className="h-5 w-5" />
                Novo Agendamento
              </CardTitle>
              <Button
                variant="ghost"
                size="sm"
                onClick={onClose}
              >
                <X className="h-4 w-4" />
              </Button>
            </div>
            
            {/* Indicador de Steps */}
            <div className="flex items-center gap-2 mt-4">
              <div className={`flex items-center gap-2 ${step >= 1 ? 'text-blue-600' : 'text-gray-400'}`}>
                <div className={`w-6 h-6 rounded-full flex items-center justify-center text-xs ${step >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-200'}`}>
                  1
                </div>
                <span className="text-sm">Especialidade e Horário</span>
              </div>
              <ChevronRight className="h-4 w-4 text-gray-400" />
              <div className={`flex items-center gap-2 ${step >= 2 ? 'text-blue-600' : 'text-gray-400'}`}>
                <div className={`w-6 h-6 rounded-full flex items-center justify-center text-xs ${step >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-200'}`}>
                  2
                </div>
                <span className="text-sm">Barbeiro</span>
              </div>
              <ChevronRight className="h-4 w-4 text-gray-400" />
              <div className={`flex items-center gap-2 ${step >= 3 ? 'text-blue-600' : 'text-gray-400'}`}>
                <div className={`w-6 h-6 rounded-full flex items-center justify-center text-xs ${step >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-200'}`}>
                  3
                </div>
                <span className="text-sm">Confirmação</span>
              </div>
            </div>
          </CardHeader>

          <CardContent className="space-y-6">
            {error && (
              <Alert variant="destructive">
                <AlertDescription>{error}</AlertDescription>
              </Alert>
            )}

            {/* Step 1: Especialidade e Horário */}
            {step === 1 && (
              <div className="space-y-4">
                <h3 className="text-lg font-medium">Selecione a especialidade e horário</h3>
                
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Especialidade
                  </label>
                  <select
                    className="w-full h-12 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm"
                    value={selectedEspecialidade}
                    onChange={(e) => setSelectedEspecialidade(Number(e.target.value))}
                  >
                    <option value={0}>Selecione uma especialidade</option>
                    {especialidades.map(especialidade => (
                      <option key={especialidade.id} value={especialidade.id}>
                        {especialidade.descricao || especialidade.nome}
                      </option>
                    ))}
                  </select>
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Data
                  </label>
                  <Input
                    type="date"
                    value={selectedData}
                    onChange={(e) => setSelectedData(e.target.value)}
                    min={new Date().toISOString().split('T')[0]}
                  />
                </div>

                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Horário
                  </label>
                  <div className="grid grid-cols-4 gap-2">
                    {horarios.map(horario => (
                      <button
                        key={horario}
                        type="button"
                        className={`p-2 text-sm rounded border ${
                          selectedHora === horario
                            ? 'bg-blue-600 text-white border-blue-600'
                            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50'
                        }`}
                        onClick={() => setSelectedHora(horario)}
                      >
                        {horario}
                      </button>
                    ))}
                  </div>
                </div>
              </div>
            )}            {/* Step 2: Barbeiros Disponíveis */}
            {step === 2 && (
              <div className="space-y-4">
                <h3 className="text-lg font-medium">Selecione o barbeiro</h3>
                <p className="text-sm text-gray-600">
                  Especialidade: {especialidades.find(e => e.id === selectedEspecialidade)?.descricao} •
                  Data: {new Date(selectedData + 'T00:00:00').toLocaleDateString('pt-BR')} •
                  Horário: {selectedHora}
                </p>
                
                {loading ? (
                  <div className="text-center py-8">
                    <p className="text-gray-500">Buscando barbeiros disponíveis...</p>
                  </div>                ) : barbeirosDisponiveis.length === 0 ? (
                  <div className="text-center py-8">
                    <p className="text-gray-500 mb-2">Nenhum barbeiro disponível para este horário.</p>
                    <p className="text-sm text-gray-400 mb-4">Tente selecionar outro horário ou data.</p>
                    <Button
                      variant="outline"
                      onClick={() => setStep(1)}
                      className="mx-auto"
                    >
                      Escolher Outro Horário
                    </Button>
                  </div>
                ) : (                  <div className="grid gap-3">
                    {barbeirosDisponiveis.map((barbeiro, index) => {
                      // Tentar encontrar um ID válido
                      const barbeiroAny = barbeiro as any;
                      const barbeiroId = barbeiro.id || barbeiroAny.barbeiro_id || barbeiroAny.barbeiroId || index;
                      const numericId = Number(barbeiroId);
                      const isSelected = selectedBarbeiro === numericId;
                      
                      return (
                        <div
                          key={barbeiroId}
                          className={`p-4 rounded-lg border cursor-pointer transition-colors ${
                            isSelected
                              ? 'bg-blue-50 border-blue-600'
                              : 'bg-white border-gray-200 hover:bg-gray-50'
                          }`}
                          onClick={() => setSelectedBarbeiro(numericId)}
                        >
                          <div className="flex items-center gap-3">
                            <div className="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                              <User className="h-5 w-5 text-gray-600" />
                            </div>
                            <div>
                              <div className="font-medium">{barbeiro.nome}</div>
                              <div className="text-sm text-gray-600">
                                Disponível em {selectedHora}
                              </div>
                            </div>
                            {isSelected && (
                              <div className="ml-auto">
                                <div className="w-4 h-4 bg-blue-600 rounded-full flex items-center justify-center">
                                  <div className="w-2 h-2 bg-white rounded-full" />
                                </div>
                              </div>
                            )}
                          </div>
                        </div>
                      );
                    })}
                  </div>
                )}
              </div>
            )}

            {/* Step 3: Confirmação */}
            {step === 3 && (
              <div className="space-y-4">
                <h3 className="text-lg font-medium">Confirmar agendamento</h3>
                
                <div className="bg-gray-50 p-4 rounded-lg space-y-2">
                  <div className="flex justify-between">
                    <span className="text-gray-600">Especialidade:</span>
                    <span className="font-medium">
                      {especialidades.find(e => e.id === selectedEspecialidade)?.descricao}
                    </span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-gray-600">Data:</span>
                    <span className="font-medium">
                      {new Date(selectedData + 'T00:00:00').toLocaleDateString('pt-BR')}
                    </span>
                  </div>
                  <div className="flex justify-between">
                    <span className="text-gray-600">Horário:</span>
                    <span className="font-medium">{selectedHora}</span>
                  </div>                  <div className="flex justify-between">
                    <span className="text-gray-600">Barbeiro:</span>
                    <span className="font-medium">
                      {barbeirosDisponiveis.find(b => {
                        const barbeiroAny = b as any;
                        const barbeiroId = b.id || barbeiroAny.barbeiro_id || barbeiroAny.barbeiroId;
                        return Number(barbeiroId) === selectedBarbeiro;
                      })?.nome}
                    </span>
                  </div>
                </div>
              </div>
            )}

            {/* Botões de Navegação */}
            <div className="flex justify-between pt-4">
              <div>
                {step > 1 && (
                  <Button
                    variant="outline"
                    onClick={() => setStep(step - 1)}
                    disabled={loading}
                  >
                    <ChevronLeft className="h-4 w-4 mr-2" />
                    Voltar
                  </Button>
                )}
              </div>
              
              <div className="space-x-2">
                <Button
                  variant="outline"
                  onClick={onClose}
                  disabled={loading}
                >
                  Cancelar
                </Button>
                
                {step === 1 && (
                  <Button
                    onClick={buscarBarbeirosDisponiveis}
                    disabled={!podeAvancarStep1 || loading}
                  >
                    {loading ? 'Carregando...' : 'Buscar Barbeiros'}
                    <ChevronRight className="h-4 w-4 ml-2" />
                  </Button>
                )}
                  {step === 2 && (
                  <Button
                    onClick={() => setStep(3)}
                    disabled={!podeAvancarStep2 || loading || barbeirosDisponiveis.length === 0}
                  >
                    Revisar
                    <ChevronRight className="h-4 w-4 ml-2" />
                  </Button>
                )}
                
                {step === 3 && (
                  <Button
                    onClick={confirmarAgendamento}
                    disabled={loading}
                  >
                    {loading ? 'Criando...' : 'Confirmar Agendamento'}
                  </Button>
                )}
              </div>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  );
};

export default NovoAgendamentoModal;
