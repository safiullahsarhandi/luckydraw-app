import DashboardLayout from '../layout/DashboardLayout.vue'
import FullPage from '@/layout/FullPage.vue';
// GeneralViews
import NotFound from '../pages/NotFoundPage.vue'

// Admin pages
import Overview from '@/pages/Overview.vue';
import Wheel from '@/pages/Wheel.vue';
import Members from '@/pages/Members.vue';
import TableList from '@/pages/TableList.vue';
import Typography from '@/pages/Typography.vue';
import Icons from '@/pages/Icons.vue';
import Maps from '@/pages/Maps.vue';
import Login from '@/pages/Auth/Login.vue';

const routes = [
  {
    path: '/',
    component: FullPage,
    children : [{
      path : '/',
      name : 'login',
      component : Login,

    }],
  },
  {
    path: '/',
    component: DashboardLayout,
    children: [
      {
        path: '/home',
        name: 'Home',
        component: Overview
      },
      {
        path: 'fortune-wheel',
        name: 'FortuneWheel',
        component: Wheel
      },
      {
        path: 'members',
        name: 'Members',
        component: Members
      },
    ]
  },
  { path: '*', component: NotFound }
]

/**
 * Asynchronously load view (Webpack Lazy loading compatible)
 * The specified component must be inside the Views folder
 * @param  {string} name  the filename (basename) of the view to load.
function view(name) {
   var res= require('../components/Dashboard/Views/' + name + '.vue');
   return res;
};**/

export default routes
