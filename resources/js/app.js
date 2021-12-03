require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

setTimeout(function(){
    document.getElementById('flash').style.display = 'none';
}, 5000);
