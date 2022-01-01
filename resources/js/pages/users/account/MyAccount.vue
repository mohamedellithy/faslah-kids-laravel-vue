<template>
    <div class="">
        <user-layout>
           <main class="py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 container-full">
                            <div class="container-form-account">
                                <b-alert show variant="danger" v-if="status == 'error'">
                                    <p v-for="(error,field) in errors" :key="field"> {{ error[0] }} </p>
                                </b-alert>
                                <b-alert show variant="success" v-if="status == 'success'">
                                    <p > {{ message }} </p>
                                </b-alert>
                                <img class="image-icon-1" src="@/assets/img/bitmap@3x.png" />
                                <img class="image-icon-2" src="@/assets/img/bitmap-copy-3@3x.png" />
                                <img class="image-icon-3" src="@/assets/img/1bitmap@3x.png" />
                                <div class="card-body col-md-6 my-account-container">

                                    <form @submit.prevent="updateKidsinfoData" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <img class="img-personal" src="@/assets/img/theme/sketch.jpg" v-if="model.image.length == 0">
                                            <img class="img-personal" :src="tempo_image  ? tempo_image : model.image.image_url" v-else>

                                            <div class="col-12 container-upload-image">
                                                <label class="col-12 col-form-label title-change-image-personal"> تغير الصورة الشخصية </label>
                                                <button class="btn btn-info upload-image-personal">ارفع صورة الشخصية
                                                    <input type="file" @change="changePersonalImage">
                                                </button>

                                            </div>
                                        </div>
                                        <p class="title-form-account"> المعلومات الشخصية </p>


                                        <div class="form-group row">
                                            <label for="name" class="col-12 col-form-label text-md-right">اسمك</label>

                                            <div class="col-12">
                                                <input id="name" type="text" class="form-control" v-model="model.firstname"   autocomplete="name" autofocus>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="name" class="col-12 col-form-label text-md-right">اسم عائلتك</label>

                                            <div class="col-12">
                                                <input id="name" type="text" class="form-control" v-model="model.lastname"   autocomplete="name" autofocus>

                                                <!-- @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror -->
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="name" class="col-12 col-form-label text-md-right">عمرك</label>

                                            <div class="col-12">
                                                <select id="select-age" class="wide " v-model="model.age"  autocomplete="name" autofocus>
                                                    <option v-for="age in ages" :key="age">{{ age }}</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="email" class="col-12 col-form-label text-md-right">بريدك الإلكتروني</label>

                                            <div class="col-12">
                                                <input id="email" type="email" class="form-control" v-model="model.email"  autocomplete="email">
                                            </div>
                                        </div>



                                        <p class="title-form-account"> تغيير الكلمة السرّية </p>
                                        <div class="form-group row">
                                            <label for="password" class="col-12 col-form-label text-md-right">الكلمة السرية القديمة</label>

                                            <div class="col-12">
                                                <input id="password" type="password" class="form-control " v-model="model.old_password"  autocomplete="new-password">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password-confirm" class="col-12 col-form-label text-md-right">أدخل الكلمة السرّية الجديدة</label>

                                            <div class="col-12">
                                                <input id="password-confirm" type="password" class="form-control" v-model="model.password"  autocomplete="new-password">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="password-confirm" class="col-12 col-form-label text-md-right">أدخل الكلمة السرّية الجديدة مرة أخرى</label>

                                            <div class="col-12">
                                                <input id="password-confirm" type="password" class="form-control" v-model="model.password_confirmation"  autocomplete="new-password">
                                            </div>
                                        </div>

                                        <div class="form-group row mb-0">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">
                                                    حفظ التعديلات
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           </main>
        </user-layout>
    </div>
</template>
<script>
import UserLayout from '../UserLayout';
export default {
    components:{
       UserLayout
    },
    data(){
        return {
            model:{
                firstname:'',
                lastname:'',
                age:'',
                email:'',
                old_password:null,
                password:null,
                password_confirmation:null,
                image:[]
            },
            old_email:'',
            status:'',
            message:{},
            errors:{},
            ID:0,
            ages: _.range(3, 20),
            tempo_image :''
        }
    },
    created() {
        let self = this;
        this.ID       = this.$store.getters['auth/Authenticated'].id;
        axios.get('/api/kids/'+this.ID+'/edit').then(function(response){
            self.model        = response.data.data;
            self.old_email    = response.data.data.email;
            console.log(self.model);
        }).catch(function(error){
            console.log(error);
        });
    },
    methods:{
        changePersonalImage(event){
           this.model.image = event.target.files[0];
           this.tempo_image = URL.createObjectURL(event.target.files[0]);
        },
        updateKidsinfoData(){
            let self = this;
            let data = new FormData();
            data.append('firstname',this.model.firstname);
            data.append('lastname',this.model.lastname);
            data.append('age',this.model.age);

            if(this.model.old_password){
                data.append('old_password',this.model.old_password);
            }

            if(this.model.password){
                data.append('password',this.model.password);
            }

            if(this.model.password_confirmation){
                data.append('password_confirmation',this.model.password_confirmation);
            }

            if((this.model.image.length != 0) && (!this.model.image.image_url)){
                data.append('image',this.model.image);
            }else{
                data.append('image_id',this.model.image.id);
            }

            if(this.old_email != this.model.email){
                data.append('email',this.model.email);
            }

            console.log(typeof this.model.image);
            axios.post('/api/kids/'+this.ID,data).then(function(response){
                self.status  = response.data.status;
                self.message = response.data.message;
                console.log(response);
            }).catch(function(error){
                self.status  = error.response.data.status;
                self.errors  = error.response.data.message;
                console.log(error);
            });
        }
    }
}
</script>
