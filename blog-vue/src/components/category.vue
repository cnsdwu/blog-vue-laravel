<template>
	<div>
		<header>
			<ul>
				<li><router-link to="/category/text" replace>文章</router-link></li>
				<li><router-link to="/category/share" replace>活动</router-link></li>
				<li><router-link to="/category/video" replace>视频</router-link></li>
				<li><router-link to="/category/music" replace>音乐</router-link></li>
				<li><router-link to="/category/file" replace>文件</router-link></li>
			</ul>
		</header>
		<section>
			<router-view></router-view>
		</section>
		<footer>
			
		</footer>
	</div>
</template>
<script type="text/javascript">
	
</script>
<style scoped>
	header{
		width: 100%;
		height: 2rem;
		line-height: 2rem;
		position: fixed;
		top: 0;
		z-index: 1;
		background-color: #fff;
		border-bottom: 1px solid rgba(200,200,200,.1);
	}
	header ul{
		display: flex;
	}
	header ul>li{
		float: left;
		flex: 1;
		text-align: center;
	}
	header ul>li a{
		display: inline-block;
		width: 100%;
	}
	section{
		margin-top: 2rem;
	}
</style>