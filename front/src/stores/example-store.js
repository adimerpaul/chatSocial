import { defineStore } from 'pinia';

export const useCounterStore = defineStore('counter', {
  state: () => ({
    user: {},
    users: [],
    userChat: {},
    chats: [],
    isLoggedIn:!!localStorage.getItem('tokenChat'),
    version: '1.0.0',
  }),
  getters: {
    doubleCount: (state) => state.counter * 2,
  },
  actions: {
    increment() {
      this.counter++;
    },
  },
});
