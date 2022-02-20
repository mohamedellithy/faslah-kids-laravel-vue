<template>
    <div class="">
        <user-layout>
           <main class="py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                               <h1 class="title-page"> التحديات </h1>
                                <router-link v-for="(challenge,index) in challenges" tag="div" :to="{path:(open_challenges.indexOf(challenge.id) != -1 ? '/challenge/'+challenge.id : '') }" :class="['challenge-card' , open_challenges.indexOf(challenge.id) == -1 ? 'close-card' : '']" :key="index">
                                     <div class="image-card">
                                          <img class="img-fluid" :src="challenge.image.image_url ? challenge.image.image_url : require('../../../assets/img/theme/sketch.jpg') "/>
                                     </div>
                                     <div class="content-challenge" v-if="open_challenges.indexOf(challenge.id) != -1">
                                         <span class="number-challenge" v-if="challenge.id == next_challenge">{{ challenge.number }}</span>
                                         <span class="number-challenge fas fa-check-circle" v-else></span>
                                         <h2 class="title-challenge">{{ challenge.title }}</h2>
                                         <span class="kides-take-challenge" >
                                             <img v-for="index in count_kids_image(challenge.count_challenger)" class="taker-challenge-image" :src="challenge.images_kids[index] ? challenge.images_kids[index].image_url : require('../../../assets/img/team-4.jpg')" :key="index"/>
                                             <p class="count-takers-challenge">  {{ challenge.count_challenger}} طفل أشتروا هذا المنتج</p>
                                         </span>
                                     </div>
                                     <div class="over-card-description" v-else>
                                         <img class="image-close-challenge" :src="require('../../../assets/img/group-3.png')"/>
                                         <p class="title-to-open-challenge">
                                             يجب عليك إكمال التحدي السابق أولاً قبل البدء بحل هذا التحدّي
                                         </p>
                                         <span class="kides-take-challenge">
                                              <img v-for="index in count_kids_image(challenge.count_challenger)" class="taker-challenge-image" :src="challenge.images_kids[index] ? challenge.images_kids[index].image_url : require('../../../assets/img/team-4.jpg')" :key="index"/>
                                             <p class="count-takers-challenge">{{ challenge.count_challenger}} طفل أكملوا هذا التحدّي</p>
                                         </span>
                                     </div>
                               </router-link>
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
            challenges:{},
            products:{},
            ID:0,
            kid_id:0,
            open_challenges:[],
            next_challenge:null
        }
    },
    created() {
        let self    = this;
        this.kid_id = this.$store.getters['auth/Authenticated'].id;
        this.ID     = this.$route.params.product_id;
        axios.get('/api/admin/products/'+this.ID+'/challenges').then(function(response) {
            self.challenges = response.data.data;
            console.log(response);
        }).catch(function({response}) {
             console.log(response);
        });

        axios.get('/api/kid/challenge/activites').then(function(response) {
            self.next_challenge   = response.data.next_challenge.id;
            self.open_challenges  = response.data.challenges_finished;
            self.open_challenges.push(self.next_challenge);
            console.log(response);
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
        }
    }
}
</script>
