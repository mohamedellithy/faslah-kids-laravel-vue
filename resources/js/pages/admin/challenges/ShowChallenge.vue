<template>
  <div class="challenges">
    <statics-row></statics-row>
    <b-container fluid class="mt--7">
      <b-row>
        <b-col>
            <b-card no-body>
                <b-card-header class="border-0">
                    <h3 class="mb-0">Light table</h3>
                </b-card-header>
                <b-alert show variant="success" v-if="status.status == 'success' ">
                    <strong> Success! </strong> {{ status.message }}
                </b-alert>

                <b-alert show variant="danger" v-if="status.status == 'error'">
                    <p > {{ status.message }} </p>
                </b-alert>

                <el-table class="table-responsive table"
                        header-row-class-name="thead-light"
                        :data="projects">
                        <el-table-column label="img"
                                        min-width="10%"
                                        max-width="10%"
                                        prop="image">
                                <template v-slot="{row}">
                                    <b-media no-body class="align-items-center">
                                        <a href="#" class="avatar rounded-circle mr-3">
                                            <img alt="Image placeholder" :src="row.image.length != 0 ? row.image.image_url : require('@/assets/img/theme/sketch.jpg') ">
                                        </a>
                                    </b-media>
                                </template>
                        </el-table-column>
                        <el-table-column label="ID"
                                        min-width="10%"
                                        max-width="10%"
                                        prop="id">
                        </el-table-column>



                        <el-table-column label="Title"
                                        prop="title"
                                        min-width="20%"
                                        max-width="20%">
                        </el-table-column>

                        <!-- <el-table-column label="Description"
                                        min-width="20%"
                                        max-width="20%"
                                        prop="description">

                        </el-table-column> -->

                         <el-table-column label="Allow"
                                        min-width="20%"
                                        max-width="20%"
                                        width="20%"
                                        prop="allow">

                        </el-table-column>

                           <el-table-column label="show Barcode"
                                        min-width="20%"
                                        max-width="20%"
                                        width="20%"
                                        prop="allow">
                                        <template v-slot="{row}">
                                               <b-button size="sm" class="btn base-button btn-info btn-sm" @click="showModal(row.barcode)">show Barcode</b-button>
                                        </template>

                        </el-table-column>

                        <el-table-column label="Action"
                                        prop="image"
                                        min-width="20%"
                                        max-width="20%">
                                        <template v-slot="{row}">
                                            <router-link size="sm" class="btn base-button btn-primary btn-sm" :to="{ path:'/admin/dashboard/challenges/edit/'+row.id }">Edit</router-link>
                                            <base-button size="sm" @click="removeBarcode(row.id)" type="danger" class="btn base-button btn-danger btn-sm" aria-pressed="true">Remove Product</base-button>
                                        </template>

                        </el-table-column>

                </el-table>

                <b-card-footer class="py-4 d-flex justify-content-end">
                    <nav aria-label="Page navigation example">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" @click="movePage(paginationPages.prev)" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item" v-for="page in this.paginationData.last_page" :key="page" @click="changePageNumber(page)"><a  class="page-link" :class="[ paginationData.current_page == page ? 'nuxt-link-active' :''  ]"> {{ page }} </a></li>
                                <li class="page-item">
                                    <a class="page-link" @click="movePage(paginationPages.next)" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </nav>
                </b-card-footer>
            </b-card>
        </b-col>
        <b-modal ref="my-modal" hide-footer title="Using Component Methods">
            <div v-html="barcode.image"></div>
            <b-form role="form">
                <base-input type="number" alternative
                            v-model="count_copies"
                            class="mb-3"
                            label="count of copies"
                            placeholder="count of copies"
                            prepend-icon="ni upc">
                </base-input>
                <b-button size="sm" class="btn base-button btn-danger btn-sm"  @click="hideModal">Cancel</b-button>
                <b-button size="sm" class="btn base-button btn-success btn-sm"   @click="toggleModal" >Print Now</b-button>
            </b-form>
        </b-modal>
        <qrcode-print></qrcode-print>
      </b-row>
    </b-container>
  </div>
</template>
<script>
   import { Dropdown, DropdownItem, DropdownMenu, Table, TableColumn } from 'element-ui';
   import QrcodePrint from '@/components/admin/QrcodePrint';
  export default {
    components: {
      [Dropdown.name]: Dropdown,
      [DropdownItem.name]: DropdownItem,
      [DropdownMenu.name]: DropdownMenu,
      [Table.name]: Table,
      [TableColumn.name]: TableColumn,
      QrcodePrint
    },
    data() {
      return {
        projects:[],
        currentPage: 1,
        paginationData: {},
        paginationPages:{},
        status:{},
        count_copies:1,
        barcode:{}
      };
    },
    created(){
        this.getDataApi();
    },
    methods:{
        showModal(barcode) {
             this.$refs['my-modal'].show();
             this.barcode = barcode;
        },
        hideModal() {
            this.$refs['my-modal'].hide();
        },
        toggleModal() {
            let self = this;
            console.log(this.count_copies);
            this.$refs['my-modal'].toggle('#toggle-btn');
            Event.$emit("ContentPrint",{
                count_copies:self.count_copies,
                qrcodes     :self.barcode
            });
            setTimeout(function(){
                self.$htmlToPaper('printMe');
            },100);
        },
        removeBarcode(id){
            let self = this;
            axios.delete('/api/admin/challenges/'+id).then(function(response) {
                self.status = response.data;
                self.getDataApi();
                console.log(response.data);
            }).catch(function(error){
                console.error(error);
            });
        },
        movePage(link){
            let self = this;
            axios.get(link).then(function(response) {
                self.paginationData = response.data.meta;
                self.paginationPages= response.data.links;
                self.projects       = Object.values(response.data.data);
                console.log(response.data);
            }).catch(function(error){
                console.error(error);
            });
        },
        changePageNumber(number){
            let link = '/api/admin/challenges?page='+number;
            console.log(link);
            let self = this;
            axios.get(link).then(function(response) {
                self.paginationData = response.data.meta;
                self.paginationPages= response.data.links;
                self.projects       = Object.values(response.data.data);
                console.log(response.data);
            }).catch(function(error){
                console.error(error);
            });
        },
        getDataApi(){
            let self = this;
            this.$Progress.start();
            axios.get('/api/admin/challenges').then(function(response) {
                self.paginationData = response.data.meta;
                self.paginationPages= response.data.links;
                self.projects       = Object.values(response.data.data);
                self.$Progress.finish();
                console.log(response.data);
            }).catch(function(error){
                console.error(error);
                self.$Progress.fail()
            });
        }
    }

  };
</script>
<style>
.el-table.table-dark{
  background-color: #172b4d;
  color: #f8f9fe;
}

.el-table.table-dark th,
.el-table.table-dark tr{
  background-color: #172b4d;
}

.el-table.table-dark td,
.el-table.table-dark th.is-leaf{
  border-bottom: none;
}
.nuxt-link-active{
    z-index: 3 !important;
    color: #fff !important;
    background-color: #5e72e4 !important;
    border-color: #5e72e4 !important;
}
.page-item{
    cursor: pointer !important;
}
.table-responsive {
    overflow-x: hidden !important;
}
.challenges .visible-print svg {
    width: 100% !important;
    height: 150px !important;
}
</style>
