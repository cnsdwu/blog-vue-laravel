<template>
        <div class="mask" v-if="show" @click.stop="">
    <transition name="fade">
            <div class="container" v-show="showBody">
                <header>用户登录</header>
                <form @submit.prevent="submit">
                    <div>
                        <!-- <span>呢称</span> -->
                        <input type="text" placeholder="用户名或邮箱" ref="account" v-model="account" @keyup="keyFilter" autofocus autocomplete required>
                    </div>
                    <div>
                        <!-- <span>邮箱</span> -->
                        <input type="password" placeholder="密码" v-model="password" ref="password"  required>
                    </div>
                    <div v-if="showCode">
                        <input type="text" :placeholder="codetips" v-model="vcode" ref="vcode" required>
                    </div>
                    <div class="submit">
                        <span @click="clickSubmit">确定</span>
                        <button ref="form"></button>
                        <span @click="cencel">取消</span>
                    </div>
                </form>
            </div>
    </transition>
        </div>
</template>

<script>
    export default {
        data() {
            return {
                show: false,
                showBody: false,
                account: '',
                password: '',
                showCode: false,
                vcode: '',
                codetips: '验证码',
            };
        },
        methods:{
            clickSubmit(){
                this.$refs.form.click();
            },
            submit(){
                // console.log(this.email)
                if(this.account == '' || this.password == ''){
                    return false;
                }
                this.$loading({background: 'rgba(0, 0, 0, 0)'});
                this.$axios.post('/login', {
                        account: this.account,
                        password: this.password,
                        vcode: this.vcode,
                })
                .then((rep)=>{
                    this.$loading().close();
                    this.$toast(rep.data.message);
                    if(rep.data.status == 0){
                        this.$setStorage('token',rep.data.ps);
                        // this.$setStorage('nickname',this.nickname);
                        this.$login(false);
                        // this.$toast('登录成功');
                        // this.$router.reload();
                        window.location.reload();
                    }else if(rep.data.status == 4){
                        this.codetips = '成语：“'+JSON.parse(rep.data.ps).join('“ ”')+'”';
                        this.vcode = '';
                        this.showCode = true;
                        this.$refs.vcode.focus();
                    }else{
                        if(this.showCode){
                            this.codetips = '成语：“'+JSON.parse(rep.data.ps).join('“ ”')+'”';
                            this.vcode = '';
                        }
                        this.password = '';
                        this.$refs.password.focus();
                    }
                    
                })
                .catch((error) => {
                    this.$loading().close();
                    // this.$toast("网络异常");
                });
            },
            cencel(){
                this.$login(false);
                // this.$emit('cencel');
                // setTimeout(()=>{
                //  this.show2 = false;
                // })
            },
            keyFilter(event){
              this.account = this.account.replace(/[^\d\w-_@.]/ig, "");
            }
        }
    };
</script>

<style scoped>
    .mask{
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 10;
        background: rgba(200,200,200,.3);
    }
    .container{
        width: 60vw;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translateY(-50%);
        margin-left: -30vw;
        /*margin-top: -30vw;*/
        border: 1px solid #fff;
        overflow: hidden;
        border-radius: 3vw;
        /*box-shadow: 0 0 1px 0;*/
        /*padding: .5rem;*/
        background: #fff;
    }
    header{
        text-align: center;
        height: 2rem;
        line-height: 2rem;
        font-size: 1.3rem;
        font-weight: bold;
        margin: .5rem 0;
    }
    input{
        width: 99%;
        border: 0;
        outline: none;
        box-sizing: border-box;
        /*box-shadow: 0 0 0px 1px #eee;*/
        font-size: .9rem;
        background: rgba(240, 240, 240, .2);;
        margin: .1rem;
        height: 2rem;
        padding: 0 .5rem;
    }
    .submit{
        text-align: center;
        border-top: 1px solid #eee;
        margin-top: .5rem;
        display: flex;
    }
    /*.submit button{
        width: 3rem;
        height: 2rem;
        line-height: 2rem;
        background: #fff;
        border: 1px solid #eee;
        outline: none;
    }
    .submit button:active{
        color: green;
        border: 1px solid green;
    }*/
    .submit span{
        display: inline-block;
        flex: 1;
        text-align: center;
        padding: .7rem 0;
        font-size: 1.2rem;
        line-height: 1.2rem;
        font-weight: bold;
        color: #49a6de;
        cursor: pointer;
    }
    .submit span:hover{
        background: #eee;
    }
    .submit span:nth-child(1){
        border-right: 1px solid #eee;
    }
    .container form div{
        overflow: hidden;
    }
    .fade-enter-active{
        animation: animations-in .5s ease-out;
    }
    .fade-leave-active {
        animation: animations-out .3s ease-out;
    }
    @keyframes animations-in{
        0%{
            opacity: 0;
            transform: scale(1.2) translateY(-50%);
        }
        100%{
            opacity: 1;
            transform: scale(1) translateY(-50%);
        }
    }
    @keyframes animations-out{
        0%{
            opacity: 1;
            transform: scale(1) translateY(-50%);
        }
        100%{
            opacity: 0;
            transform: scale(1.2) translateY(-50%);
        }
    }
</style>