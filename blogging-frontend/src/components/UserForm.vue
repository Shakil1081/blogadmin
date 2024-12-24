<template>
  <div>
    <h2>Add New User</h2>
    <form @submit.prevent="submitForm">
      <div>
        <label for="name">Name:</label>
        <input type="text" v-model="name" required />
      </div>
      <div>
        <label for="email">Email:</label>
        <input type="email" v-model="email" required />
      </div>
      <div>
        <label for="bio">Bio:</label>
        <textarea v-model="bio"></textarea>
      </div>
      <button type="submit">Submit</button>
    </form>
  </div>
</template>

<script>
import apiClient from '../api';

export default {
  name: 'UserForm',
  data() {
    return {
      name: '',
      email: '',
      bio: '',
    };
  },
  methods: {
    async submitForm() {
      const newUser = { name: this.name, email: this.email, bio: this.bio };
      await apiClient.post('/users', newUser);
      alert('User added successfully!');
      this.name = '';
      this.email = '';
      this.bio = '';
      this.$emit('user-added');
    },
  },
};
</script>

