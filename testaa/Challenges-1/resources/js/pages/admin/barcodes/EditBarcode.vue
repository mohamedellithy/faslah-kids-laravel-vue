<template>
    <div class="edit-barcode">
        <b-form  @submit.prevent="UpdateBarcodes()" enctype="multipart/form-data">
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
                                    <span class="btn-inner--text">Save Barcode</span>
                                </base-button>
                            </b-card-header>

                            <b-card-footer>
                                <b-row class="justify-content-center">
                                    <b-col lg="12" class="order-lg-12">
                                        <div class="">
                                            <span v-html="fields.image"></span>
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
                                        <h3 class="mb-0">Edit Barcode</h3>
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
                                            type="text" readonly="true"
                                            label="Code of QR"
                                            placeholder="Code of QR"
                                            v-model="fields.code"
                                            >
                                            </base-input>
                                        </b-col>
                                        <b-col lg="12">
                                            <base-input>
                                                <label class="form-control-label" for="">Products</label>
                                                <select v-model="fields.product.id" class="form-control form-control-lg" label="Products">
                                                    <option v-for="(item ,index) in items" :key="index" :value="item.id">{{ item.title }}</option>
                                                </select>
                                            </base-input>
                                        </b-col>

                                         <b-col lg="12">
                                            <base-input>
                                                <label class="form-control-label" for="">Activation</label>
                                                <select v-model="fields.Activated" class="form-control form-control-lg" label="Products">
                                                    <option :value="0">Not Activated</option>
                                                    <option :value="1">Activated</option>
                                                </select>
                                            </base-input>
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

  export default {
    data() {
        return {
            fields: {
                code:'',
                Activated:0,
                product:{
                    id:'',
                },
                image:'',
            },
            errors:[],
            status:{},
            message:'',
            items:{},
            ID:0,
        };
    },
    created() {
        this.ID = parseInt(this.$route.params.id);
        this.getBarcodeApi();
    },
    mounted() {
        let self = this;
        let paginate = {NoPaginate:true};
        axios.get('/api/admin/products',{params:paginate}).then(function(response) {
            self.items = response.data.data;
            self.resetFormData();
        }).catch(function (error) {
            self.status = error.response.data;
        });
    },
    methods: {
        UpdateBarcodes() {
            let self = this;
            let dataform = {item_id:this.fields.product.id,Activated:this.fields.Activated};
            console.log(dataform);
            axios.put(`/api/admin/barcodes/${this.ID}`,dataform).then(function(response) {
                // self.fields = response.data;
                self.status = response.data;
                console.log(response.data);
            }).catch(function (error) {
                self.status = error.response.data;
                console.log(error.response);
            });
        },
        getBarcodeApi(){
            let self = this;
            this.$Progress.start();
            axios.get('/api/admin/barcodes/'+this.ID+'/edit').then(function(response) {
                self.fields           = response.data.data;
                self.fields.Activated = (self.fields.Activated == 'activated' ? 1 : 0 );
                console.log(response.data.data);
                self.$Progress.finish();
            }).catch(function(error){
                console.error(error);
                self.$Progress.fail();
            });
        }

    }
  };
</script>
<style>
.edit-barcode .visible-print svg{
    width: 100%;
    height: 200px;
}
</style>
