<template>
	<div class="wrap">
		<div class="edit">
			<ul>
				<li @mouseenter="enterH" @mouseleave="leaveH">
					<div>H</div>
					<ul v-show="showH" class="select">
						<li @click.stop="clickH1" @mouseenter="enterH1"><h1>H1标题</h1></li>
						<li><h2>H2标题</h2></li>
						<li><h3>H3标题</h3></li>
					</ul>
				</li>
				<li><strong>B</strong></li>
				<li><i>I</i></li>
				<li><u>U</u></li>
				<li><s>S</s></li>
			</ul>
		</div>
		<div contenteditable="editable" @input="input" @click.stop="" ref="text" @touchstart="touchstart"></div>
		<div id="default" class="default" :class="textAlign" v-show="showTips">{{defaults}}</div>
		<div class="dialog">
			
		</div>
	</div>
	

</template>
<script>
	export default{
		name: 'inputDiv',
		data(){
			return{
				showTips: true,
				showH: false,
				cursor: 0,
			}
		},
		props: {
			defaults:{
				type: String,
				default: '请输入一些内容'
			},
			textAlign:{
				default: 'left',
			}
		},
		methods:{
			input(event){
				// event.srcElement.parentNode.lastChild.style.display = 'none';
				// this.$refs.tips.style.display = 'none';
				this.showTips = false;
				if(this.$refs.text.innerText == ''){
					this.showTips = true;
				}
			},
			touchstart(event){
				console.log(event)
				setTimeout(() => {

				}, 2000);
			},
			enterH(){
				this.showH = true;
			},
			leaveH(){
				this.showH = false;
			},
			enterH1(){
				
				// 获取文档中选中区域
				var range = window.getSelection().getRangeAt(0)
				var strongNode = document.createElement('strong')
				// 选中区域文本
				strongNode.innerHTML = range.toString()
				// 删除选中区
				range.deleteContents()
				// 在光标处插入新节点
				range.insertNode(strongNode)
				// let h1 = document.createElement('h1');

				// let sel = null;
				// if(window.getSelection){
				// 	sel = window.getSelection();
				// 	if(sel.getRangeAt && sel.rangeCount){
				// 		const range = sel.getRangeAt(0);
				// 		h1.appendChild(range.endContainer);
				// 		range.endContainer.html = h1;
				// 		console.log(range.endContainer)
				// 	}
				// }
				// console.log(h1)
				// this.insertAtCursor(this.$refs.text, '2')
			},
			clickH1(){
				// console.log(this.getCursortPosition(this.$refs.text))
				// this.insertAtCursor(this.$refs.text, '2')
				// this.getPos();
				console.log(this.cursor)
			},
			insertAtCursor(dom, html) {
				if (dom != document.activeElement) { // 如果dom没有获取到焦点，追加
					dom.innerHTML = dom.innerHTML + html;
					return;
				}
				var sel, range;
				// IE9 或 非IE浏览器
				if (window.getSelection) {
					sel = window.getSelection();
					if (sel.getRangeAt && sel.rangeCount) {
						range = sel.getRangeAt(0);
						range.deleteContents();
						var el = document.createElement("div");
						el.innerHTML = html;
						var frag = document.createDocumentFragment(),
							node, lastNode;
						while ((node = el.firstChild)) {
							lastNode = frag.appendChild(node);
						}
						// console.log(range)
						range.insertNode(frag);
						// Preserve the selection
						if (lastNode) {
							range = range.cloneRange();
							range.setStartAfter(lastNode);
							range.collapse(true);
							sel.removeAllRanges();
							sel.addRange(range);
						}
					}
				} else if (document.selection && document.selection.type != "Control") {
					// IE < 9
					document.selection.createRange().pasteHTML(html);
				}
			}
		}
	}
</script>
<style scoped>
	.wrap{
		position: relative;
		min-height: 3rem;
		padding-top: 2rem;
	}
	.wrap div:nth-child(2){
/*		margin: .3rem 0;
		padding: .2rem 0;*/
		/*font-weight: bold;*/
		outline: none;
		min-height: 1rem;
		/*border-bottom: 1px solid rgba(200,200,200,.5);*/
	}
	.wrap .default{
		opacity: .7;
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		pointer-events: none;
	}
	.left{
		text-align: left;
	}
	.right{
		text-align: right;
	}
	.center{
		text-align: center;
		left: 50%;
		transform: translate(-50%,-50%) !important;
	}
	.edit{
		/*background: #fff;*/
		width: 100%;
		height: 1.5rem;
		line-height: 1.5rem;
		position: absolute;
		top: 0;
		/*display: flex;*/

	}
	.edit>ul{
		width: 100%;
		display: flex;
	}
	.edit>ul>li{
		display: inline-block;
		line-height: 1.5rem;
		flex: 1;
		text-align: center;
		border-right: 1px solid #eee;
		cursor: pointer;
		position: relative;
	}
	.edit li:hover{
		background: #eee;
	}
	.edit .select{
		width: 150%;
		position: absolute;
		top: 1.5rem;
		background: #fff;
		z-index: 1;
		border: 1px solid #eee;
	}
	.edit .select h1{
		font-size: 2rem;
		font-weight: bold;
	}
</style>