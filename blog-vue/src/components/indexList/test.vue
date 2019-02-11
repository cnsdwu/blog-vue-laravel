<template>
	<div>
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
			<ImageUpload @addCover="addCover" @imagePath="coverPath" v-if="coverupload" />
			</figure>
			<!-- <div class="title" :contenteditable="editable" @input="inputTitle">
				<p class="default">标题</p>
			</div> -->
			<div class="title">
				<inputDiv defaults="标题" ref="title"/>
			</div>
			<div class="content" @click="clickContent">
				<inputDiv defaults="正文" ref="content"/>
				<div class="imgcontent">
					<div class="insertimg" ref="imgcontent" contenteditable="false">
						<img src="">
						<div class="desc"></div>
					</div>
					<br ref="br">
				</div>
			</div>
			<footer>
				<div class="left">
					<span>表情</span>
					<span @click="addImage">图片</span>
					<span>@</span>
					<ImageUpload @addCover="addImage" @imagePath="imagePath" v-if="imageupload" previewheight="auto" desc="true"/>
				</div>
				<div class="right">
					<span>设置</span>
				</div>
			</footer>
			
		</div>
	</div>
</template>
<script>
	import inputDiv from '@/components/plug/inputdiv'
	import ImageUpload from '@/components/imageupload'
	export default{
		name: 'submit',
		data(){
			return{
				editable: true,
				coverupload: false,
				imageupload: false,
				images: [],
				desc: [],
				cover: '',
			}
		},
		components:{
			inputDiv,
			ImageUpload,
		},
		methods:{
			// 正在输入标题时
			inputTitle(event){
				if(event.srcElement.innerText.length >= 50){
					// event.srcElement.contenteditable = "false";
					this.editable = false
				}
				// console.log(event)
				// if(event.srcElement.innerText.length >= 50 || event.inputType == 'insertParagraph'){
				// 	// return false;
				// 	// console.log(444)
				// 	event.returnValue = false;
				// 	// event.srcElement.innerText = event.srcElement.innerText.substr(0,event.srcElement.innerText.length - 2)
				// 	event.srcElement.innerText = event.srcElement.innerText.replace('\n','');
				// 	console.log(document.querySelector('.title').innerText.length)
				// }

				// console.log(document.querySelector('.title').innerText.length)
			},
			// 正文内容获得焦点
			clickContent(event){
				const el = event.srcElement.firstChild.firstChild;//正文可编辑元素
				if(el.innerText == ''){
					el.focus();
				}
			},
			// 显示隐藏封面图片上传
			addCover(){
				this.coverupload = !this.coverupload;
			},
			// 发布
			submit(){
				this.loading(true,true);
				// console.log(this.$refs.content.$refs.text.innerText)
				// return false;
				const title = this.$refs.title.$refs.text.innerText;//标题文本
				const content = this.$refs.content.$refs.text.innerHTML;//正文HTML
				this.$axios.get('http://blog.cn/api/article/add', {
				    params: {
				      	account: 'test',
				      	password: '123',
				      	type: 1,
				      	title: title,
				      	content: content,
				      	images: this.images,
				      	desc: this.desc,
				      	cover: this.cover,
				    }
				})
				.then((response)=>{
					this.loading(false);
					alert(response.data.message);
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
			// 显示隐藏正文图片上传
			addImage(){
				this.imageupload = !this.imageupload;
			},
			// 获得上传正文图片地址
			imagePath(data){
				// console.log(path);
				this.imageupload = !this.imageupload;
				this.$refs.imgcontent.firstChild.src = data.path;
				this.$refs.imgcontent.lastChild.innerText = data.desc;
				this.$refs.imgcontent.style.pointerEvents = 'none';
				this.$refs.imgcontent.style.userSelect = 'none';
				this.$refs.content.$refs.text.appendChild(this.$refs.imgcontent.cloneNode(true));
				this.$refs.content.$refs.text.appendChild(this.$refs.br.cloneNode(true));
				this.images.push(data.path);
				this.desc.push(data.desc);
				// this.desc.push(data.path);
				// this.$refs.images.appendChild(this.$refs.inputimg.cloneNode(true));
				// console.log(this.$refs.content.$refs.text)
				console.log(this.desc);
			}
		},
		mounted(){

			// console.log(document.querySelectorAll('input[name=img]'));
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
		float: left;
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
	}
	figure{
		width: 100%;
		height: 5rem;
		position: relative;
		background-color: #ccc;
		overflow: hidden;
	}
	figure .addCover{
		height: 3rem;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
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
		border-top: 1px solid rgba(200,200,200,.1);
	}
</style>