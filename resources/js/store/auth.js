import axios from 'axios';
const auth = {
    namespaced: true,
    state: {
        token: null,
        user: null,
    },
    getters: {
        Authenticated(state) {
            return state.token && state.user;
        },
        User(state) {
            return state.user;
        }
    },
    mutations: {
        SET_Token: function(state, token) {
            state.token = token;
        },
        SET_User: function(state, user) {
            state.user = user;
        }
    },
    actions: {
        // . You can do api call here to login
        async LoginAuth(_, credentials) {
            let response = await axios.post('/api/auth/login', credentials);
            console.log(response.data);
            return this.dispatch('auth/attempt', response.data.access_token);
        },
        async attempt(_, token) {
            this.commit('auth/SET_Token', token);
            try {
                let response = await axios.get('/api/auth/me');
                console.log(response);
                this.commit('auth/SET_User', response.data.data);
            } catch (e) {
                this.commit('auth/SET_Token', null);
                this.commit('auth/SET_User', null);
            }
        },
        LogOut(_) {
            let self = this;
            return axios.post('/api/auth/logout').then(() => {
                self.commit('auth/SET_Token', null);
                self.commit('auth/SET_User', null);
            });
        },
    }
};

export default auth;