import './bootstrap';

import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

window.Alpine = Alpine;
window.Chart = Chart;
Alpine.start();
import Echo from 'laravel-echo';
window.Echo = new Echo({
    broadcaster: 'reverb',
    host: window.location.hostname + ':6001',
});
