<template>
	<transition name="fade">
	<div>
		<!-- <component is="Message" :show="showMessage" :text="textMessage" @buttonSure="MessageSure"/></component> -->
		<div class="container">
			<header>插入图片</header>
			<ul class="way">
				<li>图片地址</li>
				<li>本地上传</li>
			</ul>
			<section>
				<div class="upload">
					<input id="file" type="file" @change="selectImg">
					<div @click="clickUpload" class="select">
						<span>选择图片</span>
						<span id="filepath"></span>
					</div>
					<span class="submit" ref="submitbutton" @click="upload" :class="{'disable': isA}">上传</span>
				</div>
				<div>
					<ol>
						<li>文件大小限制10MB</li>
						<li>允许格式：png,jpg,gif,jpeg,bmp,svg,webp</li>
					</ol>
					<div class="wrap">
						<div id="preview" class="preview" ref="imgheight">
							<img v-cloak :src="viewimg" ref="img">
						</div>
						<!-- <div class="desc" contenteditable="true">图片描述</div> -->
						<component is="inputDiv" v-if="desc" class="desc" defaults="图片描述" textAlign="center" ref="desc"/></component>
					</div>
				</div>
			</section>
			<footer>
				<button class="cancel" @click="cancel">取消</button>
				<button class="submit" @click="submit" ref="submit" :class="{'disable': isB}">确定</button>
			</footer>
		</div>
	</div>
	</transition>
</template>
<script>
	// import Vue from 'vue'
	import inputDiv from '@/components/plug/inputdiv'
	// import Message from '@/components/plug/message'
	// Vue.component(
	// 	'Message',
	//   	() => import('@/components/plug/message')
	// );
	export default{
		name:'imageupload',
		data(){
			return{
				viewimg: '',
				file: null,
				srcpath: '',
				isA: true,
				isB: true,
				// showMessage: false,
				// textMessage: '提示信息',
			}
		},
		components:{
			inputDiv,
			// Message,
		},
		props: {
			previewheight:{
				type: String,
				default: '6.4',
			},
			desc:{
				default: false,
			}
		},
		methods:{
			//点击上传
			clickUpload(){
				document.querySelector('#file').click();
			},
			// 选择图片后
			selectImg(event){
				const files = event.srcElement? event.srcElement:event.target;
				// console.log(event);
				if (window.FileReader) {
					// console.log(files.files)
					if(files.files.length){
						if(files.files[0].size < 10*1024*1024){
							const fileName = files.files[0].name;
                			if(fileName.match(/([^\\\/]*\.(png|jpg|gif|jpeg|bmp|svg|webp)$)/i)){
	                			document.querySelector("#filepath").innerText = files.files[0].name;
								var filereader = new FileReader();
								filereader.readAsDataURL(files.files[0]);
								filereader.onload = this.loadImg;
								this.file = files;
                			}else{
                				this.$toast('格式不被支持');
	                			// this.textMessage = '图片格式不被支持';
								// this.showMessage = true;
                			}
							
						}else{
							this.$toast('大小超过限制');
							// this.textMessage = '图片大小超过限制';
							// this.showMessage = true;
						}
						
					}
				 }else{

				 }
			},
			// 图片准备好
			loadImg(event){
				const srcpath = event.target.result;
				this.viewimg = srcpath;
				setTimeout(()=>{
					if(this.previewheight == 'auto'){
						this.$refs.imgheight.style.height = this.$refs.img.offsetHeight + 'px';
					}
				});
				this.$refs.submitbutton.innerText = '上传';
				this.$refs.submitbutton.pointerEvents = 'none';
				this.$refs.submitbutton.style.background = 'red';
				this.$refs.submitbutton.style.color = '#fff';
				this.isA = false;

			},
			// 上传界面取消
			cancel(){
				// document.querySelector('#fileupload').style.display = 'none';
				this.$emit('addCover');
			},
			// 点击确定
			submit(){
				if(this.viewimg != '' && this.srcpath != ''){
					this.$emit('imagePath',{
						base64: this.viewimg,
						path: this.srcpath,
						desc: this.desc? this.$refs.desc.$refs.text.innerText:'',
					});
				}
				// this.$emit('addCover');
			},
			upload(){
				this.$refs.submitbutton.innerText = '上传中';
				const file = this.file.files[0];
				let formdata = new FormData();// 创建form对象  
				formdata.append('img',file,file.name);// 通过append向form对象添加数据,可以通过append继续添加数据  
				//或formdata1.append('img',file);  
				formdata.append('token', this.$getStorage('token'));
				let config = {  
				    headers:{'Content-Type':'multipart/form-data'}  
				};  //添加请求头  
				this.$axios.post('/upload/image',formdata,config)
				.then((response)=>{   //这里的/xapi/upimage为接口  
				    if(response.data.status == 0){
				    	this.$refs.submitbutton.innerText = '成功';
				    	this.$refs.submitbutton.style.background = '#ccc';
				    	this.srcpath = response.data.ps;
				    	this.$refs.submit.style.cursor = 'pointer';
				    	this.isB = false;
				    	this.isA = true;
				    }else{
				    	this.$refs.submitbutton.innerText = '失败';
				    }
				});
			}
		},
		mounted(){
			// console.log(this.$refs.imgheight);
			// this.$refs.imgheight.style.height = this.previewheight + 'rem';
		}
	}
</script>
<style scoped>
	.container{
		width: 80%;
		position: fixed;
		top: 50%;
		left: 50%;
		line-height: 1.5rem;
		transform: translate(-50%,-50%);
		/*display: none;*/
		background: #fff;
		border: 1px solid rgba(200,200,200,.5);
		z-index: 1;
	}
	header{
		padding: .5rem 0;
		text-align: center;
		background: #eee;
		/*border-bottom: 1px solid rgba(200,200,200,.5);*/
	}
	section .upload{
		text-align: center;
		height: 1.5rem;
	}
	section .upload input{
		display: none;
	}
	section .upload .select{
		width: 80%;
		display: inline-block;
		text-align: left;
		float: left;
		border: 1px solid #ddd;
		border-radius: 3px;
		white-space:nowrap;
		overflow: hidden;
	}
	section .upload .select span:nth-child(1){
		background: #eee;
		display: inline-block;
    	padding: .2rem;
	}
	section .upload .select span:nth-child(2){
		display: inline-block;
	}
	section .upload .submit{
		width: 15%;
		height: 1.5rem;
		overflow: hidden;
		text-align: center;
		float: right;
		background: #ccc;
		display: inline-block;
    	padding: .2rem;
    	cursor: pointer;
    	line-height: 1.5rem;
    	
	}
	.way{
		width: 100%;
		display: flex;
	}
	.way li{
		flex: 1;
		text-align: center;
		padding: .1rem 0;
	}
	.wrap .desc{
		text-align: center;
		opacity: .6;
	}
	.wrap .desc .default{
		text-align: center;
		opacity: .6;
		transform: translate(-50%,-50%);
    	left: 50%;
	}
	.preview{
		border: 1px solid #eee;
		min-height: 6.4rem;
		max-height: 30rem;
		overflow: auto;
	}
	.preview img{
		width: 100%;
	}
	footer{
		padding: .5rem 0;
		text-align: center;
		border-top: 1px solid #eee;
	}
	footer button{
		outline: none;
		width: 3rem;
		height: 2rem;
		line-height: 2rem;
	}
	footer .cancel{
		background: #797979;
		color: #fff;
		border: none;
	}
	footer>.submit{
		background: green;
		color: #fff;
		border: none;
	}
	.disable{
		pointer-events: none;
		cursor: not-allowed !important;
		opacity: .6;
	}
	.fade-enter, .fade-leave-to{
		/*transform: scale(0);*/
		opacity: 0;
		/*width: 0;*/
		/*transform: translateY(-100%);*/
	}
	.fade-enter-to, .fade-leave{
		/*transform: scale(1);*/
		opacity: 1;
		/*width: 10rem;*/
		/*transform: translateY(50%);*/
	}
	.fade-enter-active, .fade-leave-active{
		transition: opacity .5s;
	}
</style>