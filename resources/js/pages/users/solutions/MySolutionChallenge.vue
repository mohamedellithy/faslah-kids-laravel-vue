<template>
    <div class="">
        <user-layout>
           <main class="py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="single-challenge-card single-solution-card">
                                <h5 class="single-title-solution">My Solution</h5>
                                <div class="col-12 single-challenges-data">
                                    <div class=" single-section-my">
                                        <img class="my-challenge-image" :src="[this.$store.getters['auth/Authenticated'].image.length != 0 ? this.$store.getters['auth/Authenticated'].image.image_url : require('@/assets/img/theme/sketch.jpg')]" />
                                        <span class="my-challenge-name">{{ this.$store.getters['auth/Authenticated'].fullname }}</span>
                                    </div>
                                </div>
                                <div class="col-12 single-challenges-data">
                                        <div class="images-frame">
                                            <img class="image-solution" v-for="(image,index) in solution.images" :key="index" :src="image.src"/>
                                        </div>
                                </div>
                                <div class="content-challenge content-solution" v-html="solution.description"></div>
                            </div>

                            <div class="single-challenge-card single-solution-card">
                                    <h2 class="single-title-challenge">{{ this.challenge.title }}</h2>
                                    <div class="image-card">
                                        <img :src="challenge.image.image_url"/>
                                    </div>
                                    <div class="content-challenge" v-html="challenge.description"></div>
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
        return{
           challenge:{},
           solution:{}
        }
    },
    created(){
        let self    = this;
        this.ID     = this.$route.params.solution_id;
        this.kid_id = this.$store.getters['auth/Authenticated'].id;
        axios.get('/api/admin/my-solution/'+this.ID).then(function({data}) {
            self.solution = data.data;
            self.challenge = data.data.challenge;
            console.log(data);
        });
    }
}
</script>


<style lang="css" scoped>
.single-challenge-card .content-challenge {
    padding: 23px 0px;
    font-size: 17px;
    font-weight: bold;
}
.single-title-solution{
    text-align: right;
    font-size: 20px;
    padding: 15px;
}
.single-solution-card {
    margin-top: 5%;
}
.image-solution{
    width: 30%;
    margin: 10px;
}
.content-solution{
    font-size: 17px !important;
    font-weight: 400 !important;
}
.my-challenge-image {
    width: 6%;
}
</style>