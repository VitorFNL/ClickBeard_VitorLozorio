// Utilitários para manipular cookies
export const cookieUtils = {
  // Obter um cookie pelo nome
  getCookie(name: string): string | null {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) {
      const cookieValue = parts.pop()?.split(';').shift();
      return cookieValue || null;
    }
    return null;
  },

  // Definir um cookie
  setCookie(name: string, value: string, days?: number): void {
    let expires = '';
    if (days) {
      const date = new Date();
      date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
      expires = `; expires=${date.toUTCString()}`;
    }
    document.cookie = `${name}=${value}${expires}; path=/; SameSite=Lax; Secure=${window.location.protocol === 'https:'}`;
  },

  // Remover um cookie
  removeCookie(name: string): void {
    document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; SameSite=Lax`;
  },

  // Utilitários específicos para dados de usuário
  setUserData(userData: any): void {
    this.setCookie('user_data', encodeURIComponent(JSON.stringify(userData)), 30);
  },

  getUserData(): any | null {
    const userData = this.getCookie('user_data');
    if (userData) {
      try {
        return JSON.parse(decodeURIComponent(userData));
      } catch (error) {
        console.error('Erro ao decodificar dados do usuário:', error);
        this.removeCookie('user_data');
        return null;
      }
    }
    return null;
  }
};
