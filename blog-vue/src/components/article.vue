<template>
	<div id="container" class="container">
		<!-- <component is="Message" :show="showMessage" :text="textMessage" @buttonSure="MessageSure" :image="messageType"/></component> -->
		<!-- <component is="Dialog" :show="showDialog" showCencel="true" @cencel="DialogCencel"/></component> -->
		<!-- {{$route.params.id}} -->
		<!-- <header>
			<span class="back">←</span>
			<span class="menu"></span>
		</header> -->
		<header class="header">
			<div @click="goBack"><img src="@/assets/back.png"></div>
			<div>{{article.title}}</div>
		</header>
		<figure v-if="article.cover">
			<img :src="article.cover">
		</figure>
		<section id="article" class="article">
			<!-- <transition name="fade"> -->
			<h1>{{article.title}}</h1>
			<!-- </transition> -->
			<div class="author">
				<div>
					<img class="head" :src="article.head">
				</div>
				<div class="nickname">
					{{article.author}}
				</div>
				<div class="time">
					<span>{{article.time}}</span>
					<span>文章</span>
				</div>
			</div>
			<div class="ql-snow">
				<article v-lazy-container="{selector:'img'}" v-html="article.content" class="ql-editor"></article>
			</div>
			<div class="footer">
				<span><s class="admire"></s>{{article.admire}}</span>
				<span><s class="commentnum"></s>{{article.commentNum}}</span>
			</div>
		</section>
		<component is="Comment" v-if="commentRest" :articleId="this.$route.params.id" /></component>
		<div class="comment">
			<!-- <textarea></textarea> -->
			<div v-show="!commentShow" class="showTextarea" @click.stop="commentClick">
				<p class="default">评论</p>
			</div>
			<div v-show="commentShow" class="textarea" @focusout="focusOut" @click.stop="">
				<!-- <div id="textarea" contenteditable="true" class="textareaFocus" ref="textarea"></div>
				<div class="imgcontent">
					<div class="insertimg" ref="imgcontent" contenteditable="false">
						<img src="">
						<div class="desc"></div>
					</div>
					<br ref="br">
				</div> -->
				<input type="file" ref="imgupload" @change="selectImage">
				<quillEditor
	        	    v-model="content"
	        	    ref="myQuillEditor"
	        	    :options="editorOption"
	        	    @change="onEditorChange($event)"
	        	    @ready="onEditorReady($event)"
	        	>
	        	</quillEditor>
				<div class="textareaPlug" >
					<ul>
						<!-- <li>表情</li> -->
						<!-- <li @click="addImage">
							<img src="@/assets/image.png">
						</li> -->
						<!-- <li>@</li> -->
					</ul>
					<span @click="subComment">
						<img src="@/assets/send.png">
					</span>
				</div>
			</div>
		</div>
	</div>
</template>
<script type="text/javascript">
	import Vue from 'vue'
	// import Comment from '@/components/comment'
	// import ImageUpload from '@/components/imageupload'
	// import Dialog from '@/components/plug/dialog'
	// import Message from '@/components/plug/message'
	import { quillEditor } from 'vue-quill-editor'
	import 'quill/dist/quill.core.css'
	import 'quill/dist/quill.snow.css'
	Vue.component(
		'Comment',
		() => import('@/components/comment')
	);
	// Vue.component(
	// 	'Message',
	//   	() => import('@/components/plug/message')
	// );
	// Vue.component(
	// 	'Dialog',
	//   	// 这个 `import` 函数会返回一个 `Promise` 对象。
	//   	() => import('@/components/plug/dialog')
	// );
	export default{
		name: 'articles',
		data(){
			return{
				commentRest: false,
				order: '最新评论',
				orderShow: false,
				commentShow: false,
				article:{},
				messageType: 0,
				content: '',
				editorOption: {
		          	// theme: 'bubble',
		          	placeholder: "请输入评论内容",
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
				            // history: {
				            //   delay: 1000,
				            //   maxStack: 50,
				            //   userOnly: false
				            // },
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
			}
		},
		components:{
			// Comment,
			// ImageUpload,
			// Dialog,
			// Message,
			quillEditor,
		},
		methods:{
			commentClick(event){
				if(this.$getStorage('token') == null){
					this.$messageBox(true);
				}else{
					this.$messageBox(false);
				}
				this.commentShow = true;
				setTimeout(()=>{
					document.querySelector('.quill-editor .ql-editor').focus();
				})
			},
			focusOut(){
				// this.commentShow = false;
			},
			subComment(){
				this.$loading().close();
				this.$loading({background: 'rgba(0, 0, 0, 0)'});
				this.$axios.post('/comment/add', {
			      	id: this.$route.params.id,
			      	content: this.content,
			      	token: this.$getStorage('token'),
				})
				.then((data)=>{
					this.$loading().close();
					if(data.data.status == 0){
						this.content = '';
						this.commentShow = false;
						this.commentRest = false;
						const self = this;
						setTimeout(function(){
							self.commentRest = true;
						});
					}
					this.$toast(data.data.message,3000);
				})
				// console.log(this.$refs.textarea.innerHTML)
			},
			goBack(){
				this.$router.go(-1);
			},
			DialogCencel(){
				this.showDialog = false;
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
						                // loading动画消失
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
            },
			onEditorChange({ editor, html, text }) {
		        // console.log('editor change!', editor, html, text)
		        this.content = html
		    },
		    onEditorReady(){

		    },
		},
		created(){
			//处理底部评论界面关闭
			document.addEventListener('click',()=>{
				this.commentShow = false;
			});
			window.addEventListener('scroll',(event)=>{
				// console.log(document.querySelector('figure'))
				// console.log( document.html.scrollTop)
			});
			// 设置编辑区域最大高度
			setTimeout(()=>{
				document.querySelector('.quill-editor .ql-editor').style.maxHeight = '20rem';
			})
			// console.log(document.querySelector('.quill-editor .ql-editor'))
			this.$loading();
			this.$axios.get('/article', {
			    params: {
			      	id: this.$route.params.id,
			    }
			})
			.then((data)=>{
				// this.loading(true,true);
				if(data.data.status == 0){
					this.article = JSON.parse(data.data.ps);
					this.$setTitle(this.article.title);
					this.article.content = this.article.content.replace(/src=\"/g, 'data-src="');
					this.article.content = this.article.content.replace(/allowfullscreen=\"true\" data-src="/g, 'src="');
					// this.title = this.article.title
					// console.log(this.article.images)
					//设置正文中的图片格式
					setTimeout(()=>{
						const imgs = document.querySelectorAll('article .insertimg img');
						const descs = document.querySelectorAll('article .insertimg .desc');
						for(let i=0;i<this.article.images.length;i++){
							if(imgs[i]){
								imgs[i].style.maxWidth = '100%';
								imgs[i].style.border = '1px solid #ccc';
							}
							if(descs[i]){
								descs[i].style.opacity = '.6';
								descs[i].style.textAlign = 'center';
							}
							
							// document.querySelector(`article img[src=${this.article.images[i]}]`).style.width = '100%';
							// imgs[i].style.border = '1px solid #ccc';
							// descs[i].style.opacity = '.6';
							// descs[i].style.textAlign = 'center';
						}
						this.$loading().close()
						this.$loading({background: 'rgba(0, 0, 0, 0)'});
						this.commentRest = true;
						// this.loading(false);
					})
				}else if(data.data.status == 1){
					this.messageType = 1;
					this.textMessage = '抱歉，内容不存在！';
					this.showMessage = true;
					this.article = {
						title: '抱歉，内容不存在！',
						content: '您输入的地址有误或该内容已被删除！',
						head: require('@/assets/head.png'),
						author: '系统消息',
						admire: 0,
						commentNum: 0,
						id: 0,
						time: '刚刚',
					};
					this.$setTitle(this.article.title);
					this.$loading().close();
				}
				// this.$axios.get('http://blog.cn/api/comment/list',{
				// 	params:{
				// 		id: this.$route.params.id,
				// 	}
				// })
				// .then((data)=>{
				// 	if(data.data.status == 0){
				// 		this.comment = Json.parse(data.data.ps);
				// 	}
				// })
			});
		},
		mounted(){
			
		},
		destroyed(){
			// this.loading(false);
		}
	}
</script>
<style scoped>
	.container{
		background-color: #fff;
		
	}
/*	header{
		position: fixed;
		top: 0;
	}
	header .back{
		font-size: 2rem;
	}*/
	header{
		height: 3rem;
		width: 100%;
		background: rgba(244,244,244,.8);
		border-bottom: 1px solid #eee;
		position: fixed;
		top: 0;
		text-align: center;
		z-index: 1;
	}
	header div{
		height: 3rem;
		line-height: 3rem;
		font-size: 1.3rem;
		text-align: center;
		/*position: absolute;*/
		left: 1rem;
		/*color: blue;*/
		cursor: pointer;
		display: inline-block;
	}
	header div:nth-child(1){
		position: absolute;
		line-height: 4rem;
	}
	header div:nth-child(2){
		max-width: 80%;
    	overflow: auto;
	}
	header div img{
		height: 1.5rem;
	}
	header div:hover{
		/*background: #8ed5e6;*/
	}
	.article{
		padding: 0 1rem;
		margin-top: 3rem;
	}
	.container>figure{
		height: 8rem;
		overflow: hidden;
	}
	.container>figure img{
		width: 100%;
		transform: translateY(-38.2%);
		transition: .2s all 50ms;
	}
	.article h1{
		font-weight: bold;
		font-size: 1.5rem;
		animation: down .5s;
	}
	.article .author{
		height: 3rem;
		padding-left: 4rem;
		border-top: 1px solid #eee;
		border-bottom: 1px solid #eee;
		animation: opacity 1s;
	}
	.article .author .head{
		border-radius: 50%;
		height: 3rem;
		position: absolute;
		left: 1rem;
		animation: scale 1s;
	}
	.article .author .nickname{
		height: 1.5rem;
		line-height: 1.5rem;
		font-weight: bold;
	}
	.article .author .time{
		height: 1.5rem;
		line-height: 1.5rem;
		font-size: .5rem;
		opacity: .6;
	}
	.article .author .time span{
		font-size: .8rem;
	}
	.article .footer{
		text-align: right;
		margin-right: 5px;
		opacity: .7;
		animation: left .5s;
	}
	.article .footer span{
    	display: inline-block;
		transform: scale(.8);
	}
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
	.comment{
		position: fixed;
		bottom: 0;
		width: 100%;
		animation: up .5s;
	}
	.showTextarea{
		width: 100%;
		height: 2rem;
		line-height: 2rem;
		padding: .5rem .5rem;
		background-color: #fff;
		box-shadow: 0px -1px 10px -5px;
	}
	.textarea {
		width: 100%;
		min-height: 3rem;
		padding-top: .5rem;
		background-color: #fff;
	}
	.showTextarea p.default{
		display: inline-block;
		opacity: .6;
		color: green;
	}
	.textarea{
		/*box-shadow: 0px -1px 10px -5px;*/
	}
	.textarea .imgcontent{
		display: none;
	}
	.comment .textarea .textareaFocus{
		min-height: 2rem;
		max-height: 15rem;
		border: none;
		margin-bottom: .5rem;
		padding: 0 .5rem;
		overflow: auto;
		outline:none;
	}
	.comment .textarea .textareaFocus img{
		max-width: 100%;
	}
	.comment .textarea .textareaPlug{
		height: 1.5rem;
		width: 100%;
		line-height: 1rem;
		border-top: 1px solid #eee;
	}
	.comment .textarea .textareaPlug ul>li{
		float: left;
	}
	.comment .textarea .textareaPlug span{
		float: right;
		margin-right: .5rem;
		/*border: 1px solid #eee;*/
		cursor: pointer;
	}
	.comment .textarea .textareaPlug img{
		height: 1.5rem;
	}
	.comment .textarea .textareaPlug li img{
		height: 1.2rem;
	}
	.content img{
		max-width: 61.8%;
	}
	section article{
		word-wrap:break-word;
		overflow: hidden;
		animation: up .5s;
	}
	input[type='file']{
		display: none;
	}
	.quill-editor .ql-editor{
		max-height: 20rem;
	}
	.quill-editor[contenteditable="true"]{
		display: none;
	}


	@keyframes down{
	  0%{
	    opacity: 0;
	    transform: translateY(-3rem);
	  }
	  100%{
	    opacity: 1;
	    transform: translateY(0);
	  }
	}
	@keyframes up{
	  0%{
	    opacity: 0;
	    transform: translateY(3rem);
	  }
	  100%{
	    opacity: 1;
	    transform: translateY(0);
	  }
	}
	@keyframes left{
	  0%{
	    opacity: 0;
	    transform: translateX(3rem);
	  }
	  100%{
	    opacity: 1;
	    transform: translateY(0);
	  }
	}
	@keyframes rotate{
	  0%{
	    transform: rotate(0);
	  }
	  100%{
	    transform: rotate(360deg);
	  }
	}
	@keyframes opacity{
	  0%{
	    opacity: 0;
	    /*transform: scale(.5);*/
	  }
	  100%{
	    opacity: 1;
	    /*transform: scale(1);*/
	  }
	}
	@keyframes scale{
		0%{
			transform: scale(0);
		}
		100%{
			transform: scale(1);
		}
	}
</style>