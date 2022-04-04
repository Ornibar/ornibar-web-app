require('./bootstrap');
require('./partials/message.flash');
require('./partials/confirm-modal.js');

// Laravel 
import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()

// Vue
// Imports
import { createApp } from 'vue';
import router from './vue/router/router';
import axios from "axios";

// App vue
// import App from './vue/App';

// Components

// Define Vue - App
// createApp({
//     components: {
//         App,
//     },
//     router,
// }).use(router)
// .mount('#app');


// Personnals imports

// Select input
let selects = document.querySelectorAll('.select-input')
if (selects.length > 0) {
    selects.forEach(select => {
        select.addEventListener('click', () => {
            select.classList.toggle('open')
        })
        let input = select.querySelector('input')
        let label = select.querySelector('.label')
        let options = select.querySelectorAll('.select-options li')
        options.forEach(option => {
            option.addEventListener('click', () => {
                input.value = option.getAttribute('value')
                label.textContent = option.getAttribute('value')
            })
        })
    })
}

// Activate Switcher
let switchers = document.querySelectorAll('.activate-switcher')
if (switchers.length > 0) {
    switchers.forEach(switcher => {
        switcher.addEventListener('click', () => {
            // console.log(switcher)
            let active = false;
            if (switcher.classList.contains('activate')) {
                switcher.classList.remove('activate');
            } else {
                switcher.classList.add('activate');
                active = 1;
            }
            let data = {
                response_id   : parseInt(switcher.getAttribute('id')),
                question_id : parseInt(switcher.getAttribute('question_id')),
                active      : active
            }
            axios.patch(`${switcher.getAttribute('action')}`, data)
            .then(res => {
                // console.log(res);
                // switcher.classList.remove('activate');
                setMessageFlash(res.data.message, 'success', false, 1000);
            })
            .catch(err => {
                // console.log(err);
                setMessageFlash(err.data.message, 'error', false, 1000);
            })
        })
    });
}

