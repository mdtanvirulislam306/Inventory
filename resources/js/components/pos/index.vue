<template>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-body">
                        <table width="100%" class=" table-bordered">
                            <tr>
                                <td>01</td>
                                <td>Computer 5Gen Intel tech</td>
                                <td>3</td>
                                <td>50000</td>
                                <td><button class="btn btn-danger">X</button></td>
                            </tr>
                            <tr>
                                <td>01</td>
                                <td>Computer 5Gen Intel tech</td>
                                <td>3</td>
                                <td>50000</td>
                                <td><button class="btn btn-danger">X</button></td>
                            </tr>
                            <tr>
                                <td>01</td>
                                <td>Computer 5Gen Intel tech</td>
                                <td>3</td>
                                <td>50000</td>
                                <td><button class="btn btn-danger">X</button></td>
                            </tr>
                            <tr>
                                <td>01</td>
                                <td>Computer 5Gen Intel tech</td>
                                <td>3</td>
                                <td>50000</td>
                                <td><button class="btn btn-danger">X</button></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Total</td>
                                <td>9</td>
                                <td>5890000</td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-body">
                        <input type="search" v-model="serachByname" placeholder="serch by name" class="form-control ">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label for="category">Search by Category</label>
                                <select  id="category" v-model="serachBycategory" class="form-control">
                                <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.category_name }}</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="brand">Search by brand</label>
                                <select  id="brand" class="form-control ">
                                <option value="">Apple</option>
                                <option value="">Apple</option>
                                <option value="">Apple</option>
                                <option value="">Apple</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="card col-md-2 m-2 p-0" v-for="data in serachByName" :key="data.id">
                                <img class="card-img-top" :src="data.image" alt="Card image cap">
                                <div class="card-body p-1">
                                    <p class="card-title ">{{ data.product_name.slice(0, 20) }}</p>
                                </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        data(){
            return{
                products:[],
                categories:[],
                serachByname:'',
                serachBycategory:''
            }
        },
        computed:{
            serachByName(){
                return this.products.filter(data=>{return data.product_name.match(this.serachByname)})
            },
            
            serachByCategory(){
                console.log(this.serachBycategory)
                this.products=this.products.filter(data=>{return data.category_id.match(this.serachBycategory)})
            }
        },
        created(){
            this.getProducts(),
            this.getCategory()
        },
        methods:{
            getProducts(){
            axios.get('/api/product')
            .then(({data})=>{this.products=data;console.log(this.products)})
            .catch()
            },
            getCategory(){
            axios.get('/api/category')
            .then(({data})=>{this.categories=data;console.log(this.categories)})
            .catch()
            },
            
        }
    }
</script>