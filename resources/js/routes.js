
let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forgot = require('./components/auth/forgot.vue').default;
let logout = require('./components/auth/logout.vue').default;
let home = require('./components/home.vue').default;
//Employee component
let allEmployee = require('./components/employee/index.vue').default;
let addEmployee = require('./components/employee/addEmployee.vue').default;
let editEmployee = require('./components/employee/editEmployee.vue').default;
//Supplier Component
let allSupplier = require('./components/supplier/index.vue').default;
let addSupplier = require('./components/supplier/addSupplier.vue').default;
let editSupplier = require('./components/supplier/editSupplier.vue').default;
//Category
let allCategory = require('./components/category/index.vue').default;
//brand
let allBrand = require('./components/brand/index.vue').default;
export const routes = [
    { path: '/', component: login, name:'/' },
    { path: '/register', component: register, name:'register' },
    { path: '/forgot', component: forgot, name:'forgot' },
    { path: '/logout', component: logout, name:'logout' },
    { path: '/home', component: home, name:'home' },

    // Employee routes
    { path: '/employee', component: allEmployee, name:'allemployee' },
    { path: '/add-employee', component: addEmployee, name:'addEmployee' },
    { path: '/edit-employee/:id', component: editEmployee, name:'editEmployee' },

    // Supplier route
    { path: '/supplier', component: allSupplier, name:'allsupplier' },
    { path: '/add-supplier', component: addSupplier, name:'addsupplier' },
    { path: '/edit-supplier/:id', component: editSupplier, name:'editSupplier' },
    
    //Category
    { path: '/category', component: allCategory, name:'allcategory' },

    //Brand
    { path: '/brand', component: allBrand, name:'allbrand' },
  ]