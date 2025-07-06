
import '@fortawesome/fontawesome-free/css/all.min.css';
import './bootstrap';
import karnessRegistroData from './karnessRegistro';
import InsumosRegistroData from './InsumosResgistro';
import ControlCebadoData from './ControlCebado';
import PetitorioList from './petitoriolist';
import petitorioCrear from './petitorioCrear';
import petitorioEdit from'./petitorioEditar';


Alpine.data('karnessRegistro', karnessRegistroData);
Alpine.data('InsumosRegistro', InsumosRegistroData);
Alpine.data('ControlCebado', ControlCebadoData);
Alpine.data('PetitorioList', PetitorioList);
Alpine.data('petitorioCrear', petitorioCrear);
Alpine.data('petitorioEditar',petitorioEdit);