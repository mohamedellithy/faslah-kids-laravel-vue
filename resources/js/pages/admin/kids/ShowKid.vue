<template>
    <div class="edit-barcode">
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
                                <img class="image-personal" :src="[typeof model.image != 'undefined' ? model.image.image_url : require('@/assets/img/theme/sketch.jpg')]" />
                            </b-card-header>

                            <b-card-footer>
                                <b-row class="justify-content-center">
                                    <b-col lg="12" class="order-lg-12">
                                        <div class="" style="text-align: center">
                                            <p class="info-details"><label>Email</label> {{ this.model.email }}</p>
                                            <p class="info-details"><label>Full Name</label> {{ this.model.fullname }}</p>
                                            <p class="info-details"><label>Age</label> {{ this.model.age }}</p>
                                            <p class="info-details"><label>Challenges</label> {{ this.model.count_challenges }}</p>
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
                                    <h3 class="mb-0">kid Activites</h3>
                                </b-col>


                            </b-row>
                            <h6 class="heading-small text-muted mb-4">Kid's Challenges</h6>

                            <div class="pl-lg-4">
                                <b-row>
                                    <el-table class="table-responsive table"
                                        header-row-class-name="thead-light"
                                        :data="this.model.challenges">
                                        <el-table-column label="img"
                                                        min-width="10%"
                                                        max-width="10%"
                                                        prop="image">
                                                <template v-slot="{row}">
                                                    <b-media no-body class="align-items-center">
                                                        <a href="#" class="avatar  mr-3">
                                                            <img alt="Image placeholder" :src="[row.image.image_url ? row.image.image_url : require('@/assets/img/theme/sketch.jpg')]">
                                                        </a>
                                                    </b-media>
                                                </template>
                                        </el-table-column>
                                        <el-table-column label="ID"
                                                        min-width="10%"
                                                        max-width="10%"
                                                        prop="id">
                                        </el-table-column>

                                        <el-table-column label="Challenge Number"
                                                        min-width="10%"
                                                        max-width="10%"
                                                        prop="number">
                                        </el-table-column>



                                        <el-table-column label="Challenge"
                                                        prop="title"
                                                        min-width="20%"
                                                        max-width="20%">
                                        </el-table-column>

                                        <el-table-column label="created at"
                                                        prop="created_at"
                                                        min-width="20%"
                                                        max-width="20%">
                                        </el-table-column>

                                        <el-table-column label="product name"
                                                        prop="product_id"
                                                        min-width="20%"
                                                        max-width="20%">
                                                        <template v-slot="{row}">
                                                               {{ `${row.product_id.title}` }}
                                                        </template>

                                        </el-table-column>

                                        <el-table-column label="Action"
                                                        prop="image"
                                                        min-width="20%"
                                                        max-width="20%">
                                                        <template v-slot="{row}">
                                                            <router-link size="sm" class="btn base-button btn-primary btn-sm" :to="{ path:'/admin/dashboard/solutions/show/'+row.solution_id }">show</router-link>
                                                        </template>

                                        </el-table-column>

                                    </el-table>

                                </b-row>
                            </div>
                            <hr class="my-4">
                        </card>
                    </b-col>
                </b-row>
            </b-container>
    </div>
</template>
<script>
import { Dropdown, DropdownItem, DropdownMenu, Table, TableColumn } from 'element-ui';
  export default {
    components: {
      [Dropdown.name]: Dropdown,
      [DropdownItem.name]: DropdownItem,
      [DropdownMenu.name]: DropdownMenu,
      [Table.name]: Table,
      [TableColumn.name]: TableColumn
    },
    data() {
        return {
            model:{}
        };
    },
    created() {
        this.getmychallengesApi();
    },
    methods: {
        getmychallengesApi(){
            let self = this;
            this.ID = this.$route.params.id;
            this.$Progress.start();
            axios.get('/api/admin/kids/'+this.ID).then(function(response) {
                self.model           = response.data.data;
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
