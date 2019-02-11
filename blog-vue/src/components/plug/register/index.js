import RegisterComponent from './register.vue'

const Register = {};

// 注册Toast
Register.install = function (Vue) {
    // 生成一个Vue的子类
    // 同时这个子类也就是组件
    const RegisterConstructor = Vue.extend(RegisterComponent)
    // 生成一个该子类的实例
    const instance = new RegisterConstructor();

    // 将这个实例挂载在我创建的div上
    // 并将此div加入全局挂载点内部
    instance.$mount(document.createElement('div'))
    document.body.appendChild(instance.$el)

    // 通过Vue的原型注册一个方法
    // 让所有实例共享这个方法 
    Vue.prototype.$register = (bool=false) => {
        // instance.message = msg;
        if(bool){
            instance.show = true;
            setTimeout(() => {
                instance.showBody = true;
            })
        }else{
            instance.showBody = false;
            setTimeout(() => {
                instance.show = false;
            },300)
        }
        // setTimeout(() => {
        //     instance.show = false;
        // }, duration);
    }
}

export default Register