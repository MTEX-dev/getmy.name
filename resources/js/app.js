import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Chart from 'chart.js/auto';
import 'chartjs-adapter-date-fns';

window.Chart = Chart;