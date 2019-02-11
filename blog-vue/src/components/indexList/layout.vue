<template>
	<div>
		<header>{{data.title}}</header>
		<figure v-if="data.cover">
			<img :src="data.cover">
		</figure>
		<!-- <figure v-else-if="data.path[0]">
			<img :src="data.path[0]">
		</figure> -->
		<article v-html="data.content"></article>
		<footer>
			<span class="time">{{data.time}}</span>
			<span><s class="admire"></s>{{data.admire}}</span>
			<span><s class="commentnum"></s>{{data.commentNum}}</span>
		</footer>
	</div>
</template>
<script>
	export default{
		name: 'ListLayout',
		data(){
			return{
				data: '',
			}
		},
		props:{
			dataa: {
				default: '55'
			}
		},
		mounted(){
			this.data = this.dataa;
			console.log(this.dataa)
		}
	}
</script>
<style scoped>
		.container{
		margin-bottom: 5rem;
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
		/*opacity:0;visibility:hidden;-webkit-transform:scale(1.2);-moz-transform:scale(1.2);transform:scale(1.2);-webkit-transition:all .3s;-o-transition:all .3s;-moz-transition:all .3s;transition:all .3s*/
	}
	ul>li{
		background-color: #fff;
		margin: .5rem 0;
		padding: 5px;
		box-shadow: 0 0 15px -8px;
    	border-top: 1px solid #eee;
    	border-bottom: 1px solid #eee;
		/*box-shadow: rgba(0,0,0,.5);*/
	} 
	ul>li header{
		/*font-size: 1.5rem;*/
		padding: .25rem;
		margin: .25rem;
		font-weight: bold;
		border-bottom: 1px solid #eee;
	}
	ul>li article{
		margin: 2px 0;
		color: #333;
	}
	ul>li footer{
		text-align: right;
		margin-right: 5px;
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
		/*background: url('../assets/admire.png') no-repeat;*/
		background-size: 1rem;
	}
	ul>li footer .commentnum{
		width: 1rem;
		height: .9rem;
		line-height: 1rem;
		display: inline-block;
		/*background: url('../assets/commentnum.png') no-repeat;*/
		background-size: 1rem;
	}
</style>