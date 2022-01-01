<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> 
                        <img src="/images/fa-9-lahlogo@3x.png" />
                        <p> اعادة ضبط كلمة المرور </p>   
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="EmailPassword">
                            <div class="form-group row">
                                <label for="email" class="col-md-12 col-form-label text-md-right">البريد الالكترونى</label>
                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control" v-model="dataResetPassword.email" required autocomplete="email" autofocus>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        ارسال رابط اعادة ضبط كلمة المرور
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
        return {
            dataResetPassword:{
                email:'',
            },
        }
    },
    methods: {
        EmailPassword(){
            let self = this;
            axios.post('/password/email',self.dataResetPassword).then(function(response){
                console.log(response);
            }).catch(function(error){
                console.log(error);
            });
        }
    }
}
</script>