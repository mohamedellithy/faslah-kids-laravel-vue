<template>
    <div class="wrapper" >
        <nav class="navbar navbar-expand-md navbar-light  shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <img class="logo-layout" src="/images/fa-9-lahlogo@3x.png" />
                </a>
                <ul class="navbar-nav mr-auto items-mobile">

                    <router-link tag="li" :to="{path:'/my-account'}" >
                            <a >   حسابي </a>
                    </router-link>

                    <router-link tag="li" :to="{path:'/my-challenges/'+this.$store.getters['auth/Authenticated'].id}">
                            <a >   تحدياتى </a>
                    </router-link>

                    <router-link tag="li" to="/products" :class="[( (this.$route.name == 'user-challenges' ) || (this.$route.name == 'user-challenge' ) ? 'router-link-exact-active router-link-active' : '')]">
                            <a >   كل التحديات  </a>
                    </router-link>

                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                            <img alt="Image placeholder" src="@/assets/img/theme/sketch.jpg" v-if="this.$store.getters['auth/Authenticated'].image.length == 0">
                            <img :src="this.$store.getters['auth/Authenticated'].image.image_url" v-if="this.$store.getters['auth/Authenticated'].image.length != 0"/>

                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" style="cursor:pointer"
                                @click="logout_user">
                                تسجيل الخروج
                            </a>
                        </div>
                    </li>
                </ul>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto items">

                        <router-link tag="li" :to="{path:'/my-account'}" >
                              <a >   حسابي </a>
                        </router-link>

                        <router-link tag="li" :to="{path:'/my-challenges/'+this.$store.getters['auth/Authenticated'].id}">
                              <a >   تحدياتى </a>
                        </router-link>

                        <router-link tag="li" to="/products" :class="[( (this.$route.name == 'user-challenges' ) || (this.$route.name == 'user-challenge' ) ? 'router-link-exact-active router-link-active' : '')]">
                              <a >   كل التحديات  </a>
                        </router-link>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                    <img alt="Image placeholder" src="@/assets/img/theme/sketch.jpg" v-if="this.$store.getters['auth/Authenticated'].image.length == 0">
                                    <img :src="this.$store.getters['auth/Authenticated'].image.image_url" v-if="this.$store.getters['auth/Authenticated'].image.length != 0"/>

                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" style="cursor:pointer"
                                        @click="logout_user">
                                        تسجيل الخروج
                                    </a>
                                </div>
                            </li>

                    </ul>
                </div>
            </div>
        </nav>

        <div class="main-content">

            <div @click="$sidebar.displaySidebar(false)">
                <fade-transition :duration="200" origin="center top" mode="out-in">
                <!-- your content here -->
                  <slot> here put your content </slot>
                </fade-transition>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions } from 'vuex';
import { CollapseTransition } from 'vue2-transitions';
import { FadeTransition } from 'vue2-transitions';
export default {
  components: {
    CollapseTransition,
    FadeTransition
  },
  props: {
    type: {
      type: String,
      default: 'default', // default|light
      description: 'Look of the dashboard navbar. Default (Green) or light (gray)'
    }
  },

  computed: {
    routeName() {
      const { name } = this.$route;
      return this.capitalizeFirstLetter(name);
    }
  },
  data() {
    return {
      activeNotifications: false,
      showMenu: false,
      searchModalVisible: false,
      searchQuery: '',
    };
  },
  methods: {
    ...mapActions({
        LogOut : "auth/LogOut",
    }),
    logout_user(){
        this.$store.dispatch('auth/LogOut').then(() => {
            this.$router.replace({name:'login'})
        }).catch(() => {
            console.error('failed');
        });
    },
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    toggleNotificationDropDown() {
      this.activeNotifications = !this.activeNotifications;
    },
    closeDropDown() {
      this.activeNotifications = false;
    },
    getProfileImage(){
        return this.$store.getters['auth/Authenticated'].image.image_url;
    }
  }
};
</script>
