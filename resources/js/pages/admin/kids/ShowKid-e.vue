<template>
  <div>
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

                <table id="table_id" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Column 1</th>
                            <th>Column 2</th>
                            <th>Column 3</th>
                            <th>Column 4</th>
                            <th>Column 5</th>
                            <th>Column 6</th>
                            <th>Column 7</th>
                        </tr>
                    </thead>
                </table>


            </b-card>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>
<script>
let $  = require('jquery');
let dt = require('datatables.net');

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
        projects:[],
        currentPage: 1,
        paginationData: {},
        paginationPages:{},
        status:{},
      };
    },
    created(){
        this.getDataApi();
        $(document).ready( function () {
            $('#table_id').DataTable({
                processing: true,
                serverSide: true,
                ajax:'http://sara.challenges/api/admin/kids',
                columns: [
                    {
                        data: 'id',
                        "render": function(data, type, row, meta) {
                            return `<a href="/admin/dashboard">Link</a>`;
                        }
                    },
                    { data: 'firstname',name:'firstname' },
                    { data: 'lastname',name:'lastname' },
                    { data: 'image',name:'image' },
                    { data: 'age',name:'age'},
                    { data: 'email',name:'email' },
                    { data: 'fullname',name:'fullname' }
                ]
            });
        });
    },
    computed:{
    },
    methods:{
        removeProduct(id){
            let self = this;
            axios.delete('/api/admin/kids/'+id).then(function(response) {
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
            let link = '/api/admin/kids?page='+number;
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
            axios.get('/api/admin/kids').then(function(response) {
                self.paginationData = response.data.meta;
                self.paginationPages= response.data.links;
                self.projects       = Object.values(response.data.data);
                console.log(response.data);
            }).catch(function(error){
                console.error(error);
            }).then(function(){

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
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
