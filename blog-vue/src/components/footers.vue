<template>
	<div>
		<footer class="footer">
			<ul>
				<li>
					<router-link to="/index">
						<span class="bgi footer-home"></span>
						<span class="nav">首页</span>
					</router-link>
				</li>
				<li>
					<!-- <router-link to="/category"> -->
					<a href="javascript:;">
						<span class="bgi footer-category"></span>
						<span class="nav">分类</span>
					</a>
					<!-- </router-link> -->
				</li>
				<li>
					<router-link to="/submit">
						<span class="bgi footer-submit"></span>
						<span class="nav">投稿</span>
					</router-link>
				</li>
				<li>
					<router-link to="/me">
						<span class="bgi footer-me"></span>
						<span class="nav">博主</span>
					</router-link>
				</li>
			</ul>
		</footer>
	</div>
</template>
<script type="text/javascript">
	export default{
		name:'footers',
		data(){
			return{
				
			}
		}
	}
</script>
<style scoped>
	.footer{
		width: 100%;
		position: fixed;
		bottom: 0;
		/*padding: 5px 0;*/
		background-color: #fff;
		border-top: 1px solid #eee;
	}
	.footer ul{
		width: 100%;
		height: 3rem;
		display: flex;
	}
	.footer ul>li:hover{
		background-color: #eee;
	}
	.footer ul>li{
		flex: 1;
		text-align: center;
	}
	.footer ul>li a{
		width: 100%;
		height: 100%;
		display: block;
	}
	.footer ul>li a .bgi{
		height: 61.8%;
		/*width: 100%;*/
		display: block;
	}
	.footer .footer-home{
		background: url('../assets/home.png') no-repeat;
		background-size: 2rem;
		background-position: 50%;
	}
	.footer .footer-category{
		background: url('../assets/category.png') no-repeat;
		background-size: 2rem;
		background-position: 50%;
	}
	.footer .footer-submit{
		background: url('../assets/submit.png') no-repeat;
		background-size: 2rem;
		background-position: 50%;
	}
	.footer .footer-me{
		background: url('../assets/me.png') no-repeat;
		background-size: 2rem;
		background-position: 50%;
	}
	.footer ul>li .nav{
		height: 38.2%;
		display: block;
	}
	.footer ul>li .nav:active{
		background: rgba(0,0,0,0);
		color: red;
	}
	.router-link-active{
		background: #eee;
	}
</style>