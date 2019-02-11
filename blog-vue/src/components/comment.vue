<template>
	<section class="commentContent">
		<div class="commentTotal">
			<span class="commentNum">{{comments.length}}条评论</span>
			<span @click="showOrder" class="commentNow">{{order}}</span>
			<ul v-show="orderShow" @click="selectOrder" class="commentOrder">
				<li>最新评论</li>
				<li>热门评论</li>
				<li>时间倒序</li>
				<li>时间正序</li>
			</ul>
		</div>
		<div>
			<ul>
				<li class="commentList" v-for="(data,index) in comments">
					<div class="authorImg">
						<img :src="data.head">
					</div>
					<div class="author">
						<span>{{data.author}}</span>
					</div>
					<div class="content">
						<div class="ql-snow">
							<p v-html="data.content" class="ql-editor"></p>
						</div>
					</div>
					<div class="footer">
						<div class="time">{{data.time}}</div>
						<span><s class="admire"></s>{{data.admire}}</span>
						<span><s class="commentnum"></s>{{data.commentNum}}</span>
					</div>
					<div class="comment">
						<ul>
							<li></li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</section>
</template>
<script type="text/javascript">
	export default{
		name: 'comment',
		data(){
			return{
				commentDefault: true,
				order: '最新评论',
				orderShow: false,
				comments:new Array(),
			}
		},
		props:{
			articleId:{
				default: 0,
			}
		},
		methods:{
			selectOrder(event){
				const li = event.srcElement? event.srcElement:event.target;
				this.order = li.innerHTML;
				this.orderShow = false;
			},
			showOrder(event){
				this.orderShow = true;
			}
		},
		created(){
			// this.$loading(true,0);
			this.$axios.get('/comment/list',{
				params:{
					id: this.articleId,
				}
			})
			.then((data)=>{
				this.$loading().close();
				if(data.data.status == 0){
					this.comments = JSON.parse(data.data.ps);
					// this.article.content = this.article.content.replace(/src=\"/g, 'data-src="');
					// this.article.content = this.article.content.replace(/allowfullscreen=\"true\" data-src="/g, 'src="');
					if(this.comments.length == 0){
						// this.comments = [{}]
					}
				}
			})
		}
	}
</script>
<style scoped>
	
	.footer .admire{
		width: 1rem;
		height: .9rem;
		line-height: 1rem;
		display: inline-block;
		background: url('../assets/admire.png') no-repeat;
		background-size: 1rem;
	}
	.footer .commentnum{
		width: 1rem;
		height: .9rem;
		line-height: 1rem;
		display: inline-block;
		background: url('../assets/commentnum.png') no-repeat;
		background-size: 1rem;
	}
	.commentContent{
		margin-bottom: 3.4rem;
	}
	.commentContent .commentTotal{
		height: 2rem;
		position: relative;
		line-height: 2rem;
		border-top: 1px solid rgba(0,0,0,.1);
		border-bottom: 1px solid rgba(0,0,0,.1);
		animation: opacity .5s;
	}
	.commentContent .commentTotal .commentNum{
		margin-left: 1rem;
	}
	.commentContent .commentTotal .commentNow{
		float: right;
		margin-right: 1rem;
	}
	.commentContent .commentTotal .commentOrder{
		position: absolute;
		right: .5rem;
		/*padding: 0 .5rem;*/
		background-color: #fff;
    	/*border: 1px solid rgba(0,0,0,.5);*/
    	box-shadow: 0 0 5px -3px;
    	z-index: 1;
	}
	.commentContent .commentTotal .commentOrder li{
		padding: .3rem .5rem;
	}
	.commentContent .commentList{
		position: relative;
		padding-left: 3rem;
		padding-right: 1rem;
		margin: .5rem 0;
		border-bottom: 1px solid rgba(233,233,233,.5);
		word-wrap: break-word;
		animation: right .5s;
	}
	.commentContent .commentList .author span{
		font-size: .8rem;
		color: blue;
	}
	.commentContent .commentList .authorImg{
		width: 2rem;
		height: 2rem;
		position: absolute;
		left: .5rem;
		top: .5rem;
		overflow: hidden;
		border-radius: 1rem;
	}
	.commentContent .commentList .authorImg img{
		width: 2rem;
	}
	.commentContent .commentList .content{
		margin-top: .5rem;
		padding-right: .5rem;
		background: rgba(233,233,233,.2);
	}
	.commentContent .commentList .content img{
		max-width: 100%;
	}
	.commentContent .author{
		
	}
	.commentContent .author img{
		
	}
	.commentContent .commentList .content figure img{
		max-width: 100%;
		max-height: 10rem;
	}
	.commentContent .commentList .footer{
		text-align: right;
		margin-right: .5rem;
		opacity: .7;
	}
	.commentContent .commentList .footer span{
		display: inline-block;
		transform: scale(.8);
	}
	.commentContent .commentList .time{
		float: left;
		font-size: .8rem;
		opacity: .7;
	}

	@keyframes opacity{
	  0%{
	    opacity: 0;
	  }
	  100%{
	    opacity: 1;
	  }
	}
	@keyframes right{
	  0%{
	    opacity: 0;
	    transform: translateX(-3rem);
	  }
	  100%{
	    opacity: 1;
	    transform: translateY(0);
	  }
	}
</style>