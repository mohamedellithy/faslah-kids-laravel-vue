<template>
  <div class="wrapper">
    <notifications></notifications>
    <side-bar>
      <template slot="links">
        <sidebar-item
            :link="{
                name: 'Barcodes',
                icon: 'ni ni-tv-2 text-primary',
            }"
            >
            <sidebar-item
              :link="{ name: 'show barcodes', path: this.$root.adminUrl + '/barcodes/' }"
            ></sidebar-item>

            <sidebar-item
                :link="{ name: 'create Barcode', path: this.$root.adminUrl + '/barcodes/create/' }"
            ></sidebar-item>

        </sidebar-item>

        <sidebar-item
            :link="{
              name: 'Products',
              path: '/icons',
              icon: 'ni ni-planet text-blue'
              }"
            >
            <sidebar-item
              :link="{ name: 'show Products', path: this.$root.adminUrl + '/products/' }"
            ></sidebar-item>

            <sidebar-item
                :link="{ name: 'create Product', path: this.$root.adminUrl + '/products/create/' }"
            ></sidebar-item>

        </sidebar-item>

        <sidebar-item
              :link="{
                name: 'Challenges',
                icon: 'ni ni-pin-3 text-orange'
            }">
            <sidebar-item
              :link="{ name: 'show Challenge', path: this.$root.adminUrl + '/challenges/' }"
            ></sidebar-item>

            <sidebar-item
                :link="{ name: 'create Challenge', path: this.$root.adminUrl + '/challenges/create/' }"
            ></sidebar-item>

        </sidebar-item>

        <sidebar-item
              :link="{
                name: 'Kids',
                icon: 'ni ni-single-02 text-yellow'
                }">
                <sidebar-item
                    :link="{ name: 'show Kids', path: this.$root.adminUrl + '/Kids/' }"
                ></sidebar-item>

                <sidebar-item
                    :link="{ name: 'create Kids', path: this.$root.adminUrl + '/Kids/create/' }"
                ></sidebar-item>

        </sidebar-item>

      </template>
    </side-bar>
    <div class="main-content">
      <dashboard-navbar :type="$route.meta.navbarType"></dashboard-navbar>

      <div @click="$sidebar.displaySidebar(false)">
        <fade-transition :duration="200" origin="center top" mode="out-in">
          <!-- your content here -->
          <router-view></router-view>
        </fade-transition>
      </div>
      <content-footer v-if="!$route.meta.hideFooter"></content-footer>
    </div>
  </div>
</template>
<script>
  /* eslint-disable no-new */
  import PerfectScrollbar from 'perfect-scrollbar';
  import 'perfect-scrollbar/css/perfect-scrollbar.css';

  function hasElement(className) {
    return document.getElementsByClassName(className).length > 0;
  }

  function initScrollbar(className) {
    if (hasElement(className)) {
      new PerfectScrollbar(`.${className}`);
    } else {
      // try to init it later in case this component is loaded async
      setTimeout(() => {
        initScrollbar(className);
      }, 100);
    }
  }

  import DashboardNavbar from './Layout/DashboardNavbar.vue';
  import ContentFooter from './Layout/ContentFooter.vue';
  import DashboardContent from './Layout/Content.vue';
  import { FadeTransition } from 'vue2-transitions';

  export default {
    components: {
      DashboardNavbar,
      ContentFooter,
      DashboardContent,
      FadeTransition
    },
    methods: {
      initScrollbar() {
        let isWindows = navigator.platform.startsWith('Win');
        if (isWindows) {
          initScrollbar('sidenav');
        }
      }
    },
    mounted() {
      this.initScrollbar()
    }
  };
</script>
<style lang="scss">
</style>
