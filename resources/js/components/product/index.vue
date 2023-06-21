<template>
    <div class="container-fluid"> 
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">All Products</h6>
                                    <div class="dropdown no-arrow">
                                        <router-link class="btn btn-primary" to="add-product">
                                            Add Product
                                        </router-link>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <label for="">Search</label>
                                    <input type="text" v-model="searchTerm">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Supplier</th>
                                                <th>Category</th>
                                                <th>Brand</th>
                                                <th>Purchase Price</th>
                                                <th>Selling Price</th>
                                                <th>Quantity</th>
                                                <th>Purchase Date</th>
                                                <th>Expaire Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="product in searchData" :key="product.id">
                                                <td><img :src="product.image" alt="product photo"></td>
                                                <td>{{ product.product_name }}</td>
                                                <td>{{ product.supplier_name }}</td>
                                                <td>{{ product.category_name }}</td>
                                                <td>{{ product.brand_name }}</td>
                                                <td>{{ product.purchase_price }}</td>
                                                <td>{{ product.selling_price }}</td>
                                                <td>{{ product.qty }}</td>
                                                <td>{{ product.purchase_date }}</td>
                                                <td>{{ product.expair_date }}</td>
                                                <td>
                                                    <router-link :to="{name:'editSupplier',params:{id:product.id}}"><i class="fa fa-pen pr-2"></i></router-link>
                                                    
                                                    <a @click="deleteSupplier(supplier.id)"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
            </div>
        </div>
</template>
<script>
export default{
    created(){
        if(!User.loggedIn()){
            this.$router.push({name:'/'})
        }
        
     
    },
    data(){ 
       return{
        products:[],
        searchTerm : ''
       }
    },
    computed:{
        searchData(){
           return this.products.filter(product=>{return product.product_name.match(this.searchTerm)})
        }
    },
    mounted(){
        this.allProducts()
    },
    methods:{
        allProducts(){
            axios.get('/api/product')
            .then(({data})=>{this.products = data; console.log(data)})
            .catch()
            
        },
        deleteSupplier(id){
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    console.log(result)
                if (result.value) {
                    axios.delete('/api/supplier/'+id)
                    .then(()=>{this.suppliers = this.suppliers.filter(supplier=>{return supplier.id!=id})})
                    .catch( this.$router.push({name:'allsupplier'}))
                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    )
                    }
                    })
                }
    }
}
</script>
<style scoped>
img{
    width: 50px;
    border-radius: 50%;
}
</style>