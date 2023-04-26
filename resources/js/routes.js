
let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default;
let forgot = require('./components/auth/forgot.vue').default;
let logout = require('./components/auth/logout.vue').default;
let home = require('./components/home.vue').default;
let allEmployee = require('./components/employee/index.vue').default;
let addEmployee = require('./components/employee/addEmployee.vue').default;
let editEmployee = require('./components/employee/editEmployee.vue').default;
export const routes = [
    { path: '/', component: login, name:'/' },
    { path: '/register', component: register, name:'register' },
    { path: '/forgot', component: forgot, name:'forgot' },
    { path: '/logout', component: logout, name:'logout' },
    { path: '/home', component: home, name:'home' },
    { path: '/employee', component: allEmployee, name:'allemployee' },
    { path: '/add-employee', component: addEmployee, name:'addEmployee' },
    { path: '/edit-employee/:id', component: editEmployee, name:'editEmployee' }
  ]