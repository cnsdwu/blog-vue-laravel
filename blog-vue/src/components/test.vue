<template>
	<div v-if="show">
		laskjflkasdjfl;askj;fdljas;fkjas;fjasf
	</div>
</template>
<script type="text/javascript">
	export default{
		data(){
			return{
				show: true
			}
		},
		created(){
			// this.$axios.post('http://blog.cn/api/user/nickname', {
			// 	// params:{
			// 	// 	id: 5,
			// 	// }
			// 	    token: '5a868eed8fc25aed6450a40ad5cdccbb',
			// 	    nickname: '333',
			// 	})
			// 	.then((response)=>{
			// 		console.log(response.data)
			//   	})
			//   	.catch(function (error) {
			// 	    console.log(error);
			// 	});
			this.$axios.post('http://blog.cn/api/login/temp', {
				// params:{
				// 	id: 5,
				// }
				    token: '5a868eed8fc25aed6450a40ad5cdccbb',
				    nickname: '333',
				})
				.then((response)=>{
					console.log(response.data)
			  	})
			  	.catch(function (error) {
				    console.log(error);
				});
		}
	}
</script>
<style scoped>
	
</style>