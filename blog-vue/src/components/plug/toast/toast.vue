<template>
    <transition name="fade">
        <div class="toast" v-show="show">
            {{message}}
        </div>

    </transition>
</template>

<script>
export default {
  data() {
    return {
      show: false,
      message: "",
      timeOut: null,
    };
  }
};
</script>

<style scoped>
.toast {
  position: fixed;
  top: 80%;
  left: 50%;
  margin-left: -15vw;
  padding: 2vw;
  width: 30vw;
  font-size: 4vw;
  color: #fff;
  text-align: center;
  z-index: 999;
  background: rgba(230, 0, 0, 0.5); 
  border-radius: .2rem; 
  color: rgb(255, 255, 255); 
}

.fade-enter-active{
  animation: animations-in 3s ease-out;
}
.fade-leave-active {
  animation: animations-out .5s ease-out;
}
/*.fade-enter {
  opacity: 0;
  transform: scale(1.2);
}
.fade-leave-to {
  opacity: 0;
  transform: scale(0.8);
}*/
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