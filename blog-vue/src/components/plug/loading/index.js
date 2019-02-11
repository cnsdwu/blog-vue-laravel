import LoadComponent from './loading.vue'

const Load = {};

// 注册Toast
Load.install = function (Vue) {
    // 生成一个Vue的子类
    // 同时这个子类也就是组件
    const LoadConstructor = Vue.extend(LoadComponent)
    // 生成一个该子类的实例
    const instance = new LoadConstructor();

    // 将这个实例挂载在我创建的div上
    // 并将此div加入全局挂载点内部
    instance.$mount(document.createElement('div'))
    document.body.appendChild(instance.$el)

    // 通过Vue的原型注册一个方法
    // 让所有实例共享这个方法 
    Vue.prototype.$loading = (bool=false,opacity=1) => {
        instance.show = bool;
        instance.background = `background: rgba(255,255,255, ${opacity})`;
                // instance.show = true;
        // setTimeout(() => {
        //     instance.show = false;
        // }, duration);
    }
}

export default Load