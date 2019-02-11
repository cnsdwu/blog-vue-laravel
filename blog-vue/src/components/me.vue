<template>
	<div>
		<div class="header">
			<div class="info">
				<div class="head">
					<img src="@/assets/my.png">
				</div>
				<div class="nickname">小呆先生</div>
				<div class="sign">莫道知君晚，为今尚惜缘</div>
			</div>
			<!-- <div class="footer">
				<ul>
					<li>关注0</li>
					<li>粉红0</li>
				</ul>
			</div> -->
		</div>
		<div class="list">
			<ul>
				<li>个人简介</li>
				<li>个人作品</li>
				<li>关于本站</li>
			</ul>
		</div>
	</div>
</template>
<script>
	export default{
		name: 'me',
		data(){
			return {

			}
		},
		created(){
			this.$setTitle('关于');
			this.$loading().close();
		}
	}
</script>
<style scoped>
	.header{
		/*height: 8rem;*/
		margin-bottom: 1rem;
		margin-top: 3rem;
    	box-shadow: 0 1rem 0 0 #eee;
	}
	.header .info .head{
		text-align: center;

	}
	.header .info .head img{
		border-radius: 50%;
	}
	.header .info .nickname{
		text-align: center;
		font-weight: bold;
	}
	.header .info .sign{
		text-align: center;
	}
	.header .footer ul{
		display: flex;
	}
	.header .footer ul li{
		display: inline-block;
		flex: 1;
		text-align: center;
	}
	.header .footer ul li:nth-child(1){
		border-right: 1px solid #eee;
	}
	.list ul li{
		text-align: center;
		height: 3rem;
		line-height: 3rem;
		cursor: pointer;
	}
	.list ul li:hover{
		background: #eee;
	}
</style>