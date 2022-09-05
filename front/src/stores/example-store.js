import { defineStore } from 'pinia';

export const useCounterStore = defineStore('counter', {
  state: () => ({
    user: {},
    users: [],
    userChat: {},
    chats: [],
    socketShow: false,
    isLoggedIn:!!localStorage.getItem('tokenChat'),
    version: '1.0.0',
  }),
  getters: {
    messages: (state) => state.chats,
  },
  actions: {
    increment() {
      this.counter++;
    },
  },
});
