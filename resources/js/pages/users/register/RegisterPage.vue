<template>
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <img src="/images/fa-9-lahlogo@3x.png"/>
                            <h2> مرحبا بك فى فاصلة </h2>
                            <p> هيا بنا نسجل حساب جديد</p>
                        </div>

                        <div class="card-body">
                            <b-alert show variant="danger" v-if="result.status == 'error'">
                                <div v-if="typeof result.status == 'string' ">
                                    <p >
                                    {{ result.message }}
                                    </p>
                                </div>
                                <div v-else>
                                    <p v-for="(error,field) in result.message" :key="field">
                                    {{ error[0] }}
                                    </p>
                                </div>
                            </b-alert>
                            <b-alert show variant="success" v-if="result.status == 'success'">
                                <p > {{ result.message }} </p>
                            </b-alert>
                            <form @submit.prevent="CreateNewUserTypeKids">

                                <div class="form-group row">
                                    <label for="name" class="col-12 col-form-label text-md-right">ما هو اسمك ؟</label>

                                    <div class="col-12">
                                        <input id="name" type="text" class="form-control" v-model="model.firstname"  required autocomplete="name" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-12 col-form-label text-md-right">ما هو اسم عائلتك ؟</label>

                                    <div class="col-12">
                                        <input id="name" type="text" class="form-control" v-model="model.lastname"  required autocomplete="name" autofocus>

                                        <!-- @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror -->
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-12 col-form-label text-md-right">كم عمرك ؟</label>

                                    <div class="col-12">
                                        <select id="select-age" class="wide " v-model="model.age" required autocomplete="name" autofocus>
                                            <option v-for="age in ages" :key="age">{{ age }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-12 col-form-label text-md-right">ما هو بريدك الالكترونى ؟</label>

                                    <div class="col-12">
                                        <input id="email" type="email" class="form-control" v-model="model.email" required autocomplete="email">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-12 col-form-label text-md-right">اختر كلمة سرية لحسابك</label>

                                    <div class="col-12">
                                        <input id="password" type="password" class="form-control " v-model="model.password" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-12 col-form-label text-md-right">قم بتأكيد الكلمة السرية التى قمت باختيارها</label>

                                    <div class="col-12">
                                        <input id="password-confirm" type="password" class="form-control" v-model="model.password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">
                                            سجل حساب جديد
                                        </button>
                                    </div>
                                </div>

                                <router-link class="btn btn-link" :to="{path:'/login/'+$route.params.barcode}">
                                    هل بالفعل تمتلك حساب ؟ يمكنك تسجيل الدخول
                                </router-link>
                            </form>
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
            model:{
                firstname:'',
                lastname:'',
                age:'',
                email:'',
                password:'',
                password_confirmation:'',
                barcode:null
            },
            result:{
                status:'',
                message:{},
            },
            ages: _.range(3, 20),
        }
    },
    methods:{
         ...mapActions({
            LoginAuth:"auth/LoginAuth"
        }),
        CreateNewUserTypeKids(){
            let self = this;
            self.model.barcode = this.$route.params.barcode;
            console.log(self.model);
            axios.post('/api/auth/register',self.model).then(function(response){
                console.log(response.data);
                self.$store.dispatch('auth/LoginAuth',{email:self.model.email,password:self.model.password}).then(() => {
                    self.result.status  = response.data.status;
                    self.result.message = response.data.message;
                    setTimeout(() => {
                        self.$router.replace({name:'user-products'});
                    },2000);
                }).catch((error) => {
                    self.result.status  = 'error';
                    self.result.message = error.response.data.error;
                });

            }).catch(function(error){
                self.result.status  = 'error';
                self.result.message = error.response.data.error;
                console.log(error.response.data);
            });
        }
    }
}
</script>
