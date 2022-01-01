<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <img src="/images/fa-9-lahlogo@3x.png" />
                        <p> اعادة ضبط كلمة المرور </p>   
                    </div>

                    <div class="card-body">
                        <form @submit.prevent="ResetPassword">
                            <input type="hidden" name="token" v-model="this.$route.params.token">

                            <div class="form-group row">
                                <label for="email" class="col-md-12 col-form-label text-md-right">البريد الالكترونى</label>

                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control" v-model="dataResetPassword.email"  required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-12 col-form-label text-md-right">كلمة المرور</label>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control" v-model="dataResetPassword.password" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-12 col-form-label text-md-right">تأكيد كلمة المرور</label>

                                <div class="col-md-12">
                                    <input id="password-confirm" type="password" class="form-control" v-model="dataResetPassword.password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        اعادة ضبط كلمة المرور
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
       return{
            dataResetPassword:{
               email:'',
               password:'',
               password_confirmation:''
            }
       }
    },
    methods:{
        ResetPassword(){
            axios.post('/reset-password',this.dataResetPassword).then(function(response){
                console.log(response);
                console.log(this.dataResetPassword);
            }).catch(function(error){
                console.log(error.response);
            });
        }
    }
}
</script>