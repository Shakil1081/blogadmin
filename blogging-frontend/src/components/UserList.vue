<template>
  <div class="container mt-5">
    <h2 class="mb-4">User Profiles</h2>
    <table id="userTable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Bio</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.bio }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import $ from 'jquery';
import 'datatables.net-bs5'; 
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css'; 
import apiClient from '../api'; 

export default {
  name: 'UserList',
  data() {
    return {
      users: [], 
    };
  },
  async created() {
    try {
      const response = await apiClient.get('/users');
      this.users = response.data;
      this.$nextTick(() => {
        $('#userTable').DataTable();
      });
    } catch (error) {
      console.error('Error fetching user data:', error.message);
    }
  },
};
</script>
