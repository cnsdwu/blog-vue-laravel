<template>
	<div>
		<header class="header">
			<!-- <img src="@/assets/logo.png"> -->
			<!-- <nav></nav> -->
			<div class="menu" @click.stop="clickMenu">
				<img src="@/assets/menu.png">
			</div>
			<h1>五味杂陈</h1>
		</header>
		<transition name="fade">
			<!-- <Asides class="aside" v-show="showMenu"/> -->
			<keep-alive>
				<component class="aside" is="Asides" v-show="showMenu" @hiddenMenu="hiddenMenu"></component>
			</keep-alive>
		</transition>
		<nav></nav>
		<!-- 中间部分 -->
<!-- 		<section>
			<header></header>
			<article></article>
			<footer></footer>
		</section> -->
		<keep-alive>
			<router-view></router-view>
		</keep-alive>
		<!-- 底部 -->
		<keep-alive>
			<Footers />
		</keep-alive>
	</div>
</template>

<script type="text/javascript">
	import Vue from 'vue'
	import Footers from '@/components/footers.vue'
	// import Asides from '@/components/aside'
	Vue.component(
		'Asides',
		() => import('@/components/aside'),
	)
	export default{
		name:'index',
		data(){
			return{
				showMenu: false,
			}
		},
		components:{
			Footers,
			// Asides,
		},
		created(){
			document.addEventListener('click',()=>{
				this.showMenu = false;
			});
		},
		methods:{
			clickMenu(){
				this.showMenu = !this.showMenu;
			},
			hiddenMenu(){
				this.showMenu = !this.showMenu;
			}
		}
	}
</script>

<style scoped>
	.header{
		width: 100%;
		background: rgba(244,244,244,.8);
		border-bottom: 1px solid #eee;
		position: fixed;
		top: 0;
		z-index: 1;
	}
	.header .menu{
		position: absolute;
		left: 1rem;
		top: .85rem;
		opacity: .7;
	}
	.header .menu img{
		height: 1.3rem;
	}
	.header h1{
		height: 3rem;
		line-height: 3rem;
		text-align: center;
	}
	.aside{
		width: 100%;
		height: 100%;
		position: fixed;
		top: 0;
		left: 0;
		z-index: 1;
	}
	.fade-enter{
		opacity: 0;
		transform: translateX(-50%);
	}
	.fade-enter-to{
		opacity: 1;
		transform: translateX(0);
	}
	.fade-enter-active{
		transition: all .5s;
	}
	.fade-leave{
		opacity: 1;
		transform: translateX(0);
	}
	.fade-leave-to{
		opacity: 0;
		transform: translateX(-50%);
	}
	.fade-leave-active{
		transition: all .5s;
	}
	/*.fade-enter-active, .fade-leave-active {
	  transition: all .5s;
	}
	.fade-enter, .fade-leave-to{
	  transform: translateX(-50%);
	}*/
</style>