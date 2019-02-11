<template>
	<div>
		<div class="container">
			<header class="header">
				<div @click="goBack"><img src="@/assets/back.png"></div>
				<div>友情链接</div>
			</header>
			<div class="content">
				<h1>友情提示</h1>
				<ol>
					<li>本站注册会员均可申请友链且无需申核直接通过</li>
					<li>每位用户仅可申请一个站点，重复申请将会替换信息</li>
				</ol>
			</div>
			<hr>
			<div class="links">
				<ul>
					<li v-for="(data, index) in links" :key="index">
						<a :href="data.site" target="__black">
							<img :src="data.logo">
							<span>
								<div>{{data.name}}</div>
								<div>{{data.site}}</div>
							</span>
						</a>
					</li>
				</ul>
			</div>
			<div class="form">
				<p>申请友链</p>
				<form @submit.prevent="submit">
					<input type="text" placeholder="网站名称" v-model="name" required>
					<input type="text" placeholder="网站地址" v-model="site"  pattern="^(http:\/\/|https:\/\/)?[0-9a-zA-z-Z]+(\.[a-zA-Z]+)+$" required>
					<button>提交</button>
				</form>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default{
		data(){
			return{
				name: '',
				site: '',
				links: null,
			}
		},
		created(){
			this.$loading().close();
			this.$axios.get('/link')
			.then((rep) => {
				this.links = JSON.parse(rep.data.ps);
			})
			.catch((error ) => {

			});
		},
		methods:{
			goBack(){
				this.$router.go(-1);
			},
			submit(){
				this.$loading({background: 'rgba(0, 0, 0, 0)'})
				this.$axios.post('/link/add',{
					token: this.$getStorage('token'),
					name: this.name, 
					site: this.site,
				})
				.then((rep) => {
					this.$loading().close();
					this.$toast(rep.data.message);
					if(rep.data.status == 0){
					}else{

					}
				})
				.catch((error) => {
					this.$loading().close();
					this.$toast('网络异常');
				});
			}
		}
	}
</script>
<style scoped>
	.container{
		overflow: hidden;
		/*padding: 0 1rem;*/
	}
	header{
		height: 3rem;
		width: 100%;
		background: rgba(244,244,244,.8);
		border-bottom: 1px solid #eee;
		position: fixed;
		top: 0;
		text-align: center;
		z-index: 1;
	}
	header div{
		height: 3rem;
		line-height: 3rem;
		font-size: 1.3rem;
		text-align: center;
		/*position: absolute;*/
		left: 1rem;
		/*color: blue;*/
		cursor: pointer;
		display: inline-block;
	}
	header div:nth-child(1){
		position: absolute;
		line-height: 4rem;
	}
	header div:nth-child(2){
		max-width: 80%;
    	overflow: auto;
	}
	header div img{
		height: 1.5rem;
	}
	.content{
		margin-top: 3.5rem;
		padding: 0 1rem;
	}
	.content h1{
		text-align: center;
		font-weight: bold;
		font-size: 1.2rem;
	}
	.links ul{

	}
	.links li{
		height: 3rem;
		width: 48%;
		float: left;
		margin: .5rem 0;
		position: relative;
		overflow: hidden;
		cursor: pointer;
		/*background: #ddd;*/
		/*box-sizing: border-box;*/
	}
	.links li img{
		width: 2rem;
		height: 2rem;
		position: absolute;
		left: 1.5rem;
		top: 50%;
		transform: translateY(-50%);
		border-radius: 2rem;
	}
	.links li span{
		width: 100%;
		height: 100%;
		display: block;
		background: #ddd;
		padding-left: 3rem;
		margin-left: 1rem;
	}
	.links li span:hover{
		color: #fff;
		background: red;
	}
	.links li span div:nth-child(1){
		font-weight: bold;
		height: 1.75rem;
		line-height: 1.75rem;
		overflow: hidden;
	}
	.links li span div:nth-child(2){
		height: 1rem;
		line-height: 1rem;
		overflow: hidden;
		font-size: .8rem;
	}
	.form{
		padding: 0 1rem;
	}
	.form>p{
		text-align: center;
		font-weight: bold;
		clear:both;
	}
	.form form{
		text-align: center;
	}
	.form input{
		display: block;
		width: 100%;
		border: 1px solid #eee;
		margin: .5rem 0;
	    height: 2rem;
	    font-size: 1rem;
	    padding: 0 .5rem;
	    box-sizing: border-box;
	}
	.form button{
		width: 3rem;
	    height: 2rem;
	    background: #eee;
	}
</style>