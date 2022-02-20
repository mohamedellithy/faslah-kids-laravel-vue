<template>
    <div class="">
        <user-layout>
           <main class="py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                               <h1 class="title-page"> المنتجات  </h1>
                               <router-link v-for="(product,index) in products" tag="div" :to="{ path : (product.kids_id.indexOf(kid_id) != -1 ? '/challenges/'+product.id : '/products') }" :class="['challenge-card', product.kids_id.indexOf(kid_id) == -1 ? 'close-card' : '']" :key="index">
                                     <div class="image-card">
                                          <img class="img-fluid" :src="product.image.image_url ? product.image.image_url : require('../../../assets/img/theme/img-1-1000x600.jpg') "/>
                                     </div>
                                     <div class="content-challenge" v-if="product.kids_id.indexOf(kid_id) != -1">
                                         <span class="number-challenge">{{ product.id }}</span>
                                         <h2 class="title-challenge">{{ product.title }}</h2>
                                         <span class="kides-take-challenge">
                                            <img v-for="index in count_kids_image(product.kids_id.length)" class="taker-challenge-image" :src="product.kids_images[index] ? product.kids_images[index].image_url : require('../../../assets/img/team-4.jpg')" :key="index"/>
                                            <p class="count-takers-challenge">  {{ product.kids_id.length}} طفل أشتروا هذا المنتج </p>
                                         </span>
                                     </div>
                                     <div class="over-card-description" v-else>
                                         <img class="image-close-challenge" :src="require('../../../assets/img/group-3.png')"/>
                                         <p class="title-to-open-challenge">
                                             يجب عليك شراء هذا المنتج و مسح الباركود الخاص بالمنتج لتسجيل المنتج
                                         </p>
                                         <span class="kides-take-challenge">
                                             <img v-for="index in count_kids_image(product.kids_id.length)" class="taker-challenge-image" :src="product.kids_images[index] ? product.kids_images[index].image_url : require('../../../assets/img/team-4.jpg')" :key="index"/>
                                             <p class="count-takers-challenge">  {{ product.kids_id.length}} طفل أشتروا هذا المنتج</p>
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
            products:{},
            kid_id : 2,
        }
    },
    created() {
        let self = this;
        this.kid_id = this.$store.getters['auth/Authenticated'].id;
        axios.get('/api/admin/products').then(function(response) {
            self.products = response.data.data;
        }).catch(function({response}) {
           console.log(response.data);
        });
    },
    methods:{
        count_kids_image:function(count_kids) {
            if(count_kids >= 6){
                 return 6;
            }

            return count_kids;
        }
    }
}
</script>
