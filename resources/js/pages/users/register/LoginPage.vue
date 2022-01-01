<template>
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <img src="@/assets/brands/fa-9-lahlogo@3x.png" />
                            <h2> مرحبا بك فى فاصلة</h2>
                            <p> هيا بنا نسجل حساب جديد </p>
                        </div>

                        <div class="card-body">
                            <b-alert show variant="danger" v-if="result.status == 'error'">
                                <p > {{ result.message }} </p>
                            </b-alert>
                            <b-alert show variant="success" v-if="result.status == 'success'">
                                <p > {{ result.message }} </p>
                            </b-alert>
                            <validation-observer v-slot="{handleSubmit}" ref="formValidator">
                                <b-form role="form" @submit.prevent="handleSubmit(onSubmit)">
                                    <div class="form-group row">
                                        <label for="email" class="col-12 col-form-label text-md-right"> بريدك الالكترونى ؟ </label>

                                        <div class="col-12">
                                            <input id="email" type="email" class="form-control " v-model="model.email"  required autocomplete="email">

                                            <!-- @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror -->
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-12 col-form-label text-md-right">الكلمة السرية لحسابك</label>

                                        <div class="col-12">
                                            <input id="password" type="password" class="form-control " v-model="model.password" required autocomplete="new-password">

                                            <!-- @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror -->
                                        </div>
                                    </div>
                                    <div class="forget-password">
                                        <router-link class="btn btn-link" to="/password/reset">
                                            نسيت الكلمة السرية ؟
                                        </router-link>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">
                                            سجل دخول
                                            </button>
                                        </div>
                                    </div>

                                    <router-link v-if="typeof $route.params.barcode != 'undefined'" class="btn btn-link" :to="{path:'/register/'+$route.params.barcode}">
                                        هل لا تمتلك حساب ؟يمكنك انشاء حساب جديد
                                    </router-link>
                                </b-form>
                            </validation-observer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>
<script>
  import { mapActions } from 'vuex';
  export default {
    data() {
      return {
        model: {
          email: 'skyla.roob@example.com',
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
            if(this.$route.params.barcode){
                 self.model.barcode = this.$route.params.barcode;
            }
            this.$store.dispatch('auth/LoginAuth',this.model).then(() => {
                self.result.status  = 'success';
                self.result.message = 'You logged in successfully';
                setTimeout(() => {
                    this.$router.replace({name:'user-products'});
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
