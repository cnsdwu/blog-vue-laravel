<template>
	<div class="mask" v-if="show" v-show="show2">
		<div class="container">
			<header>请输入信息后继续</header>
			<form @submit.prevent="submit">
				<div>
					<!-- <span>呢称</span> -->
					<input type="text" name="" placeholder="呢称*" v-model="nickname" required>
				</div>
				<div>
					<!-- <span>邮箱</span> -->
					<input type="email" name="" placeholder="邮箱*" v-model="email" required>
				</div>
				<div>
					<!-- <span>个人网站</span> -->
					<input type="text" name="" placeholder="个人网站" v-model="site" pattern="^(http://|.{0})[a-zA-Z0-9-_]+\.[a-zA-Z]+">
				</div>
				<div class="submit">
					<button v-if="showCencel" @click.prevent="cencel">取消</button>
					<button>确定</button>
				</div>
			</form>
			
		</div>
	</div>
</template>
<script type="text/javascript">
	export default{
		name: 'dialogs',
		data(){
			return{
				email: '',
				nickname: '',
				site: '',
				show2: true,
			}
		},
		props:{
			show:{
				default: false,
			},
			showCencel:{
				default: false,
			}
		},
		methods:{
			submit(){
				// console.log(this.email)
				if(this.email == '' ||this.nickname == ''){
					return false;
				}
				this.$axios.post('/login/temp', {
				      	email: this.email,
				      	nickname: this.nickname,
				      	site: this.site,
				})
				.then((rep)=>{
					console.log(rep.data)
					if(rep.data.status == 0){
						this.$setStorage('usertemp',rep.data.ps);
						this.$setStorage('nickname',this.nickname);
						this.show2 = false;
					}
				});
			},
			cencel(){
				this.$emit('cencel');
				// setTimeout(()=>{
				// 	this.show2 = false;
				// })
			}
		}
	}
</script>
<style scoped>
	.mask{
		width: 100%;
		height: 100%;
		position: fixed;
		z-index: 10;
		background: rgba(200,200,200,.3);
	}
	.container{
		width: 61.8%;
		position: fixed;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		border: 1px solid blue;
		/*box-shadow: 0 0 1px 0;*/
		padding: .5rem;
		background: #fff;
	}
	header{
		text-align: center;
		height: 2rem;
		line-height: 2rem;
		font-weight: bold;
	}
	input{
		width: 100%;
		border: 0;
		outline: none;
		background: #eee;
		margin: .1rem;
		height: 2rem;
		padding: 0 .5rem;
	}
	.submit{
		text-align: center;
	}
	.submit button{
		width: 3rem;
		height: 2rem;
		line-height: 2rem;
		background: #fff;
		border: 1px solid #eee;
		outline: none;
	}
	.submit button:active{
		color: green;
		border: 1px solid green;
	}
	.container form div{
		overflow: hidden;
	}
</style>