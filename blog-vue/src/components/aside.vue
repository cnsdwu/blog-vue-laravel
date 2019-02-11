<template>
	<div>
		<!-- <keep-alive>
			<component is="Login" v-if="showLogin"></component>
		</keep-alive> -->
		<div @click.stop="" class="container">
			<!-- <img src="@/assets/aside.png"> -->
			<div class="login">
				<div class="register" v-if="!isLogin">
					<ul>
						<li @click="clickRegister">注册</li>
						<li @click="clickLogin">登录</li>
					</ul>
				</div>
				<div class="logined" v-if="isLogin">
					<img v-lazy="head">
					<div contenteditable="true" ref="nickname" @focusout="editNickname">{{nickname}}</div>
				</div>
			</div>
			<div class="search" @click.stop="">
				<input type="text" placeholder="搜索" @keyup="search" @focusout="focusOut" v-model="keys" ref="search">
				<div @click="clickList">
				<transition name="down">
					<ul v-show="update">
							<li v-for="(data, index) in this.result">
								<a :href="'article/'+data.id">{{data.title}}</a>
							</li>
					</ul>
				</transition>
				</div>
			</div>
			<div class="list">
				<ul>
					<li>
						<router-link to="/guestbook" @click.native="hiddenMenu">留言</router-link>
					</li>
					<li>
						<router-link to="/links" @click.native="hiddenMenu">友链</router-link>
					</li>
					<!-- <li>关于</li> -->
				</ul>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	import Vue from 'vue'
	// Vue.component(
	// 	'Login',
	// 	() => import('@/components/login'),
	// )
	export default{
		data(){
			return{
				timeout: null,
				result: null,
				keys: '',
				update: true,
				isLogin: false,
				nickname: '游客',
				showLogin: false,
				head: '',
			}
		},
		created(){
			if(this.$getStorage('token')){
				this.isLogin = true;
				// this.nickname = this.$getStorage('nickname');
				this.$axios.post('/user/base',{
					token: this.$getStorage('token'),
				})
				.then((rep) => {
					if(rep.data.status == 0){
						this.nickname = JSON.parse(rep.data.ps).nickname;
						this.head = JSON.parse(rep.data.ps).head;
					}else if(rep.data.status == 3){
						this.$delStorage('token');
						this.isLogin = false;
					}
				})
			}
		},
		methods:{
			search(event){
				this.update = false;
				clearTimeout(this.timeout);
				this.timeout = setTimeout(()=>{
					const keyword = this.keys.replace(/(^\s*)|(\s*$)/g, "");
					if(keyword == ''){
						this.update = false;
						return false;
					}
					this.update = false;
					this.$axios.get('/article/search',{
						params:{
							key: keyword,
						}
					})
					.then((rep)=>{
						if(rep.data.status == 0){
							this.result = JSON.parse(rep.data.ps);
							this.update = true;
						}
					})
				},1000);
			},
			focusOut(){
				setTimeout(()=>{
					this.update = false;
				},100)
				
			},
			clickList(){
				this.$refs.search.focus();
				// console.log(33)
			},
			clickLogin(){
				// this.showLogin = true;
				this.$login(true);
			},
			clickRegister(){
				this.$register(true);
			},
			editNickname(){
				const nickname = this.$refs.nickname;
				// nickname.innerText = nickname.innerText.replace('\.{1,100}')
				if(nickname.innerText.length > 0){
					this.$axios.post('/user/nickname',{
						nickname: nickname.innerText,
						token: this.$getStorage('token'),
					})
					.then((rep)=>{
						this.$toast(rep.data.message);
						if(rep.data.status == 0){
							
						}
					})
					.catch((error) => {
						this.$toast('网络异常');
					});
				}
				
			},
			hiddenMenu(){
				this.$emit('hiddenMenu');
				// console.log(document)
			}
		}
	}
</script>
<style scoped>
	.container{
		width: 38.2%;
		height: 100%;
		background: #333;
	}
	.container>img{
		width: 100%;

	}
	.login{
		height: 10rem;
		background: url('../assets/aside.png') no-repeat;
		background-size: 100% 100%;
		overflow: auto;
	}
	.login .register{
		/*height: 6rem;*/
		height: 100%;
		position: relative;
	}
	.login .register ul{
		width: 100%;
		display: flex;
		position: absolute;
		top: 50%;
		left: 50%;
		
		transform: translateX(-50%);
	}
	.login .register ul li{
		flex: 1;
		font-size: 1.3rem;
		font-weight: bold;
		line-height: 3rem;
		color: #fff;
		text-align: center;
		cursor: pointer;
	}
	.login .register ul li:nth-child(1):after{
		/*border-right: 1px solid #fff;*/
		content: '|';
		float: right;
		color: #fff;
		font-size: 1rem;
    	font-weight: 200;
	}
	.login .register ul li:hover{
		color: #0f0;
		background: rgba(222,222,222,.2);
	}
	.login .logined{
		/*height: 80%;*/
		padding-top: 1.5rem;
		text-align: center;
	}
	.login .logined img{
		width: 5rem;
		height: 5rem;
		border-radius: 50%;
		background: #fff;
		box-shadow: 0 0 10px 0;
		animation: rotate 3s;
	}
	.login .logined div{
		color: #fff;
		font-size: 1.2rem;
		font-weight: bold;
	}
	.container .search{
		width: 100%;
		margin-top: 1rem;
		text-align: center;
		position: relative;
	}
	.container .search input{
		height: 2rem;
		width: 80%;
		/*border-radius: 1.2rem;*/
		padding: 0 .5rem;
		font-size: 1rem;
		box-sizing: border-box;
	}
	.container .search>div{
		width: 80%;
		max-height: 15rem;
		margin: 0 auto;
		position: absolute;
		left: 50%;
		transform: translateX(-50%);
		overflow: hidden;
		/*border-radius: 1.2rem;*/
	}
	.container .search div ul{
		max-height: 15rem;
		position: relative;
		top: 0;
		border-top: 1px solid #eee;
		background: #fff;
		overflow: auto;
	}
	.container .search div ul li{
		min-height: 2rem;
		line-height: 2rem;
		cursor: pointer;
		word-wrap:break-word;
	}
	.container .search div ul li:hover{
		background: #ccc;
	}
	.list{
		margin-top: 1rem;
	}
	.list ul li{
	    height: 2.5rem;
	    line-height: 2.5rem;
	    text-align: center;
	    cursor: pointer;
	    border-bottom: 1px solid #000;
	}
	.list ul li:nth-child(1){
		border-top: 1px solid #000;
	}
	.list ul li:hover{
		background: red;
	}
	.list ul li a{
		display: inline-block;
		width: 100%;
		height: 100%;
		color: #fff;
	    font-weight: bold;
	    font-size: 1.2rem;
	}

	.down-enter, .down-leave-to{
		transform: translateY(-100%);
		/*opacity: 0;*/
		/*top: 0;*/
	}
	.down-enter-to, .down-leave{
		transform: translateY(0);
		/*opacity: 1;*/
		/*top: -15rem;*/
	}
	.down-enter-active, .down-leave-active{
		transition: all .3s;
	}
	@keyframes rotate{
	  0%{
	    transform: rotate(0);
	  }
	  100%{
	    transform: rotate(360deg);
	  }
	}
</style>