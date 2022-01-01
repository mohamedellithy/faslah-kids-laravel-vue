window.Vue = require('vue');

Vue.filter('excerpt', function(value) {
    let str = value.toString();
    str.replace(/<[^>]*>/g, '');
    return str;
});