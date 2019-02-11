<template>
	<transition name="fade">
		<div class="mask">
			<div class="container">
				<div class="image">
					<!-- <div> -->
						<img :src="imgSrc">
					<!-- </div> -->
				</div>
				<div class="text">
					<p id="textMessage">消息</p>
				</div>
				<div class="button">
					<button @click="buttonSure">确定</button>
				</div>
			</div>
		</div>
	</transition>
</template>
<script type="text/javascript">
	export default{
		name: 'message',
		data(){
			return{
				images:[
					require('@/assets/warning.png'),
					require('@/assets/error.png'),
				],
				imgSrc: require('@/assets/warning.png'),
			}
		},
		props:{
			image: {
				default: 0,
			},
			// show: {
			// 	default: false,
			// },
			// text: {
			// 	default: '提示信息',
			// }
		},
		created(){
			this.imgSrc = this.images[this.image];
		},
		methods:{
			buttonSure(){
			this.$showMessage(false);
				// this.$emit('buttonSure');
				// console.log(this.showMessage)
				// this.showMessage = false;
			}
		}
	}
</script>
<style scoped>
	.mask{
		width: 100%;
		height: 100%;
		position: fixed;
		top: 0;
		left: 0;
		background: rgba(200,200,200,.3);
    	z-index: 55;
	}
	.container{
		width: 50%;
		height: 29%;
		position: fixed;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		background: #fff;
		border: 2px solid #29abe2;
	}
	.container .image{
		height: 65%;
		text-align: center;
	}
	.container .image img{
		height: 100%;
	}
	.container .text{
		height: 20%;
	}
	.container .text p{
		text-align: center;
		height: 100%;
    	line-height: 1.5rem;
    	font-weight: bold;
    	font-size: 1.3rem;
    	overflow: auto;
    	color: #29abe2;
	}
	.container .button{
		height: 15%;
		text-align: center;
		
	}
	.container .button button{
		width: 3.5rem;
		height: 1.8rem;
		line-height: 1.8rem;
		font-size: 1rem;
		background: #29abe2;
		border: none;
		border-radius: 3px;
		color: #fff;
		outline: none;
	}
	.container .button button:hover{
		background: #2092d8;
	}
	.fade-enter, .fade-leave-to{
		opacity: 0;
	}
	.fade-enter-to, .fade-leave{
		opacity: 1;
	}
	.fade-enter-active, .fade-leave-active{
		transition: all .5s;
	}
</style>