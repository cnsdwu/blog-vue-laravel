<template>
	<div>
		<header class="header">
			<div @click="goBack"><img src="@/assets/back.png"></div>
			<div>留言板</div>
		</header>
		<div class="form">
			<p>留言</p>
			<form @submit.prevent="submit">
				<textarea v-model="content" placeholder="留言内容" autofocus required></textarea>
				<button>提交</button>
			</form>
		</div>
		<div class="list">
			<ul>
				<li v-for="(data, index) in guestBookList" :key="index">
					<div class="authorImg">
						<img v-lazy="data.head">
					</div>
					<div class="author">
						<span>{{data.nickname}}</span>
					</div>
					<div class="content">
						<p v-html="data.content"></p>
					</div>
					<div class="footer">
						<div class="time">{{data.time}}</div>
						<!-- <span><s class="admire"></s>{{data.admire}}</span> -->
						<!-- <span><s class="commentnum"></s>{{data.commentNum}}</span> -->
					</div>
					<div class="comment">
						<ul>
							<li></li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default{
		name: 'guestBook',
		data(){
			return{
				content: '',
				guestBookList: null,
			}
		},
		created(){
			this.$loading();
			this.$axios.get('/guestbook')
			.then((rep) => {
				this.$loading().close();
				if(rep.data.status == 0){
					this.guestBookList = JSON.parse(rep.data.ps);
				}
			})
			.catch((error) => {
				this.$loading().close();
				this.$toast('网络异常');
			});
		},
		methods:{
			goBack(){
				this.$router.go(-1);
			},
			submit(){
				if(this.$getStorage('token') == null){
					this.$messageBox(true);
					return false;
				}
				this.$loading({background: 'rgba(0, 0, 0, 0)'});
				this.$axios.post('/guestbook/add', {
					token: this.$getStorage('token'),
					content: this.content,
				})
				.then((rep) => {
					this.$loading().close();
					this.$toast(rep.data.message);
					if(rep.data.status == 0){
						this.content = '';
						this.$axios.get('/guestbook')
						.then((rep) => {
							if(rep.data.status == 0){
								this.guestBookList = JSON.parse(rep.data.ps);
							}
						})
						.catch((error) => {
							this.$loading().close();
							this.$toast('网络异常');
						});
					}else if(rep.data.status == 1){

					}
				})
				.catch((error) => {
					this.$toast('网络异常');
				});
			}
		}
	}
</script>
<style scoped>
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
	.form{
		margin-top: 4rem;
	}
	.form form{
		text-align: center;
	}
	.form p{
		text-align: center;
		font-weight: bold;
		font-size: 1.2rem;
	}
	.form textarea{
		display: block;
	    width: 95%;
	    min-height: 5rem;
	    margin: auto;
	    resize: vertical; 
	    font-size: 1rem;
	    padding: .5rem;
	}
	.form button{

	}
	.list li{
		position: relative;
		padding-left: 3rem;
		padding-right: 1rem;
		margin: .5rem 0;
		/*border-bottom: 1px solid rgba(233,233,233,.5);*/
		word-wrap: break-word;
		animation: right .5s;
	}
	..list li .author span{
		font-size: .8rem;
		color: blue;
	}
	.list li .authorImg{
		width: 2rem;
		height: 2rem;
		position: absolute;
		left: .5rem;
		top: .5rem;
		overflow: hidden;
		border-radius: 1rem;
	}
	.list li .authorImg img{
		width: 2rem;
	}
	.list li .content{
		margin-top: .5rem;
		padding-right: .5rem;
		background: rgba(233,233,233,.2);
	}
	.list li .content img{
		max-width: 100%;
	}
</style>