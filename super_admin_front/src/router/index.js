import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

/* Layout */
import Layout from '@/layout'

/**
 * Note: sub-menu only appear when route children.length >= 1
 * Detail see: https://panjiachen.github.io/vue-element-admin-site/guide/essentials/router-and-nav.html
 *
 * hidden: true                   if set true, item will not show in the sidebar(default is false)
 * alwaysShow: true               if set true, will always show the root menu
 *                                if not set alwaysShow, when item has more than one children route,
 *                                it will becomes nested mode, otherwise not show the root menu
 * redirect: noRedirect           if set noRedirect will no redirect in the breadcrumb
 * name:'router-name'             the name is used by <keep-alive> (must set!!!)
 * meta : {
    roles: ['admin','editor']    control the page roles (you can set multiple roles)
    title: 'title'               the name show in sidebar and breadcrumb (recommend set)
    icon: 'svg-name'/'el-icon-x' the icon show in the sidebar
    breadcrumb: false            if set false, the item will hidden in breadcrumb(default is true)
    activeMenu: '/example/list'  if set path, the sidebar will highlight the path you set
  }
 */

/**
 * constantRoutes
 * a base page that does not have permission requirements
 * all roles can be accessed
 */
export const constantRoutes = [
  {
    path: '/login',
    component: () => import('@/views/login/index'),
    hidden: true
  },
  {
    path: '/404',
    component: () => import('@/views/404'),
    hidden: true
  },

  {
    path: '/',
    component: Layout,
    redirect: '/dashboard',
    children: [{
      path: 'dashboard',
      name: 'Dashboard',
      component: () => import('@/views/dashboard/index'),
      meta: { title: 'Dashboard', icon: 'dashboard' }
    }]
  },

  {
    path: '/store',
    component: Layout,
    children: [
      {
        path: 'store',
        name: '商家管理',
        component: () => import('@/views/store/index'),
        meta: { title: '商家管理', icon: 'el-icon-shopping-cart-2' }
      },
      {
        path: 'update',
        name: 'updateStore',
        component: () => import('@/views/store/edit'),
        meta: { title: '编辑商家', icon: 'el-icon-shopping-cart-2' },
        hidden: true
      },
    ]
  },

  {
    path: '/job',
    component: Layout,
    iconCls: 'el-icon-cpu',
    meta: { title: '职位', icon: 'el-icon-potato-strips' },
    children: [
      {
        path: 'index',
        name: '职位管理',
        component: () => import('@/views/job/index'),
        meta: { title: '职位管理', icon: 'el-icon-cpu' }
      },
      {
        path: 'cat',
        name: 'catList',
        component: () => import('@/views/job/cat'),
        meta: { title: '职位分类', icon: 'el-icon-cpu' }
      },
      {
        path: 'catEdit',
        name: 'catEdit',
        component: () => import('@/views/job/cat_add'),
        meta: { title: '新增', icon: 'el-icon-cpu' },
        hidden: true
      }
    ]
  },


  {
    path: '/user',
    component: Layout,
    children: [
      {
        path: 'index',
        name: '用户数据',
        component: () => import('@/views/user/index'),
        meta: { title: '用户数据', icon: 'el-icon-user' }
      },
      {
        path: 'promotionPage',
        name: 'promotionPage',
        component: () => import('@/views/user/promotion'),
        meta: { title: '推广数据', icon: 'el-icon-user' },
        hidden: true
      }
    ]
  },


  {
    path: '/data',
    component: Layout,
    children: [
      {
        path: 'index',
        name: '小程序数据',
        component: () => import('@/views/data/index'),
        meta: { title: '小程序数据', icon: 'el-icon-s-data' }
      }
    ]
  },

  {
    path: '/feedback',
    component: Layout,
    children: [
      {
        path: 'index',
        name: '意见反馈',
        component: () => import('@/views/feedback/index'),
        meta: { title: '意见反馈', icon: 'el-icon-phone-outline' }
      }
    ]
  },
  {
    path: '/city',
    component: Layout,
    children: [
      {
        path: 'index',
        name: '城市管理',
        component: () => import('@/views/city/index'),
        meta: { title: '城市管理', icon: 'el-icon-s-flag' }
      }
    ]
  },
  // {
  //   path: 'external-link',
  //   component: Layout,
  //   children: [
  //     {
  //       path: 'https://panjiachen.github.io/vue-element-admin-site/#/',
  //       meta: { title: 'External Link', icon: 'link' }
  //     }
  //   ]
  // },

  // 404 page must be placed at the end !!!
  { path: '*', redirect: '/404', hidden: true }
]

const createRouter = () => new Router({
  // mode: 'history', // require service support
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRoutes
})

const router = createRouter()

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
  const newRouter = createRouter()
  router.matcher = newRouter.matcher // reset router
}

export default router
