import Vue from 'vue'
import Router from 'vue-router'
import { normalizeURL, decode } from 'ufo'
import { interopDefault } from './utils'// eslint-disable-line no-unused-vars
import scrollBehavior from './router.scrollBehavior.js'

const _573cce92 = () => interopDefault(import('../pages/manage.vue' /* webpackChunkName: "pages/manage" */))
const _7482633e = () => interopDefault(import('../pages/new.vue' /* webpackChunkName: "pages/new" */))
const _e0696020 = () => interopDefault(import('../pages/index.vue' /* webpackChunkName: "pages/index" */))

const emptyFn = () => {}

Vue.use(Router)

export const routerOptions = {
  mode: 'history',
  base: '/',
  linkActiveClass: 'nuxt-link-active',
  linkExactActiveClass: 'nuxt-link-exact-active',
  scrollBehavior,
  /* eslint-disable array-bracket-spacing, quotes, quote-props, object-curly-spacing, key-spacing */
  routes: [{
    path: "/manage",
    component: _573cce92,
    name: "manage"
  }, {
    path: "/new",
    component: _7482633e,
    name: "new"
  }, {
    path: "/",
    component: _e0696020,
    name: "index"
  }],
  /* eslint-enable array-bracket-spacing, quotes, quote-props, object-curly-spacing, key-spacing */

  fallback: false
}

export function createRouter (ssrContext, config) {
  const base = (config._app && config._app.basePath) || routerOptions.base
  const router = new Router({ ...routerOptions, base  })

  // TODO: remove in Nuxt 3
  const originalPush = router.push
  router.push = function push (location, onComplete = emptyFn, onAbort) {
    return originalPush.call(this, location, onComplete, onAbort)
  }

  const resolve = router.resolve.bind(router)
  router.resolve = (to, current, append) => {
    if (typeof to === 'string') {
      to = normalizeURL(to)
    }
    return resolve(to, current, append)
  }

  return router
}
