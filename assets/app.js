import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

// Flowbite with Trubo
import { initFlowbite } from 'flowbite';

document.addEventListener('turbo:render', () => {
    console.log('Turbo render event detected');
    initFlowbite();
    console.log('Flowbite initialized on turbo:render');
});

document.addEventListener('turbo:frame-render', () => {
    console.log('Turbo frame render event detected');
    initFlowbite();
    console.log('Flowbite initialized on turbo:frame-render');
});