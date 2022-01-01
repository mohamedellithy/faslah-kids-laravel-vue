<template>
    <div>
        <b-form  @submit.prevent="UpdateBarcode()" enctype="multipart/form-data">
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
                                <base-button icon type="primary" nativeType="submit">
                                    <span class="btn-inner--icon"><i class="ni ni-bag-17"></i></span>
                                    <span class="btn-inner--text">Save Challenge</span>
                                </base-button>
                            </b-card-header>

                            <b-card-body class="pt-0">
                                <b-row>
                                    <b-col >
                                        <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                            <b-card-body class="card-body">

                                                <b-form-file
                                                    type="file"
                                                    @change="imageChange"
                                                    name="file-upload"
                                                    input="fields.image ?? ''"
                                                    accept="image/jpeg, image/png"
                                                />

                                            </b-card-body>
                                        </div>
                                    </b-col>
                                </b-row>
                            </b-card-body>
                            <b-card-footer>
                                <b-row class="justify-content-center">
                                    <b-col lg="12" class="order-lg-12">
                                        <div class="">
                                            <a href="#">
                                                <b-img :src="imageurl ? imageurl :  require('@/assets/img/theme/sketch.jpg') " rounded="" style="width:100%"/>
                                            </a>
                                        </div>
                                        <base-button @click="removeimage" size="sm" type="danger">remove image</base-button>
                                    </b-col>
                                </b-row>
                            </b-card-footer>
                        </b-card>
                    </b-col>
                    <b-col xl="8" class="order-xl-1">
                        <card>
                            <b-row align-v="center" slot="header" >
                                <b-col cols="8">
                                    <h3 class="mb-0">Create New Product</h3>
                                </b-col>
                                <b-col cols="4" class="text-right">
                                    <b-form-checkbox v-model="fields.allow" name="check-button" switch>
                                        Publish {{ fields.allow }}
                                    </b-form-checkbox>
                                </b-col>

                            </b-row>

                            <b-alert show variant="success" v-if="status.status == 'success' ">
                                <strong> Success! </strong> {{ status.message }}
                            </b-alert>

                            <b-alert show variant="danger" v-if="status.status == 'error'">
                                <p v-for="(error,index) in status.message" :key="index"> {{ error }} </p>
                            </b-alert>
                            <h6 class="heading-small text-muted mb-4">Product Details</h6>

                            <div class="pl-lg-4">
                                <b-row>
                                    <b-col lg="12">
                                        <base-input
                                        type="text"
                                        label="title"
                                        placeholder="title"
                                        v-model="fields.title"
                                        >
                                        </base-input>
                                    </b-col>
                                    <b-col lg="12">
                                        <base-input label="Example textarea">
                                            <!-- <textarea v-model="fields.description" class="form-control" id="exampleFormControlTextarea3" rows="3"></textarea>
                                                -->
                                                <textarea name="description" id="summernote" >
                                                    Place <em>some</em> <u>text</u> <strong>here</strong>
                                                </textarea>
                                        </base-input>
                                    </b-col>
                                    <b-col lg="12">
                                        <base-input
                                        type="text" readonly="true"
                                        label="code"
                                        placeholder="code"
                                        v-model="fields.barcode.code"
                                        >
                                        </base-input>
                                    </b-col>
                                    <b-col>
                                        <div class="form-group" v-html="fields.barcode.image"></div>
                                    </b-col>
                                </b-row>
                            </div>
                            <hr class="my-4">

                        </card>
                        <br/>
                        <card>
                            <b-row align-v="center" slot="header" >
                                <b-col cols="8">
                                    <h3 class="mb-0">choice Barcodes</h3>
                                </b-col>
                                <b-col cols="4">
                                    <base-input
                                            type="text"
                                            label="Search with Product name or code"
                                            placeholder="Search with Product name or code"
                                            v-model="search"
                                            >
                                            </base-input>
                                </b-col>
                            </b-row>

                            <div class="pl-lg-4">
                                <b-row>
                                    <b-col lg="12">
                                        <div class="show-barcodes">
                                            <ul>
                                               <li style="list-style:none !important">
                                                    <b-form-radio v-model="fields.barcode_id" name="some-radios" :value="fields.barcode.id">
                                                        <span v-html="fields.barcode.image"></span>  Code : {{ fields.barcode.code }}
                                                    </b-form-radio>
                                               </li>
                                            </ul>

                                           <ul>
                                               <li style="list-style:none !important" v-for="barcode in barcodes" :key="barcode.id">
                                                    <b-form-radio v-model="fields.barcode_id" name="some-radios" :value="barcode.id" v-if="barcode.code.search(search.trim())  != -1">
                                                        <span v-html="barcode.image"></span>  Code : {{ barcode.code }}
                                                    </b-form-radio>
                                                    <b-form-radio v-model="fields.barcode_id" name="some-radios" :value="barcode.id" v-else-if="barcode.product.title  == search.trim() ">
                                                        <span v-html="barcode.image"></span>  Code : {{ barcode.code }}
                                                    </b-form-radio>
                                                     <b-form-radio v-model="fields.barcode_id" name="some-radios" :value="barcode.id" v-else-if="search.length == 0 ">
                                                        <span v-html="barcode.image"></span>  Code : {{ barcode.code }}
                                                    </b-form-radio>

                                               </li>
                                           </ul>
                                        </div>
                                    </b-col>
                                </b-row>
                            </div>
                            <hr class="my-4">
                        </card>

                    </b-col>
                </b-row>
            </b-container>
        </b-form>
    </div>
</template>
<script>
  let $ = require("jquery");
  export default {
    data() {
        return {
            fields: {
                title:'',
                description:'',
                image: [],
                allow : true,
                barcode_id:0,
                barcode:{}
            },
            errors:[],
            status:{},
            message:'',
            imageurl:'',
            image_id:null,
            ID : '',
            search:'',
            barcodes:{},
        };
    },
    created() {
        console.log(this.fields.allow);
        this.ID = this.$route.params.id;
        this.getChallengesApi();
        this.getBarcodesApi();
        $(document).ready(function() {
            $('#summernote').summernote();
            $('#summernote').summernote({
                height: 500,
                minHeight: null,
                maxHeight: null,
                toolbar: [
                    ['Style', ['style']],
                    ['Font', ['bold','italic','underline','clear']],
                    ['Color', ['color']],
                    ['Paragraph', ['ul', 'ol', 'hr', 'paragraph']],
                    ['Table', ['table']],
                    ['Insert', ['link','picture','video']],
                    ['Misc', ['fullscreen','codeview']],
                    ['Tools', ['undo','redo']]
                ],
                popover: {
                    image: [
                        ['imagesize', ['imageSize100', 'imageSize50', 'imageSize25']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ],
                    link: [
                        ['link', ['linkDialogShow', 'unlink']]
                    ]
                }
            });
        });
    },
    methods: {
        UpdateBarcode() {
            let self = this;
            let data = new FormData();
            this.fields.description = $('#summernote').summernote('code');
            data.append('title',this.fields.title);
            data.append('description',this.fields.description);
            data.append('allow',(this.fields.allow == true ? 1 : 0) );
            data.append('image_id',this.image_id);
            data.append('barcode_id',this.fields.barcode_id);
            if( ( this.fields.image.name && this.fields.image.name.length != 0  )){
                data.append('image',this.fields.image);
            }
            console.log(this.image_id);
            axios.post(`/api/admin/challenges/${this.ID}`,data).then(function(response) {
                self.status = response.data;
                console.log(response.data);
            }).catch(function (error) {
                self.status = error.response.data;
                console.log(error.response);
            });
        },
        imageChange(event){
           this.fields.image = event.target.files[0];
           this.imageurl = URL.createObjectURL( this.fields.image );
        },
        removeimage(event){
            this.fields.image = '';
            this.imageurl     = '';
        },
        resetFormData(){
            this.fields.title = '';
            this.fields.description = '';
            this.fields.image =  [];
            this.fields.allow = true;
            this.imageurl     = require('@/assets/img/theme/sketch.jpg');
        },
        getChallengesApi(){
            let self = this;
            axios.get('/api/admin/challenges/'+this.ID+'/edit').then(function(response) {
                self.fields            = response.data.data;
                self.fields.allow      = (self.fields.allow == 'published' ? true : false);
                self.fields.barcode_id = self.fields.barcode.id;
                self.imageurl          = self.fields.image.image_url;
                self.image_id          = self.fields.image.id;
                console.log(response);
            }).catch(function(error){
                console.error(error);
            });
        },
        getBarcodesApi(){
            let self = this;
            let paginate = {NoPaginate:true,attached:1};
            this.$Progress.start();
            axios.get('/api/admin/barcodes',{params:paginate}).then(function(response) {
                self.barcodes       = response.data.data;
                self.$Progress.finish();
                console.log(response.data);
            }).catch(function(error){
                console.error(error);
                self.$Progress.fail()
            });
        },
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
</style>
