<template>
    <div class="">
        <user-layout>
           <main class="py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">

                            <div class="single-challenge-card">
                                <h2 class="single-title-challenge">{{ this.challenge.title }}</h2>
                                <div class="col-12 single-challenges-data">
                                    <div class="col_sm_6 single-section-my">
                                        <img class="my-challenge-image" :src="[this.$store.getters['auth/Authenticated'].image.length != 0 ? this.$store.getters['auth/Authenticated'].image.image_url : require('@/assets/img/theme/sketch.jpg')]" />
                                        <span class="my-challenge-name">{{ this.$store.getters['auth/Authenticated'].fullname }}</span>
                                        <a class="share-challenge" v-b-modal.modal-1>شارك التحدي
                                            <i class="fas fa-share-alt"></i>
                                        </a>
                                    </div>
                                    <div class="col_sm_6 single-section-challenges">
                                        <span class="single-kides-take-challenge">
                                            <img v-for="index in count_kids_image(challenge.count_challenger)" class="taker-challenge-image" :src="challenge.images_kids[index] ? challenge.images_kids[index].image_url : require('../../../assets/img/team-4.jpg')" :key="index"/>
                                            <p class="count-takers-challenge">{{ challenge.count_challenger }} طفل أكملوا هذا التحدّي</p>
                                        </span>
                                    </div>
                                </div>
                                <div class="image-card">
                                    <img :src="challenge.image.image_url"/>
                                </div>
                                <div class="content-challenge" v-html="challenge.description"></div>
                            </div>

                            <div class="upload-my-solve-challenge"  v-if="next_challenge == this.$route.params.challenge_id">
                                <p @click="startUpload = true" class="upload-your-image-here" v-if="startUpload == false">
                                    <i class="fas fa-plus-circle"></i>
                                        ارفع تحديك هنا
                                </p>
                                <div class="container-solution-upload" v-else>
                                       <b-alert show variant="success" v-if="this.status == 'success' ">
                                            <strong> Success! </strong> {{ message }}
                                        </b-alert>

                                        <b-alert show variant="danger" v-if="this.status == 'error'">
                                            <p v-for="(error,index) in this.errors" :key="index"> {{ error }} </p>
                                        </b-alert>
                                       <form @submit.prevent="uploadSolutionsImages" enctype="multipart/form-data">
                                              <div class="container-solution-upload-images">
                                                  <h3> ارفع تحدّيك </h3>
                                                  <p class="upload-solution-images">
                                                       <input @change="uploadimage" class="input-upload-file" type="file" multiple >
                                                       <i class="fas fa-plus-circle"></i>
                                                          ارفع صورك هنا
                                                  </p>
                                                  <div class="container-images-solutions">
                                                       <table>
                                                            <tr v-for="(image,index) in images" :key="index">
                                                                <td class="container-image">
                                                                    <img class="img-fluid" :src="imageUrl(image)"/>
                                                                </td>
                                                                <td class="container-name">
                                                                    {{ image.name}}
                                                                </td>
                                                                <td>
                                                                   <i @click="removeImage(index)" class="fas fa-times-circle"></i>
                                                                </td>
                                                            </tr>
                                                       </table>
                                                  </div>
                                              </div>
                                              <div class="container-solution-form-description">
                                                  <h3> أضف وصف مشروعك </h3>
                                                  <textarea v-model="description" rows="5" class="form-control"></textarea>
                                              </div>
                                              <button type="submit" class="upload-solution-images"> انشر تحدّيك </button>
                                       </form>
                                </div>
                            </div>

                            <div class="col-md-12 card-my-challenge my-solution-card" v-else-if="next_challenge > this.$route.params.challenge_id">
                                <div class="col-md-6">
                                    <div class="image-card">
                                        <img class="img-responsive" :src="this.challenge.image.image_url"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="content-card">
                                        <router-link tag="h2" :to="{path:`/my-solution-challenge/${my_solution.id}`}" class="my-challenge-title">{{ challenge.title }}</router-link>
                                        <p  class="my-challenge-content" >{{ this.removetags(challenge.description) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="upload-my-solve-challenge"  v-else>
                                  <p class="upload-your-image-here" style="background-color: rgb(244 202 216);border: 2px dashed #e91e63;">
                                      لم يفتح التحدى لك حتى الان الرجاء اكمال التحديات السابقة
                                  </p>
                            </div>

                            <div class="others-projects">
                                <h2 class="others-projects-kids">مشاريع أنجزها الأطفال الآخرين</h2>
                                <div class="col-12 container-others-challenge">
                                   <div class="col-md-4 col-sm-6 card-others-challenge" v-for="(other,index) in others_challenger" :key="index">
                                          <img :src="[ other.challenges[0].image.length !=0 ? other.challenges[0].image.image_url :  require('@/assets/img/theme/sketch.jpg') ]"/>
                                          <p>
                                              <img class="my-challenge-image" :src="[ other.image.length !=0 ? other.image.image_url :  require('@/assets/img/theme/sketch.jpg') ]"  />
                                              <router-link tag="span" :to="{path:'/my-challenges/'+other.id}" class="my-challenge-name">{{ other.fullname }}</router-link>
                                          </p>
                                   </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </main>
        </user-layout>
        <b-modal id="modal-1"  ok-title="تم المشاركة" cancel-title="الغاء المشاركة">
            <p class="my-4 title-toggle-share-post">مشاركة التحدي على مواقع التواصل الاجتماعى</p>
            <div class="social-links">
                  <i @click="sharePage('facebook')" class="fab fa-facebook"></i>
                  <i @click="sharePage('whatsapp')" class="fab fa-whatsapp"></i>
                  <i @click="sharePage('linkedin')" class="fab fa-linkedin"></i>
                  <i @click="sharePage('twitter')" class="fab fa-twitter"></i>

            </div>
        </b-modal>
        <img v-if="celebrate == true" :src="require('../../../assets/img/4M57.gif')" style="position: absolute;top: 10%;left: 0;bottom: 10%;right: 0;width: 100%;">
    </div>
</template>
<script>
import UserLayout from '../UserLayout';
export default {
    components:{
       UserLayout
    },
    data(){
        return{
           challenge:{},
           my_solution:{},
           ID:0,
           kid_id:0,
           next_challenge:0,
           ended_challenges:{},
           others_challenger:{},
           startUpload:false,
           images:[],
           description:'',
           status:'',
           messsage:'',
           errors:{},
           audio_url:'',
           celebrate:false
        }
    },
    created(){
        let self    = this;
        this.ID     = this.$route.params.challenge_id;
        this.kid_id = this.$store.getters['auth/Authenticated'].id;
        axios.get('/api/challenges/'+this.ID).then(function (response) {
            self.challenge = response.data.data;
            self.my_solution  = response.data.data.my_solution;
        }).catch(function ({response}) {
            console.log(response);
        });

        axios.get('/api/kid/challenge/activites').then(function(response) {
            self.next_challenge    = response.data.next_challenge.id;
            self.ended_challenges  = response.data.challenges_finished;
        }).catch(function({response}) {
           console.log(response);
        });

        axios.get('/api/others/solutions/challenges').then(function({data}) {
            self.others_challenger    = data.data;
            console.log(self.others_challenger);
        }).catch(function({response}) {
           console.log(response);
        });
    },
    methods: {
        count_kids_image:function(count_kids) {
            if(count_kids >= 6){
                 return 6;
            }

            return count_kids;
        },
        removetags(value){
            var dom = new DOMParser().parseFromString(value, 'text/html');
            var txt = dom.body.textContent;
            return txt.substring(0, 200)+' ..';
        },
        uploadimage(event){
            this.images = event.target.files;
            console.log(event.target.files);
        },
        imageUrl(image){
            return URL.createObjectURL(image);
        },
        removeImage(index){
            let arr = Array.from(this.images);
            arr.splice(index,1);
            this.images = arr;
            console.log(this.images);
        },
        uploadSolutionsImages(){
            let data = new FormData();
            let self = this;
            for(let i = 0; i < self.images.length; i++){
              let image = self.images[i];
              data.append('images['+i+']',image);
            }
            data.append('description',this.description);
            data.append('kid_id',this.kid_id);
            data.append('challenge_id',this.ID);
            axios.post('/api/attach/solution/challenge',data, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
            }).then(function({data}){
               self.victoryAudio();
               self.next_challenge +=1;
               self.status  = data.status;
               self.message = data.message;
               self.celebrate = true;
               setTimeout(function(){
                   self.celebrate = false;
               },10000);
               console.log(data);
            }).catch(function({response}) {
                self.status  = response.data.data.status;
                self.errors  = response.data.data.message;
               console.log(error);
            });
        },
        sharePage(type){
            if(type == "facebook"){
               window.open("https://www.facebook.com/sharer/sharer.php?u="+axios.defaults.baseURL+"/challenge/"+this.ID, '_blank');
            }
            else if(type == "whatsapp"){
               window.open("https://wa.me/?text="+axios.defaults.baseURL+"/challenge/"+this.ID, '_blank');
            }
            else if(type == "linkedin"){
               window.open("http://www.linkedin.com/shareArticle?mini=true&url="+axios.defaults.baseURL+"/challenge/"+this.ID+"&title="+this.challenge.title+"&summary="+this.removetags(this.challenge.description), '_blank');
            }
            else if(type == "twitter"){
               window.open("https://twitter.com/intent/tweet?text="+this.challenge.title+"&url="+axios.defaults.baseURL+"/challenge/"+this.ID, '_blank');
            }
        },
        victoryAudio() {
            var x = document.createElement("AUDIO");
            x.setAttribute("id", "myvictoryAudio");
            x.setAttribute("controls", "controls");
            x.setAttribute("autoplay", true);
            x.setAttribute("style", 'visibility: hidden !important');

            var z = document.createElement("SOURCE");
            z.setAttribute("src", "https://freesound.org/data/previews/256/256128_375016-lq.mp3");
            z.setAttribute("type", "audio/mpeg");
            x.appendChild(z);

            document.body.appendChild(x);
        }
    }
}
</script>


<style lang="css" scoped>
.single-challenge-card .content-challenge {
    padding: 23px 0px;
    font-size: 17px;
    font-weight: bold;
}
.content-card{
    cursor: pointer !important;
}
.container-others-challenge{
    display: block;
}
</style>
