import BaseInput from '../components/Inputs/BaseInput.vue';
import BaseDropdown from '../components/BaseDropdown.vue';
import Card from '../components/Cards/Card.vue';
import Modal from '../components/Modal.vue';
import StatsCard from '../components/Cards/StatsCard.vue';
import BaseButton from '../components/BaseButton.vue';
import BaseSwitch from '../components/BaseSwitch.vue';
import Badge from '../components/Badge.vue';
import BaseCheckbox from '../components/Inputs/BaseCheckbox.vue';
import BaseRadio from "../components/Inputs/BaseRadio";
import BaseProgress from "../components/BaseProgress";
import BasePagination from "../components/BasePagination";
import BaseAlert from "../components/BaseAlert";
import BaseNav from "../components/Navbar/BaseNav";
import BaseHeader from '../components/BaseHeader';
import StaticsRow from '@/components/statics/StaticsRow';
import { ValidationProvider, ValidationObserver } from 'vee-validate';
import { Input, Tooltip, Popover } from 'element-ui';

import 'jquery/dist/jquery.min.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import "datatables.net-dt/js/dataTables.dataTables"
import "datatables.net-dt/css/jquery.dataTables.min.css"
/**
 * You can register global components here and use them as a plugin in your main Vue instance
 */

const GlobalComponents = {
    install(Vue) {
        Vue.component(Badge.name, Badge);
        Vue.component(BaseAlert.name, BaseAlert);
        Vue.component(BaseButton.name, BaseButton);
        Vue.component(BaseCheckbox.name, BaseCheckbox);
        Vue.component(BaseHeader.name, BaseHeader);
        Vue.component(BaseInput.name, BaseInput);
        Vue.component(BaseDropdown.name, BaseDropdown);
        Vue.component(BaseNav.name, BaseNav);
        Vue.component(BasePagination.name, BasePagination);
        Vue.component(BaseProgress.name, BaseProgress);
        Vue.component(BaseRadio.name, BaseRadio);
        Vue.component(BaseSwitch.name, BaseSwitch);
        Vue.component(Card.name, Card);
        Vue.component(Modal.name, Modal);
        Vue.component(StatsCard.name, StatsCard);
        Vue.component(Input.name, Input);
        Vue.component(StaticsRow.name, StaticsRow);
        Vue.component('validation-provider', ValidationProvider)
        Vue.component('validation-observer', ValidationObserver)
        Vue.use(Tooltip);
        Vue.use(Popover);
    }
};

export default GlobalComponents;