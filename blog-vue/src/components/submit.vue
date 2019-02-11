<template>
	<div>
		<!-- <component is="Message" :show="showMessage" :text="textMessage" @buttonSure="MessageSure"/></component> -->
		<component is="Dialog" :show="showDialog" @cencel="DialogCencel"/></component>
        <input type="file" ref="imgupload" @change="selectImage">
		<div class="container">
			<header>
				<span class="headerTitle">投稿</span>
				<span class="submit" @click="submit">提交</span>
			</header>
			<figure>
				<div @click="addCover" class="addCover" ref="addCover">
					<span>+</span>
					<span>添加封面</span>
				</div>
				<img src="" ref="cover"  @click="addCover">
			</figure>
			<component is="ImageUpload" @addCover="addCover" @imagePath="coverPath" v-show="coverupload" /></component>
			<div class="title">
				<input type="text" placeholder="标题" v-model="title">
				<!-- <inputDiv defaults="标题" ref="title"/> -->
			</div>
			<div class="content">
				<!--富文本编辑器组件-->
	        	<quillEditor
	        	    v-model="content"
	        	    ref="myQuillEditor"
	        	    :options="editorOption"
	        	    @change="onEditorChange($event)"
	        	    @ready="onEditorReady($event)"
	        	>
	        	</quillEditor>
			</div>
			<!-- <footer>
				<div class="left">
					<span @click="addImage">
						<img src="@/assets/image.png">
					</span>
					<component is="ImageUpload" @addCover="addImage" @imagePath="imagePath" v-show="imageupload" previewheight="auto" desc="true"/></component>
				</div>
				<div class="right">
					<span>设置</span>
				</div>
			</footer> -->
			
		</div>
	</div>
</template>
<!-- <script src="/node_modules/quill-image-resize-module/image-resize.min.js"></script> -->
<script>
	// import Quill from 'quill'
	import Vue from 'vue'
	// import VueQuillEditor from 'vue-quill-editor'
	// import inputDiv from '@/components/plug/inputdiv'
	import { quillEditor } from 'vue-quill-editor'
	import 'quill/dist/quill.core.css'
	import 'quill/dist/quill.snow.css'
	// import '../../node_modules/quill-image-resize-module/image-resize.min.js'
	// import { ImageResize } from 'quill-image-resize-module';
	// import ImageResize from 'quill-image-resize-module'
	// Quill.register('modules/imageResize', ImageResize)
	// quillEditor.register('modules/imageResize', ImageResize)
	// import 'quill/dist/quill.bubble.css'
	// import Dialog from '@/components/plug/dialog'
	// import Message from '@/components/plug/message'
	// import ImageUpload from '@/components/imageupload'
	// Vue.component(
	// 	'Message',
	//   	() => import('@/components/plug/message')
	// );
	Vue.component(
		'ImageUpload',
	  	// 这个 `import` 函数会返回一个 `Promise` 对象。
	  	() => import('@/components/imageupload')
	);
	// Vue.component(
	// 	'Dialog',
	//   	// 这个 `import` 函数会返回一个 `Promise` 对象。
	//   	() => import('@/components/plug/dialog')
	// );
	export default{
		name: 'submit',
		data(){
			return{
				title: '',
				// editable: true,
				coverupload: false,
				// imageupload: false,
				images: [],
				// desc: [],
				cover: '',
				showDialog: false,
				content: '',
				editorOption: {
		          	// theme: 'bubble',
		          	placeholder: "输入正文内容",
		          	modules: {
		            	toolbar: {
                    	    container: [
				    	        ['bold', 'italic', 'underline', 'strike', 'blockquote', 'code-block'],
				    	        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
				    	        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
				    	        [{ 'color': [] }, { 'background': [] }],
				    	        // [{ 'font': [] }],
				    	        [{ 'align': [] }],
				    	        ['link', 'image', 'video'],
				    	        ['clean']
			        	    ],  // 工具栏
                    	    handlers: {
                    	        'image': (value) => {
				    	         if (value) {
				    	         // 触发input框选择图片文件
				    	            // document.querySelector('.avatar-uploader input').click()
				    	            this.$refs.imgupload.click();
				    	           } else {
				    	            this.quill.format('image', false);
				    	          }
				    	       }
                    	    }
                    	},
		      		}
		        },
                serverUrl: 'http://blog.cn/api/upload/image',  // 这里写你要上传的图片服务器地址
                // headers: {'Origin': 'http://blog.cn'},  // 有的图片服务器要求请求头需要有token之类的参数，写在这里
			}
		},
		components:{
			// inputDiv,
			quillEditor,
			// ImageUpload,
			// Dialog,
			// Message,
		},
		methods:{
			// 显示隐藏封面图片上传
			addCover(){
				this.coverupload = !this.coverupload;
			},
			// 发布
			submit(){
				this.$loading();
				this.$axios.post('/article/add', {

			    	token: this.$getStorage('token'),
			      	// account: 'test',
			      	// password: '123',
			      	type: 1,
			      	title: this.title,
			      	content: this.content,
			      	images: this.images,
			      	// desc: this.desc,
			      	cover: this.cover,
				    
				})
				.then((response)=>{
					this.$loading().close();
					this.$toast(response.data.message);
					if(response.data.status == 0){
						this.$router.push({path: `/article/${response.data.ps}`})
					}else if(response.data.status == 2){
						// this.$delStorage('token');
						this.$messageBox(true);
					}
			  	})
			  	.catch(function (error) {
				    this.$loading().close();
				    this.$toast('网络异常');
				});
			},
			// 获得上传封面图片地址
			coverPath(data){
				// console.log(event,path);
				this.coverupload = !this.coverupload;
				this.$refs.addCover.style.display = 'none';
				this.$refs.cover.src = data.path;
				this.$refs.cover.style.display = 'block';
				this.cover = data.path;
			},
			DialogCencel(){
				this.showDialog = false;
			},
			onEditorChange({ editor, html, text }) {
		        // console.log('editor change!', editor, html, text)
		        this.content = html
		    },
		    onEditorReady(){

		    },
            selectImage(event){
            	let file = this.$refs.imgupload.files[0];
            	if(file){

					if(file.size < 10*1024*1024){
						const fileName = file.name;
            			if(fileName.match(/([^\\\/]*\.(png|jpg|gif|jpeg|bmp|svg|webp)$)/i)){
							let filereader = new FileReader();
							filereader.readAsDataURL(file);
							filereader.onload = () =>{
								let formdata = new FormData();// 创建form对象  
								formdata.append('img', file, fileName);// 通过append向form对象添加数据,可以通过append继续添加数据  
								//或formdata1.append('img',file);  
								formdata.append('token', this.$getStorage('token'));
								let config = {  
								    headers:{'Content-Type':'multipart/form-data'}  
								};  //添加请求头  
								this.$loading({background: 'rgba(0, 0, 0, 0)'});
								this.$axios.post('/upload/image',formdata,config)
								.then((rep)=>{   //这里的/xapi/upimage为接口  
								    if(rep.data.status == 0){
								    	// res为图片服务器返回的数据
						                // 获取富文本组件实例
						                let quill = this.$refs.myQuillEditor.quill
					                    // 获取光标所在位置
					                    let length = quill.getSelection().index;
					                    // 插入图片  res.info为服务器返回的图片地址
					                    quill.insertEmbed(length, 'image', rep.data.ps)
					                    // 调整光标到最后
					                    quill.setSelection(length + 1)
					                    this.images.push(rep.data.ps);
						                // loading动画消失
						                // this.quillUpdateImg = false
						                this.$loading().close();
								    }else{
								    	this.$toast(rep.data.message);
								    }
								});
							}
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
            }
		},
		mounted(){
			this.quillUpdateImg = false;
			// this.$messageBox(true);
			// console.log(document.querySelectorAll('input[name=img]'));
		},
		created(){
			this.$setTitle('投稿');
			// this.$loading(false);
			
			// let temp = this.$loading();
			// this.$nextTick(() => { // 以服务的方式调用的 Loading 需要异步关闭
			//   loadingInstance.close();
			// });
			// console.log(this.$getStorage('usertemp'))
			setTimeout(()=>{
				if(this.$getStorage('token') == null){
					this.$messageBox(true);
				}else{
					this.$messageBox(false);
				}
			})
			// console.log(this.$refs.text)
		}
	}
</script>
<style scoped>
	.container{
		/*height: 100%;*/
		/*width: 100%;*/
		padding: 2rem .5rem;
		background-color: #fff;
	}
	header{
		width: 100%;
		height: 2rem;
		line-height: 2rem;
		position: fixed;
		top: 0;
		z-index: 1;
		background-color: #fff;
		border-bottom: 1px solid rgba(200,200,200,.1);
		/*margin: 0 .5rem;*/
	}
	header .headerTitle{
		/*float: left;*/
		margin-left: .5rem;
	}
	header .submit{
		display: inline-block;
		width: 3rem;
		height: 1.5rem;
		line-height: 1.5rem;
		border: 1px solid #ccc;
		float: right;
		margin: .25rem 1rem;
		text-align: center;
		border-radius: 3px;
		cursor: pointer;
	}
	figure{
		width: 100%;
		max-height: 15rem;
		min-height: 5rem;
		position: relative;
		background-color: #ccc;
		overflow: auto;
	}
	figure .addCover{
		height: 3rem;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		cursor: pointer;
	}
	figure img{
		width: 100%;
		display: none;
	}
	figure .addCover span{
		display: inline-block;
		height: 1.5rem;
		width: 100%;
		text-align: center;
	}
	figure .addCover span:nth-child(1){
		transform: scale(2);
	}
	.title{
		margin: .3rem 0;
    	padding: .2rem 0;
		font-weight: bold;
		border-bottom: 1px solid rgba(200,200,200,.5);
	}
	.title input{
		width: 100%;
		font-size: 1.2rem;
    	font-weight: bold;
	}
	.content{
		min-height: 20rem;
		margin-bottom: 2.1rem;
		background-color: #fff;
	}
	.content img{
		width: 100%;
	}
	.content .imgcontent{
		display: none;
	}
	.content .desc{
		display: none;
	}
	footer{
		width: 100%;
		position: fixed;
		bottom: 0;
		height: 2rem;
		line-height: 2rem;
		z-index: 1;
		background-color: #fff;
		border-top: 1px solid #eee;
	}
	.left img{
		height: 1rem;
	}
	.ql-editor{
		min-height: 5rem;
	}
	input[type='file']{
		display: none;
	}
</style>