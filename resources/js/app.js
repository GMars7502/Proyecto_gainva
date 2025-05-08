import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import karnessRegistroData from './karnessRegistro';

window.Alpine = Alpine; // Lo hace disponible globalmente (opcional pero útil)


Alpine.data('karnessRegistro', karnessRegistroData);