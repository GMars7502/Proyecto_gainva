import './bootstrap';
import '@fortawesome/fontawesome-free/css/all.min.css';
import karnessRegistroData from './karnessRegistro';
import InsumosRegistroData from './InsumosResgistro';

window.Alpine = Alpine; // Lo hace disponible globalmente (opcional pero útil)


Alpine.data('karnessRegistro', karnessRegistroData);
Alpine.data('InsumosRegistro', InsumosRegistroData);