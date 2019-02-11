<template>
	<div class="wrap">
		<div class="container">
			<p id="textMessage" ref="text">提示信息</p>
		</div>
	</div>
</template>
<script type="text/javascript">
	export default{
		name: 'message',
		data(){
			return{

			}
		},
		created(){
			setTimeout(()=>{
				// this.$refs.text.style.transform = 'translateX(-50%)';
				console.log(555)
				// this.$showMessage(false);
			},5000)
		},
		mounted(){
				// this.$showMessage(false);
				console.log(555)

		}
	}
</script>
<style scoped>
	.wrap{
	}
	.container p{
		/*width: 5rem;*/
		/*height: 3rem;*/
		min-width: 1rem;
		max-width: 30%;
		position: fixed;
		bottom: 20%;
		left: 0;
		right: 0;
		margin: auto;
		opacity: 0;
		text-align: center;
		/*transform: translateX(-50%);*/
		background: #ccc;
		animation: animations 3s;
		padding: .5rem;
		background: rgba(230, 0, 0, 0.5); 
		border-radius: .2rem; 
		color: rgb(255, 255, 255); 
		/*top: 80%; */
		z-index: 1000001; 
		/*transform: translate3d(-50%, -50%, 0px); */
		/*animation-duration: 0.5s;*/
	}
	.container p:hover{
		/*transform:translate(-60px);*/

	}
	@keyframes animations{
		/*0%{transform:scale(0);opacity:0;}
	    50%{transform:scale(.5);opacity:.5;}
	    70%{transform:scale(.75);opacity:.75;}
	    100%{transform:scale(1);opacity:1;}*/
	    0%,100%{
	    	opacity: 0;
	    	transform: scale(0.01);
	    }
	    9%,15%,87%,93%{
	    	transform: scale(1.2);
	    }
	    13%,17%,83%,91%{
	    	transform: scale(1);
	    }
	    5%,95%{
	    	opacity: 1;
	    	transform: scale(1);
	    }
/*		0%{
			opacity: 0;
		}
		25%{
			opacity: .25;
		}
		50%{
			opacity: .5;
		}
		100%{
			opacity: 1;
		}*/

	}

</style>