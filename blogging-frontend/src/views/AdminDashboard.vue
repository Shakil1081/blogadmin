<template>
  <div>
    <h1>Admin Dashboard</h1>
    <UserForm @user-added="fetchUsers" />
    <UserList />
  </div>
</template>

<script>
import UserForm from '../components/UserForm.vue';
import UserList from '../components/UserList.vue';

export default {
  name: 'AdminDashboard',
  components: {
    UserForm,
    UserList,
  },
};
</script>
