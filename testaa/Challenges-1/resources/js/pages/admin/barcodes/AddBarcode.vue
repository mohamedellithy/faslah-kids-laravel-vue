<template>
    <div>
        <b-form  @submit.prevent="CreateNewBarcodes()" enctype="multipart/form-data">
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
                    <b-col xl="8" class="order-xl-1">
                        <card>
                                <b-row align-v="center" slot="header" >
                                    <b-col cols="8">
                                        <h3 class="mb-0">Create New Barcode</h3>
                                    </b-col>
                                    <b-col cols="4" class="text-right">
                                        <base-switch class="mr-1"  v-model="fields.allow"></base-switch>
                                    </b-col>
                                </b-row>

                                <b-alert show variant="success" v-if="this.status.status == 'success' ">
                                    <strong> Success! </strong> {{ status.message }}
                                </b-alert>

                                <b-alert show variant="danger" v-if="this.status.status == 'error'">
                                    <p v-for="(error,index) in this.status.message" :key="index"> {{ error }} </p>
                                </b-alert>
                                <h6 class="heading-small text-muted mb-4">Generate Barcodes</h6>

                                <div class="pl-lg-4">
                                    <b-row>
                                        <b-col lg="12">
                                            <base-input
                                            type="text"
                                            label="Count Barcodes"
                                            placeholder="Count Barcodes"
                                            v-model="fields.count"
                                            >
                                            </base-input>
                                        </b-col>
                                        <b-col lg="12">
                                            <base-input>
                                                <label class="form-control-label" for="">Products</label>
                                                <select v-model="fields.item_id" class="form-control form-control-lg" label="Products">
                                                    <option v-for="(item ,index) in items" :key="index" :value="item.id">{{ item.title }}</option>
                                                </select>
                                            </base-input>
                                        </b-col>
                                    </b-row>
                                </div>
                                <hr class="my-4">
                                <base-button icon type="primary" nativeType="submit">
                                    <span class="btn-inner--icon"><i class="ni ni-bag-17"></i></span>
                                    <span class="btn-inner--text">Generate Barcode</span>
                                </base-button>
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
                count:'',
                item_id:''
            },
            errors:[],
            status:[],
            items:{}
        };
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
        CreateNewBarcodes() {
            let self = this;
            let data = new FormData();
            data.append('count',this.fields.count);
            data.append('item_id',this.fields.item_id);
            this.$Progress.start();
            axios.post('/api/admin/barcodes',data).then(function(response) {
               self.status = response.data;
               self.resetFormData();
               console.log(self.status);
               self.$Progress.finish();
            }).catch(function (error) {
                self.status = error.response.data;
                self.$Progress.fail();
            });
        },
        resetFormData(){
            this.fields.count = '';
            this.fields.item_id = '';
        }
    }
  };
</script>
<style>
</style>
