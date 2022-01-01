<template>
    <div>
            <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center profile-header"
                style="min-height: 200px; background-image: url(img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
                <b-container fluid>
                    <!-- Mask -->
                    <span class="mask bg-gradient-success opacity-8"></span>
                    <!-- Header container -->
                    <b-container fluid class="d-flex align-items-center">
                    </b-container>
                </b-container>
            </div>

            <b-container fluid class="mt--9">

                <b-row>
                    <b-col xl="4" class="order-xl-2 mb-5">
                        <b-card no-body class="card-profile" alt="image placeholder" img-top>

                            <b-card-header class="text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                                <img class="image-personal" :src="[typeof model.kid_images != 'undefined' ? model.kid_images.image_url : require('@/assets/img/theme/sketch.jpg')]" />
                            </b-card-header>

                            <b-card-footer>
                                <b-row class="justify-content-center">
                                    <b-col lg="12" class="order-lg-12">
                                        <div class="" style="text-align: center">
                                            <p class="info-details"><label>Email</label> {{ this.model.email }}</p>
                                            <p class="info-details"><label>Full Name</label>
                                                <router-link :to="{path:'/admin/dashboard/Kids/show/'+this.model.kid_id}" tag="strong">
                                                    {{ this.model.kidname }}
                                                </router-link>
                                            </p>
                                            <p class="info-details"><label>Age</label> {{ this.model.age }}</p>
                                            <p class="info-details"><label>Challenges</label> {{ this.model.count_challenges }}</p>
                                            <p class="info-details"><label>Challenge</label>
                                                <router-link :to="{path:'/admin/dashboard/challenges/edit/'+this.model.challenge_id}" tag="strong"> {{ this.model.title }}</router-link>
                                            </p>
                                            <p class="info-details">
                                                <label>Product</label>
                                                <router-link :to="{path:'/admin/dashboard/products/edit/'+this.model.product_id}" tag="strong">  {{ this.model.product_title }} </router-link>
                                            </p>
                                        </div>
                                    </b-col>
                                </b-row>
                            </b-card-footer>
                        </b-card>
                    </b-col>
                    <b-col xl="8" class="order-xl-1">
                        <card>
                                <b-row align-v="center" slot="header" >
                                    <b-col cols="8">
                                        <h3 class="mb-0 text-right"> ( {{ this.model.title }} ) حل التحدى </h3>
                                    </b-col>
                                </b-row>
                                <b-card-body class="pt-0">
                                    <b-row>
                                        <b-col >
                                            <photo-gallery :images="model.images" v-model="visiblePhoto"></photo-gallery>
                                            <a v-for="(image, index) in model.images" class="thumb-item" href="#" @click="visiblePhoto = index" :key="index">
                                                    <img class="image-show-solutions" :src="image.thumbSrc"/>
                                            </a>
                                        </b-col>
                                        <div class="description-show" v-html="model.description"></div>
                                    </b-row>
                                </b-card-body>
                        </card>
                        <br/>
                    </b-col>
                </b-row>
            </b-container>
    </div>
</template>
<script>
  let $ = require("jquery");
  import { PhotoGallery } from 'vue-photo-gallery';
  export default {
    components: {
       PhotoGallery
    },
    data() {
        return {
            images: [],
            visiblePhoto: null,
            description: '',
            model:{}
        };
    },
    created(){
        let self    = this;
        this.ID     = this.$route.params.id;
        axios.get('/api/admin/solutions/'+this.ID).then(function (response) {
            self.model           = response.data.data;
            console.log(response);
        }).catch(function (error) {
            console.log(response.error);
        });
    }
  };
</script>
<style>
.show-barcodes .custom-radio{
    height: auto;
    padding: 22px;
}
.show-barcodes{
    height: 300px;
    overflow-y: scroll;
}
.image-show-solutions{
    width: 44% !important;
    border: 4px solid #0d47a1;
    margin: 2%;
}
.description-show{
    padding:10px;
    font-size:20px;
    direction:rtl;
    text-align:right
}
</style>
