import { createRouter, createWebHistory } from 'vue-router';
import Login from '../vue/Login.vue';
import Accounting from '../vue/Accounting.vue';
import JournalEntry from '../vue/JournalEntry.vue';
import GeneralLedger from '../vue/GenLedger.vue';
import Register from '../vue/Register.vue';

const routes = [
  {
    path: '/',
    name: 'Login',
    component: Login,
    meta: { title: 'Laura-Belle',
            guestOnly: true
    }
  },
  {
    path: '/ChartOfAccounts',
    name: 'Accounting',
    component: Accounting,
    meta: { title: 'Chart of Accounts',
            requiresAuth: true
     }
  },
  {
    path: '/JournalEntry',
    name: 'JournalEntry',
    component: JournalEntry,
    meta: { title: 'Journal Entry',
            requiresAuth: true
     }
  },
  {
    path: '/GeneralLedger',
    name: 'GeneralLedger',
    component: GeneralLedger,
    meta: { title: 'General Ledger',
            requiresAuth: true

    }
  },
   {
    path: '/',
    name: 'Register',
    component: Register,
    meta: { title: 'Register',
            guestOnly: true
    }
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Update document title on route change
router.beforeEach((to, from, next) => {
  document.title = to.meta.title || 'Laura-Belle';
  next();
});

export default router;
