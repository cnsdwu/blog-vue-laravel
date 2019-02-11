<template>
	<section class="container" ref="container">
		<s ref='fsdaf'></s>
		<ul>
			<li v-for="(data,index) in article" :key="index" @click="clickArticle(data.id)">
				<div class="cover" v-if="data.cover">
					<header>{{data.title}}</header>
					<figure>
						<img v-lazy="data.cover">
					</figure>
					<article>{{data.content}}</article>
					<footer>
						<span class="time">{{data.time}}</span>
						<span><s class="admire"></s>{{data.admire}}</span>
						<span><s class="commentnum"></s>{{data.commentNum}}</span>
					</footer>
				</div>
				<div class="images" v-else-if="data.path.length>2">
					<header>{{data.title}}</header>
					<article>{{data.content}}</article>
					<figure>
						<img v-if="indexa<9" v-for="(imgsrc,indexa) in data.path" v-lazy="imgsrc">
					</figure>
					<footer>
						<span class="time">{{data.time}}</span>
						<span><s class="admire"></s>{{data.admire}}</span>
						<span><s class="commentnum"></s>{{data.commentNum}}</span>
					</footer>
				</div>
				<div class="image" v-else-if="data.path[0]">
					<header>{{data.title}}</header>
					<div>
						<article>{{data.content}}</article>
						<figure>
							<img v-for="(imgsrc,indexa) in data.path" v-if="indexa<1" v-lazy="imgsrc" :class="indexa">
						</figure>
					</div>
					<footer>
						<span class="time">{{data.time}}</span>
						<span><s class="admire"></s>{{data.admire}}</span>
						<span><s class="commentnum"></s>{{data.commentNum}}</span>
					</footer>
				</div>
				<div class="plain" v-else>
					<header>{{data.title}}</header>
					<article>{{data.content}}</article>
					<footer>
						<span class="time">{{data.time}}</span>
						<span><s class="admire"></s>{{data.admire}}</span>
						<span><s class="commentnum"></s>{{data.commentNum}}</span>
					</footer>
				</div>
				
			</li>
		</ul>
	</section>
</template>
<script type="text/javascript">

	export default{
		name:'indexList',
		data(){
			return{
				article: new Array(),
			}
		},
		components:{
			
		},
		methods:{
			clickArticle(id){
				// window.location.href = '/indexs'
				this.$router.push(`/article/${id}`);
			}
		},
		created(){
			this.$loading();
			this.$setTitle('首页');
			// this.loading(false);
			this.$axios.get('/article/list')
			.then((res)=>{
				// console.log(res.data.ps);
				this.$loading().close();
				if(res.data.status == 0){
					this.article = JSON.parse(res.data.ps);
				}
				if(res.data.status == 1){
					this.article = [
						{
							title: '世界，你好！',
							content: '欢迎使用，您的站点现在还没有任何内容，赶快去添加试试吧！',
							path: [],
							admire: 0,
							commentNum: 0,
							id: 0,
						}
					];
				}
				// this.$loading(false);
				// console.log(this.article.length)
				// this.loading(false);
			})
		},
		activated(){
			// console.log(555)
			// this.loading(false);
		},
		mounted(){
			// this.loading(true);
		}
	}
</script>
<style scoped>
	.container{
		margin-bottom: 5rem;
		margin-top: 3rem;
	}
	li .cover figure{
		height: auto;
		overflow: hidden;
	}
	li .cover figure img{
		width: 100%;
		max-height: 30rem;
		/*transform: translateY(-38.2%);
		transition: .2s all 50ms;*/
	}
	figure img:hover{
		/*width: 150%;*/
		/*transform: translate(-25%,-45.2%);*/
	}
	ul>li{
		background-color: #fff;
		margin: .5rem 0;
		padding: .5rem 1rem;
		box-shadow: 0 0 15px -8px;
    	border-top: 1px solid #eee;
    	border-bottom: 1px solid #eee;
	} 
	ul>li header{
		padding-bottom: .5rem;
		/*margin: .25rem;*/
		font-weight: bold;
		border-bottom: 1px solid #eee;
		padding-left: 0;
		margin-left: 0;
	}
	ul>li article{
		margin: 2px 0;
		color: #333;
		word-wrap: break-word; 
		word-break: normal; 
	}
	ul>li footer{
		text-align: right;
		margin-right: .5rem;
		margin-top: .5rem;
		opacity: .7;
	}
	ul>li footer span{
    	display: inline-block;
		margin-right: -0.5rem;
		transform: scale(.8);
	}
	ul>li footer .time{
    	float: left;
	}
	ul>li footer .admire{
		width: 1rem;
		height: .9rem;
		line-height: 1rem;
		display: inline-block;
		background: url('../assets/admire.png') no-repeat;
		background-size: 1rem;
	}
	ul>li footer .commentnum{
		width: 1rem;
		height: .9rem;
		line-height: 1rem;
		display: inline-block;
		background: url('../assets/commentnum.png') no-repeat;
		background-size: 1rem;
	}
	li .images figure{
		/*display: flex;*/
		overflow: hidden;
	}
	li .images figure img{
		/*flex: 1;*/
		width: 31%;
		float: left;
		height: 10rem;
		margin: 1%;
	}
	li .image div{
		/*min-height: 10rem;*/
		overflow: hidden;
		/*height: auto;*/
	}
	li .image figure img{
		width: 100%;
		max-height: 30rem;
		/*float: right;*/
		padding: .25rem;
		border-radius: 1%;
		box-sizing: border-box;
		/*height: 8rem;*/
		/*transform: translateX(-50%);*/
	}
	li .image figure{
		width: 38%;
		/*float: right;*/
		border-radius: 5%;
		border: 1px solid #eee;
		overflow: hidden;
		display: inline-block;
	}
	li .image article{
		width: 61%;
		float: left;
		display: inline-block;
	}
</style>