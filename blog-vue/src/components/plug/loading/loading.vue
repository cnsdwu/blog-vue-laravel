<template>
    <!-- <transition name="fade"> -->
        <div class="container" @click.prevent.self="" v-show="show" ref="mask" :style="background">
          <div class="loading">
              <div class="loader-inner ball-beat">
                <div></div>
                <div></div>
                <div></div>
              </div>
            </div>
        </div>
    <!-- </transition> -->
</template>

<script>
export default {
  data() {
    return {
      show: false,
      background: 'background: rgba(255,255,255,1)',
    };
  },
  created(){
    // this.opacity = 'opacity:'
    // console.log(this.$refs.style.background= "blue")
    // this.$refs.style.opacity = this.opacity;
  }
};
</script>

<style scoped>
  .container{
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: #fff;
    z-index: 2;
    /*display: none;*/
    user-select: none;
  }
  .loading {
    top:50%;
    left:50%;
    opacity: 1;
    position: fixed;
    transform: translateY(-50%)  translateX(-50%);
    z-index:100;
  }
  .ball-beat > div {
      background-color: #279fcf;
      width: 15px;
      height: 15px;
      border-radius: 100% !important;
      margin: 2px;
      animation-fill-mode: both;
      display: inline-block;
      animation: ball-beat 0.7s 0s infinite linear; 
  }
  .ball-beat > div:nth-child(2n-1) {
      animation-delay: 0.35s !important; 
  }
  @keyframes ball-beat {
      50% {
        opacity: 0.2;
        -webkit-transform: scale(0.75);
        transform: scale(0.75); 
      }

      100% {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1); 
      }
  }
  .fade-enter-active{
    animation: animations-in 3s ease-out;
  }
  .fade-leave-active {
    animation: animations-out .5s ease-out;
  }
  @keyframes animations-in{
    0%{
      opacity: 0;
      transform: scale(0);
    }
    8%{
      opacity: 1;
      transform: scale(1);
    }
    12%,18%{
      opacity: 1;
      transform: scale(1.2);
    }
    16%,20%{
      opacity: 1;
      transform: scale(1);
    }
    100%{
      opacity: 1;
      transform: scale(1);
    }
  }
  @keyframes animations-out{
    0%{
      opacity: 1;
      transform: scale(1);
    }
    25%,75%{
      opacity: 1;
      transform: scale(1.1);
    }
    50%{
      opacity: 1;
      transform: scale(1);
    }
    100%{
      opacity: 0;
      transform: scale(0);
    }
  }

</style>