<template>
  <div>
    <!-- Header -->
    <div class="header bg-gradient-success py-7 py-lg-8 pt-lg-9">
      <b-container>
        <div class="header-body text-center mb-7">
          <b-row class="justify-content-center">
            <b-col xl="5" lg="6" md="8" class="px-5">
              <h1 class="text-white">Welcome!</h1>
              <p class="text-lead text-white">This Section For admin Only if you not have authority for login please leave Now.</p>
            </b-col>
          </b-row>
        </div>
      </b-container>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
             xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <b-container class="mt--8 pb-5">
      <b-row class="justify-content-center">
        <b-col lg="5" md="7">
          <b-card no-body class="bg-secondary border-0 mb-0">
            <b-card-body class="px-lg-5 py-lg-5">
                <div class="text-center text-muted mb-4">
                    <small>Or sign in with credentials</small>
                </div>
                <b-alert show variant="danger" v-if="result.status == 'error'">
                    <p > {{ result.message }} </p>
                </b-alert>
                 <b-alert show variant="success" v-if="result.status == 'success'">
                    <p > {{ result.message }} </p>
                </b-alert>
              <validation-observer v-slot="{handleSubmit}" ref="formValidator">
                <b-form role="form" @submit.prevent="handleSubmit(onSubmit)">
                  <base-input alternative
                              class="mb-3"
                              name="Email"
                              :rules="{required: true, email: true}"
                              prepend-icon="ni ni-email-83"
                              placeholder="Email"
                              v-model="model.email">
                  </base-input>

                  <base-input alternative
                              class="mb-3"
                              name="Password"
                              :rules="{required: true, min: 6}"
                              prepend-icon="ni ni-lock-circle-open"
                              type="password"
                              placeholder="Password"
                              v-model="model.password">
                  </base-input>

                  <b-form-checkbox v-model="model.rememberMe">Remember me</b-form-checkbox>
                  <div class="text-center">
                    <base-button type="primary" native-type="submit" class="my-4">Sign in</base-button>
                  </div>
                </b-form>
              </validation-observer>
            </b-card-body>
          </b-card>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>
<script>
  import { mapActions } from 'vuex';
  export default {
    data() {
      return {
        model: {
          email: 'libby.torp@example.net',
          password: 'password',
          rememberMe: false
        },
        result:{
            status:'',
            message:''
        },
      };
    },
    methods: {
        ...mapActions({
            LoginAuth:"auth/LoginAuth"
        }),
        onSubmit() {
            let self = this;
            // this will be called only after form is valid. You can do api call here to login
            this.$store.dispatch('auth/LoginAuth',this.model).then(() => {
                self.result.status  = 'success';
                self.result.message = 'You logged in successfully';
                setTimeout(() => {
                    this.$router.replace({name:'barcodes'});
                },2000);
            }).catch((error) => {
                self.result.status  = 'error';
                self.result.message = error.response.data.error;
                console.log(self.result);
            }).then(() => {

            });
        }
    }
  };
</script>
