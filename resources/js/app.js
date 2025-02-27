import Alpine from 'alpinejs';
import Sortable from "sortablejs";

window.Sortable = Sortable; // ✅ Ensure SortableJS is available globally

Alpine.start();
window.Alpine = Alpine; 
