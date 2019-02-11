<template>
	<section class="container">
		<div class="header">
			<span>250条数据</span>
			<span @click="showOrder" class="now">{{order}}</span>
			<ul v-if="orderShow" @click="selectOrder" class="list">
				<li>最新评论</li>
				<li>热门评论</li>
				<li>时间倒序</li>
				<li>时间正序</li>
			</ul>
		</div>
		<ul class="articleList">
			<li v-for="(data,index) in article" :key="index" @click="clickArticle">
				<header>{{data.title}}</header>
				<figure v-if="data.image">
					<img :src="data.image">
				</figure>
				<article>{{data.content}}</article>
				<footer>
					<span><s class="admire"></s>{{data.admire}}</span>
					<span><s class="commentnum"></s>{{data.commentNum}}</span>
				</footer>
			</li>
		</ul>
	</section>
</template>
<script type="text/javascript">
	export default{
		name:'categoryText',
		data(){
			return{
				order: '最新评论',
				orderShow: false,
				article:[
					{
						title: '这是一个标题',
						content: '这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！',//50个字符
						admire: 125,
						commentNum: 250,
						image: require('../../assets/img1.jpg'),
					},{
						title: '这是一个标题',
						content: '这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！',//50个字符
						admire: 125,
						commentNum: 250,
						image: require('../../assets/img2.jpg'),
					},{
						title: '这是一个标题',
						content: '这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！',//50个字符
						admire: 125,
						commentNum: 250,
						image: require('../../assets/img3.jpg'),
					},{
						title: '这是一个标题',
						content: '这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！',//50个字符
						admire: 125,
						commentNum: 250,
						image: '',
					},{
						title: '这是一个标题',
						content: '这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！这是文章什么的内容！',//50个字符
						admire: 125,
						commentNum: 250,
						image: require('../../assets/img2.jpg'),
					}
				]
			}
		},
		methods:{
			clickArticle(){
				// window.location.href = '/indexs'
				this.$router.push('/article/1')
			},
			selectOrder(event){
				this.order = event.srcElement.innerHTML;
				this.orderShow = false;
			},
			showOrder(event){
				this.orderShow = true;
			}

		}
	}
</script>
<style type="text/css" scoped>
	.container{
		margin-bottom: 5rem;
	}
	.header{
		height: 2rem;
		position: relative;
		line-height: 2rem;
		border-top: 1px solid rgba(0,0,0,.1);
		border-bottom: 1px solid rgba(0,0,0,.1);
	}
	.header .now{
		float: right;
		margin-right: .5rem;
	}
	.header .list{
		position: absolute;
		right: .5rem;
		/*padding: 0 .5rem;*/
		background-color: #fff;
    	/*border: 1px solid rgba(0,0,0,.5);*/
    	box-shadow: 0 0 5px -3px;
    	z-index: 1;
	}
	.header .list li{
		padding: .3rem .5rem;
	}
	figure{
		height: 8rem;
		overflow: hidden;
	}
	figure img{
		width: 100%;
		transform: translateY(-38.2%);
		transition: .2s all 50ms;
		/*height: 5rem;*/
	}
	figure img:hover{
		width: 150%;
		transform: translate(-25%,-45.2%);
	}
	.articleList li{
		background-color: #fff;
		margin: .5rem 0;
		padding: 5px;
		box-shadow: 0 0 15px -8px;
    	border-top: 1px solid #eee;
    	border-bottom: 1px solid #eee;
		/*box-shadow: rgba(0,0,0,.5);*/
	} 
	.articleList li header{
		/*font-size: 1.5rem;*/
		padding: .25rem;
		margin: .25rem;
		font-weight: bold;
		border-bottom: 1px solid #eee;
	}
	.articleList li article{
		margin: 2px 0;
		color: #333;
	}
	.articleList li footer{
		text-align: right;
		margin-right: 5px;
		opacity: .7;
	}
	.articleList li footer span{
    	display: inline-block;
		margin-right: -0.5rem;
		transform: scale(.8);
	}
	.articleList li footer .admire{
		width: 1rem;
		height: .9rem;
		line-height: 1rem;
		display: inline-block;
		background: url('../../assets/admire.png') no-repeat;
		background-size: 1rem;
	}
	.articleList li footer .commentnum{
		width: 1rem;
		height: .9rem;
		line-height: 1rem;
		display: inline-block;
		background: url('../../assets/commentnum.png') no-repeat;
		background-size: 1rem;
	}

</style>