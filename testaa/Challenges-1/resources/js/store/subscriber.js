import store from '@/store';
import axios from 'axios';

store.subscribe((mutation) => {
    switch (mutation.type) {
        case 'auth/SET_Token':
            // console.log(mutation.payload + 'hi');
            if (mutation.payload) {
                axios.defaults.headers.common['Authorization'] = `Bearer ${mutation.payload}`;
                window.localStorage.setItem('token', mutation.payload);

            } else {
                axios.defaults.headers.common['Authorization'] = null;
                window.localStorage.removeItem('token');
            }
            break;
    }

});