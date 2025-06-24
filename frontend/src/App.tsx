import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import { AuthProvider } from './contexts/AuthContext';
import LoginPage from './components/pages/LoginPage';
import RegistroPage from './components/pages/RegistroPage';
import AgendamentosPage from './components/pages/AgendamentosPage';
import BarbeirosPage from './components/pages/BarbeirosPage';
import EspecialidadesPage from './components/pages/EspecialidadesPage';

function App() {
  return (
    <AuthProvider>
      <Router>
        <div className="App">
          <Routes>
            <Route path="/login" element={<LoginPage />} />
            <Route path="/registro" element={<RegistroPage />} />
            <Route path="/agendamentos" element={<AgendamentosPage />} />
            <Route path="/barbeiros" element={<BarbeirosPage />} />
            <Route path="/especialidades" element={<EspecialidadesPage />} />
            <Route path="/" element={<Navigate to="/agendamentos" replace />} />
          </Routes>
        </div>
      </Router>
    </AuthProvider>
  );
}

export default App;
