<template>
  <div id="app">
    <!-- <Loading/> -->
    <!-- <component is="Message" :show="this.showMessage" :text="this.textMessage" @buttonSure="this.MessageSure"/></component> -->
    <!-- <transition name="fade"> -->
      <!-- <component id="cnsdwuMessage" is="Message"></component> -->
      <!-- <button @click="toast">显示taost弹出框</button> -->
    <!-- </transition> -->
    <!-- <img src="./assets/logo.png"> -->
    <keep-alive exclude="articles">
      <router-view/>
    </keep-alive>
  </div>
</template>

<script>
import Vue from 'vue'
// import Loading from '@/components/plug/loading'

// Vue.component('Message',() => import('@/components/plug/message'));
// Vue.component('test',() => import('@/components/test'));
export default {
  name: 'App',
  created(){
       // this.$loading(true,1);
       // this.$loading({ fullscreen: true });
  },
  components:{
    // Loading,
  },
  methods:{
    // toast(){
    //   this.$toast("你好",3000);
    // }
  }
}
</script>

<style>
/*#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}*/
html,body,div,ul,figure,textarea,p,h1,button{
  margin: 0;
  padding: 0;
}
html,body{
  height: 100%;
}
html{
  font-size: 14px;
}
body{
  /*background-color: #ccc;*/
}
ul>li{
  list-style: none;
}
a{
  text-decoration: none;
  color: #000;
}
h1{
  font-size: 1rem;
  font-weight: normal;
}
button{
  font-size: 1rem;
}
button,input{
  outline: none;
  border: none;
}
#app{
  width: 100%;
  height: 100%;
}
/*@media (min-width: 768px) {
    html{
        font-size: 3.6rem;
    }
}
@media (min-width: 640px) and (max-width: 767px) {
    html{
        font-size: 2.5rem;
    }
}*/
@media screen and (min-width:360px){
    html{ font-size:80%;}
}
@media screen and (min-width:420px){
    html{ font-size:90%;}
}
@media screen and (min-width:480px){
    html{ font-size:100%;}
}
@media screen and (min-width:540px){
    html{ font-size:110%;}
}
@media screen and (min-width:600px){
    html{ font-size:120%;}
}
@media screen and (min-width:660px){
    html{ font-size:130%;}
}
@media screen and (min-width:720px){
    html{ font-size:140%;}
}
@media screen and (min-width:780px){
    html{ font-size:150%;}
}
@media screen and (min-width:840px){
    html{ font-size:160%;}
}
@media screen and (min-width:900px){
    html{ font-size:170%;}
}
@media screen and (min-width:960px){
    html{ font-size:180%;}
}
@media screen and (min-width:1020px){
    html{ font-size:190%;}
}
@media screen and (min-width:1080px){
    html{ font-size:200%;}
}
@media screen and (min-width:1140px){
    html{ font-size:210%;}
}
@media screen and (min-width:1200px){
    html{ font-size:220%;}
}
@media screen and (min-width:1260px){
    html{ font-size:230%;}
}
@media screen and (min-width:1320px){
    html{ font-size:240%;}
}
@media screen and (min-width:1380px){
    html{ font-size:250%;}
}
@media screen and (min-width:1440px){
    html{ font-size:260%;}
}
@media screen and (min-width:1500px){
    html{ font-size:270%;}
}
@media screen and (min-width:1560px){
    html{ font-size:280%;}
}
@media screen and (min-width:1620px){
    html{ font-size:290%;}
}
@media screen and (min-width:1680px){
    html{ font-size:300%;}
}
@media screen and (min-width:1740px){
    html{ font-size:310%;}
}
@media screen and (min-width:1800px){
    html{ font-size:320%;}
}
@media screen and (min-width:1860px){
    html{ font-size:330%;}
}
@media screen and (min-width:1920px){
    html{ font-size:340%;}
}
</style>
