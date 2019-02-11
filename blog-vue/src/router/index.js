import Vue from 'vue'
import Router from 'vue-router'
// import HelloWorld from '@/components/HelloWorld'
// import Index from '@/components/index'
const Index = () => import('@/components/index');
// import IndexList from '@/components/indexList'
const IndexList = () => import('@/components/indexList');
// import Articles from '@/components/article'
const Articles = () => import('@/components/article');
// import Submit from '@/components/submit'
const Submit = () => import('@/components/submit');
// import Category from '@/components/category'
const Category = () => import('@/components/category');
// import CategoryFile from '@/components/category/file'
const CategoryFile = () => import('@/components/category/file');
// import CategoryMusic from '@/components/category/music'
const CategoryMusic = () => import('@/components/category/music');
// import CategoryShare from '@/components/category/share'
const CategoryShare = () => import('@/components/category/share');
// import CategoryText from '@/components/category/text'
const CategoryText = () => import('@/components/category/text');
// import CategoryVideo from '@/components/category/video'
const CategoryVideo = () => import('@/components/category/video');
const Me = () => import('@/components/me');
// import Me from '@/components/me'
const FriendLink = () => import('@/components/friendlink');
// 留言板
const GuestBook = () => import('@/components/guestbook');
// 
const Test = () => import('@/components/test');

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '*',
      component: Index,
    },
    {
      path: '/',
      name: 'index',
      component: Index,
      redirect: '/index',
      children:[
        {
          path: '/index',
          name: 'indexList',
          component: IndexList
        },
        {
          path: '/me',
          name: 'me',
          component: Me,
        },
      ]
    },
    {
      path: '/test',
      name: 'test',
      component: Test,
    },
    {
      path: '/article/:id',
      name: 'articles',
      component: Articles,
    },
    {
      path: '/submit',
      name: 'submit',
      component: Submit,
    },
    {
      path: '/category',
      name: 'category',
      component: Category,
      redirect: '/category/text',
      children:[
        {
          path: '/category/file',
          name: 'categoryFile',
          component: CategoryFile,
        },{
          path: '/category/music',
          name: 'categoryMusic',
          component: CategoryMusic,
        },{
          path: '/category/share',
          name: 'categoryShare',
          component: CategoryShare,
        },{
          path: '/category/text',
          name: 'categoryText',
          component: CategoryText,
        },{
          path: '/category/video',
          name: 'categoryVideo',
          component: CategoryVideo,
        },
      ]
    },
    {
      path: '/links',
      name: 'friendLink',
      component: FriendLink,
    },
    {
      path: '/guestbook',
      name: 'guestBook',
      component: GuestBook,
    }
  ]
})
