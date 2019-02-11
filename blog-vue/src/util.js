export default{
  install(Vue,options)
  {
    //加载动画
    Vue.prototype.loading = function (bool, opacity=false) {
    	const loading = document.getElementById('Loading').parentNode;
    	if(bool){
    		if(opacity){
    			loading.style.background = 'rgba(255,255,255,0)';
    		}else{
    			loading.style.background = 'rgba(255,255,255,1)';
    		}
      		loading.style.display = 'block';
    	}else{
    		loading.style.display = 'none';
    	}
    }
    // 操作localstorage
    Vue.prototype.$getStorage = function(name){
      return JSON.parse(localStorage.getItem(name));
    }
    Vue.prototype.$setStorage = function (name, val) {
        localStorage.setItem(name, JSON.stringify(val))
    }
    Vue.prototype.$addStorage = function (name, addVal) {
        let oldVal = Storage.get(name)
        let newVal = oldVal.concat(addVal)
        Storage.set(name, newVal)
    }
    Vue.prototype.$delStorage = function (name) {
        localStorage.removeItem(name);
    }
    // 设置网页标题
    Vue.prototype.$setTitle  = function(title){
        document.title = title + ' - 五味杂陈';
    }
    // Vue.prototype.$showMessage = function(bool,text="提示"){
    //     const message = document.querySelector('#cnsdwuMessage');
    //     if(bool){
    //         message.style.display = 'block';
    //         document.querySelector('#cnsdwuMessage #textMessage').innerText = text;
    //     }else{
    //         message.style.display = 'none';
    //     }
    // }
    // Vue.prototype.showMessage = true;
    // Vue.prototype.textMessage = "提示信息";
    // Vue.prototype.loading = true;
  }
}