import React from 'react';
import type { ReactNode } from 'react';
import { Navigate, useNavigate } from 'react-router-dom';
import { Calendar, Users, Scissors, LogOut, User, Shield } from 'lucide-react';
import { useAuth } from '../contexts/AuthContext';
import { Button } from './ui/Button';

interface LayoutProps {
  children: ReactNode;
}

const Layout: React.FC<LayoutProps> = ({ children }) => {
  const { usuario, logout, isAdmin } = useAuth();
  const navigate = useNavigate();

  if (!usuario) {
    return <Navigate to="/login" replace />;
  }

  const handleLogout = () => {
    logout();
    navigate('/login');
  };

  const menuItems = [
    {
      icon: <Calendar className="h-5 w-5" />,
      label: 'Agendamentos',
      path: '/agendamentos',
      adminOnly: false,
    },
    {
      icon: <Users className="h-5 w-5" />,
      label: 'Barbeiros',
      path: '/barbeiros',
      adminOnly: true,
    },
    {
      icon: <Scissors className="h-5 w-5" />,
      label: 'Especialidades',
      path: '/especialidades',
      adminOnly: true,
    },
  ];

  const filteredMenuItems = menuItems.filter(item => !item.adminOnly || isAdmin);

  return (
    <div className="min-h-screen bg-gray-50">
      {/* Header */}
      <header className="bg-white shadow-sm border-b">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center h-16">
            <div className="flex items-center space-x-2">
              <Scissors className="h-8 w-8 text-blue-600" />
              <h1 className="text-xl font-bold text-gray-900">ClickBeard</h1>
            </div>

            <div className="flex items-center space-x-4">
              <div className="flex items-center space-x-2">
                {isAdmin ? (
                  <Shield className="h-4 w-4 text-yellow-600" />
                ) : (
                  <User className="h-4 w-4 text-gray-600" />
                )}
                <span className="text-sm font-medium text-gray-700">
                  {usuario.nome}
                </span>
                {isAdmin && (
                  <span className="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">
                    Admin
                  </span>
                )}
              </div>
              <Button
                variant="ghost"
                size="sm"
                onClick={handleLogout}
                className="text-gray-600 hover:text-gray-900"
              >
                <LogOut className="h-4 w-4 mr-2" />
                Sair
              </Button>
            </div>
          </div>
        </div>
      </header>

      <div className="flex">
        {/* Sidebar */}
        <aside className="w-64 bg-white shadow-sm min-h-[calc(100vh-4rem)]">
          <nav className="mt-8">
            <div className="px-4 space-y-2">
              {filteredMenuItems.map((item) => (
                <button
                  key={item.path}
                  onClick={() => navigate(item.path)}
                  className={`w-full flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors ${
                    location.pathname === item.path
                      ? 'bg-blue-100 text-blue-700'
                      : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'
                  }`}
                >
                  {item.icon}
                  <span className="ml-3">{item.label}</span>
                </button>
              ))}
            </div>
          </nav>
        </aside>

        {/* Main Content */}
        <main className="flex-1 p-8">
          {children}
        </main>
      </div>
    </div>
  );
};

export default Layout;
