<template>
    <div>
        <b-form  @submit.prevent="CreateNewProduct()" enctype="multipart/form-data">
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
                                                <b-img :src="imageurl" rounded="" style="width:100%"/>
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
                                        <h3 class="mb-0">Create New Challenge</h3>
                                    </b-col>
                                    <b-col cols="4" class="text-right">
                                        <base-switch class="mr-1"  v-model="fields.allow"></base-switch>
                                    </b-col>
                                </b-row>

                                <b-alert show variant="success" v-if="this.status == 'success' ">
                                    <strong> Success! </strong> {{ message }}
                                </b-alert>

                                <b-alert show variant="danger" v-if="this.status == 'error'">
                                    <p v-for="(error,index) in this.errors" :key="index"> {{ error }} </p>
                                </b-alert>
                                <h6 class="heading-small text-muted mb-4">Challenge Details</h6>

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
                                    </b-row>
                                </div>
                                <b-col lg="12">
                                    <base-input>
                                        <label class="form-control-label" for="">Products</label>
                                        <select v-model="fields.product_id" class="form-control form-control-lg" label="Products">
                                            <option v-for="(item ,index) in products" :key="index" :value="item.id">{{ item.title }}</option>
                                        </select>
                                    </base-input>
                                </b-col>
                                <b-col lg="12">
                                    <base-input
                                    type="number"
                                    label="Number of challenge"
                                    placeholder="Number of challenge"
                                    v-model="fields.number"
                                    >
                                    </base-input>
                                </b-col>
                                <hr class="my-4">

                        </card>
                        <br/>
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
                number:0,
                allow : true,
                product_id:0,
            },
            errors:[],
            status:'',
            message:'',
            products:{},
            search:'',
            imageurl:require('@/assets/img/theme/sketch.jpg'),
        };
    },
    methods: {
        CreateNewProduct() {
            let self = this;
            let data = new FormData();
            this.fields.description = $('#summernote').summernote('code');
            data.append('title',this.fields.title);
            data.append('description',this.fields.description);
            data.append('product_id',this.fields.product_id);
            data.append('number',this.fields.number);
            data.append('allow',(this.fields.allow == 'true' ? 1 : 0) );
            if(this.fields.image.length != 0  ){
                 data.append('image',this.fields.image);
            }
            axios.post('/api/admin/challenges',data).then(function(response) {
               self.status = response.data.status;
               self.message= response.data.message;
            }).catch(function (error) {
                self.errors = error.response.data.errors;
                self.status = error.response.data.status;
                console.log(error.response);
            }).then(function (response) {
                self.resetFormData();
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
            this.fields.barcode_id = 0;
            this.imageurl     = require('@/assets/img/theme/sketch.jpg');
            this.getDataApi();
        }
    },
    mounted() {
        let self = this;
        let paginate = {NoPaginate:true};
        axios.get('/api/admin/products',{params:paginate}).then(function(response) {
            self.products = response.data.data;
        }).catch(function (error) {
            self.status = error.response.data;
        });
    },
    created: function(){
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
