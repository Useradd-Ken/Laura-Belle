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
    meta: { title: 'Laura-Belle' }
  },
  {
    path: '/ChartOfAccounts',
    name: 'Accounting',
    component: Accounting,
    meta: { title: 'Chart of Accounts' }
  },
  {
    path: '/JournalEntry',
    name: 'JournalEntry',
    component: JournalEntry,
    meta: { title: 'Journal Entry' }
  },
  {
    path: '/GeneralLedger',
    name: 'GeneralLedger',
    component: GeneralLedger,
    meta: { title: 'General Ledger' }
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
