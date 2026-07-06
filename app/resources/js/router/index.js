import { createRouter, createWebHistory } from 'vue-router';
import Login from '../Login.vue';
import Accounting from '../Accounting.vue';
import JournalEntry from '../JournalEntry.vue';
import GeneralLedger from '../GenLedger.vue';

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

// router.beforeEach(async (to, from, next) => {
//   document.title = to.meta.title || "Laura-Belle";

//   try {
//     const response = await fetch("/api/user", {
//       credentials: "same-origin",
//       headers: {
//         Accept: "application/json"
//       }
//     });

//     const authenticated = response.ok;

//     // Protected pages
//     if (to.meta.requiresAuth && !authenticated) {
//       return next("/");
//     }

//     // Already logged in
//     if (to.meta.guestOnly && authenticated) {
//       return next("/ChartOfAccounts");
//     }

//     next();

//   } catch (error) {

//     if (to.meta.requiresAuth) {
//       return next("/");
//     }

//     next();
//   }
// });

export default router;
