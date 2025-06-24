import React, { createContext, useContext, useState, useEffect } from 'react';
import type { ReactNode } from 'react';
import type { AuthContextType, Usuario, RegistroRequest } from '../types';
import { authService } from '../services/api';
import { cookieUtils } from '../lib/cookies';

const AuthContext = createContext<AuthContextType | undefined>(undefined);

interface AuthProviderProps {
  children: ReactNode;
}

export const AuthProvider: React.FC<AuthProviderProps> = ({ children }) => {
  const [usuario, setUsuario] = useState<Usuario | null>(null);
  const [token, setToken] = useState<string | null>(null);
  const [loading, setLoading] = useState(true);  useEffect(() => {
    // Verificar se há token e dados do usuário salvos nos cookies
    const savedToken = cookieUtils.getCookie('jwt_token');
    const savedUser = cookieUtils.getUserData();

    if (savedToken && savedUser) {
      setToken(savedToken);
      setUsuario(savedUser);
    }

    setLoading(false);
  }, []);
  const login = async (email: string, senha: string): Promise<void> => {
    try {
      const response = await authService.login({ email, senha });
      
      if (!response.token) {
        throw new Error('Token não encontrado na resposta');
      }

      if (!response.usuario) {
        throw new Error('Dados do usuário não encontrados na resposta');
      }      setToken(response.token);
      setUsuario(response.usuario);
      
      // Salvar nos cookies (30 dias de validade)
      cookieUtils.setCookie('jwt_token', response.token, 30);
      cookieUtils.setUserData(response.usuario);
    } catch (error) {
      throw error;
    }
  };

  const registro = async (dados: RegistroRequest): Promise<void> => {
    try {
      await authService.registro(dados);
      // Após registro bem-sucedido, fazer login automaticamente
      await login(dados.email, dados.senha);
    } catch (error) {
      throw error;
    }
  };
  const logout = (): void => {
    authService.logout().catch(() => {
      // Ignorar erros no logout da API, limpar dados locais mesmo assim
    });
    
    setToken(null);
    setUsuario(null);
    
    // Remover cookies
    cookieUtils.removeCookie('jwt_token');
    cookieUtils.removeCookie('user_data');
  };

  // Determinar se é admin baseado no campo 'admin' do banco
  const isAdmin = usuario?.admin === true || usuario?.tipo === 'admin';

  const value: AuthContextType = {
    usuario,
    token,
    login,
    registro,
    logout,
    isAdmin,
    loading,
  };

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
};

export const useAuth = (): AuthContextType => {
  const context = useContext(AuthContext);
  if (context === undefined) {
    throw new Error('useAuth deve ser usado dentro de um AuthProvider');
  }
  return context;
};
