<template>
    <div class="">
        <user-layout>
           <main class="py-4" :style="{paddingTop:this_me == false ? '0px !important':''}">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 mychallenges-section">
                            <h1 class="title-page" v-if="this_me"> تحدياتى
                                <a class="share-challenge my-challenge-share" v-b-modal.modal-1>شارك صفحتك
                                    <i class="fas fa-share-alt"></i>
                                </a>
                            </h1>
                            <div  v-else>
                                <img class="banner-challenges" src="@/assets/img/starspattern@2x.png"/>
                                <div class="single-section-my-challenges">
                                    <img class="img-fluid" src="@/assets/img/team-4.jpg"/>
                                    <p class="my-challenge-name">{{ this.kidinfo.name }}</p>
                                </div>
                            </div>
                            <div class="col-md-12 card-my-challenge" v-for="(challenge,index) in challenges" :key="index">
                                <div class="col-md-6">
                                    <div class="image-card">
                                        <img class="img-responsive" :src="challenge.image.image_url"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="content-card">
                                        <h3 class="my-challenge-title">{{ challenge.title }}</h3>
                                        <p  class="my-challenge-content" >{{ removetags(challenge.description) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-if="challenges.length == 0">
                                <div class="upload-my-solve-challenge">
                                    <p class="upload-your-image-here" style="background-color: rgb(249 249 249);;border: 2px dashed rgb(92 73 73);">
                                           لا يوجد تحديات لديك
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           </main>
        </user-layout>
        <b-modal id="modal-1">
            <p class="my-4 title-toggle-share-post">مشاركة التحدي على مواقع التواصل الاجتماعى</p>
            <div class="social-links">
                  <i @click="sharePage('facebook')" class="fab fa-facebook"></i>
                  <i @click="sharePage('whatsapp')" class="fab fa-whatsapp"></i>
                  <i @click="sharePage('linkedin')" class="fab fa-linkedin"></i>
                  <i @click="sharePage('twitter')" class="fab fa-twitter"></i>

            </div>
        </b-modal>
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
          ID:0,
          challenges:{},
          kidinfo:{},
          this_me:false
        }
    },
    created(){
        let self = this;
        this.ID       = (typeof this.$route.params.kid_id == 'undefined' ? this.$store.getters['auth/Authenticated'].id : this.$route.params.kid_id);
        this.this_me  = (this.$route.params.kid_id == this.$store.getters['auth/Authenticated'].id ? true :false);
        axios.get('/api/challenge/page/'+this.ID).then(function(response){
            self.kidinfo        = response.data.data[0];
            self.challenges     = response.data.data[0].challenges;
            console.log(self.kidinfo);
        }).catch(function(error){
            console.log(error);
        });
    },
    methods: {
        removetags(value){
            var dom = new DOMParser().parseFromString(value, 'text/html');
            var txt = dom.body.textContent;
            return txt.substring(0, 200)+' ..';
        },
        sharePage(type){
            if(type == "facebook"){
               window.open("https://www.facebook.com/sharer/sharer.php?u="+axios.defaults.baseURL+"/my-challenges/"+this.ID, '_blank');
            }
            else if(type == "whatsapp"){
               window.open("https://wa.me/?text="+axios.defaults.baseURL+"/challenge/"+this.ID, '_blank');
            }
            else if(type == "linkedin"){
               window.open("http://www.linkedin.com/shareArticle?mini=true&url="+axios.defaults.baseURL+"/my-challenges/"+this.ID+"&title="+this.challenge.title+"&summary="+this.removetags(this.challenge.description), '_blank');
            }
            else if(type == "twitter"){
               window.open("https://twitter.com/intent/tweet?text="+this.challenge.title+"&url="+axios.defaults.baseURL+"/my-challenges/"+this.ID, '_blank');
            }
        }
    }
}
</script>

