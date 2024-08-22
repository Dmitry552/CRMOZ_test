import {
    createRouter,
    createWebHistory,
    NavigationGuardNext,
    RouteLocationNormalized,
} from 'vue-router'
import Home from '../pages/Home.vue'
import SignIn from "../pages/SignIn.vue";
import {store} from "../store";
import {setToken} from "../store/modules/user/mutations";

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            name: 'form',
            component: Home,
            beforeEnter: [checkLackOfUser]
        },
        {
            path: '/login',
            name: 'login',
            component: SignIn,
            beforeEnter: [checkUserPresence]
        },
        {
            path: '/:catchAll(.*)',
            redirect: '/',
        }
    ]
})

async function checkLackOfUser(
    to: RouteLocationNormalized,
    from: RouteLocationNormalized,
    next: NavigationGuardNext
) {
    if (store.getters.getUser) {
        return next();
    }

    if (window.token) {
        localStorage.setItem('token', window.token);
        await store.dispatch('getUser').catch(() => {
            swal({
                text: "Unauthorized!",
                icon: "warning",
            })
        });
        setToken(localStorage.getItem('token'));
        return next();
    }

    return next({name: 'login'});
}

function checkUserPresence(
    to: RouteLocationNormalized,
    from: RouteLocationNormalized,
    next: NavigationGuardNext
) {
    if (store.getters.getUser) {
        return next({name: 'form'});
    }

    next();
}


router.beforeEach(async (): Promise<void> => {
    if (localStorage.getItem('token') && !store.getters.getUser) {
        await store.dispatch('getUser').catch(() => {
            swal({
                text: "Unauthorized!",
                icon: "warning",
            })
        });
    }
});

export default router
