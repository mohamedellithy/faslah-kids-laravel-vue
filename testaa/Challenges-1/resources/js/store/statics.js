import axios from 'axios';
const statics = {
    namespaced: true,
    state: {
        statics_1: {},
        statics_2: {},
        statics_3: {},
        statics_4: {},
    },
    mutations: {
        SET_Statics_1: function(state, value) {
            state.statics_1 = value;
        },
        SET_Statics_2: function(state, value) {
            state.statics_2 = value;
        },
        SET_Statics_3: function(state, value) {
            state.statics_3 = value;
        },
        SET_Statics_4: function(state, value) {
            state.statics_4 = value;
        }
    },
    actions: {
        // . You can do api call here to login
        async GetStatics(_, credentials) {
            let response = await axios.get('/api/admin/statics', credentials);
            this.commit('statics/SET_Statics_1', response.data.data.part_1);
            this.commit('statics/SET_Statics_2', response.data.data.part_2);
            this.commit('statics/SET_Statics_3', response.data.data.part_3);
            this.commit('statics/SET_Statics_4', response.data.data.part_4);
            console.log(response.data.data);
        },
    }
};

export default statics;