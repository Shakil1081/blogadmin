<template>
  <div class="container mt-5">
    <h2 class="mb-4">User Management</h2>

    <button @click="showForm = !showForm" class="btn btn-success mb-3">
      {{ showForm ? 'Hide Form' : 'Create User' }}
    </button>

    <form v-if="showForm" @submit.prevent="createUser">
      <div class="row mb-3">
        <div class="col-12 col-md-6">
          <label for="name" class="form-label">Name</label>
          <input type="text" v-model="newUser.name" id="name" class="form-control" required />
        </div>
        <div class="col-12 col-md-6">
          <label for="email" class="form-label">Email</label>
          <input type="email" v-model="newUser.email" id="email" class="form-control" required />
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12">
          <label for="bio" class="form-label">Bio</label>
          <textarea v-model="newUser.bio" id="bio" class="form-control" rows="3" required></textarea>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12">
          <label for="password" class="form-label">Password</label>
          <input type="password" v-model="newUser.password" id="password" class="form-control" required />
        </div>
      </div>
      <div class="row">
        <div class="col-12 text-end">
          <button type="submit" class="btn btn-primary">Create User</button>
        </div>
      </div>
    </form>

    <hr />

    <h3>All Users</h3>
    <table ref="usersTable" id="usersTable" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Bio</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.bio }}</td>
          <td>
            <button @click="editUser(user)" class="btn btn-warning btn-sm me-2">Edit</button>
            <button @click="deleteUser(user.id)" class="btn btn-danger btn-sm">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
 import $ from 'jquery';
import toastr from 'toastr';
import 'datatables.net-bs5';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'toastr/build/toastr.min.css';
import apiClient from '../api';

export default {
  name: 'UserList',
  data() {
    return {
      users: [],
      newUser: {
        name: '',
        email: '',
        bio: '',
        password: '',
      },
      showForm: false,
    };
  },
  async created() {
    await this.fetchUsers();
    this.$nextTick(() => {
      $('#usersTable').DataTable();
    });
  },
  methods: {
    async fetchUsers() {
      try {
        const response = await apiClient.get('/users');
        this.users = response.data;
      } catch (error) {
        toastr.error('Error fetching users');
        console.error('Error fetching users:', error.message);
      }
    },
    async createUser() {
      try {
        const response = await apiClient.post('/users', this.newUser);
        this.users.push(response.data);
        this.newUser.name = '';
        this.newUser.email = '';
        this.newUser.bio = '';
        this.newUser.password = '';
        this.showForm = false;

        this.$nextTick(() => {
          $('#usersTable').DataTable().destroy();
          $('#usersTable').DataTable();
        });

        toastr.success('User created successfully');
      } catch (error) {
        if (error.response && error.response.status === 422) {
          toastr.error('Validation failed. Please ensure all fields are filled correctly.');
        } else {
          toastr.error('Error creating user');
          console.error('Error creating user:', error.message);
        }
      }
    },
    editUser(user) {
      this.showForm = true;
      this.newUser = { ...user, password: '' };
      toastr.info('Editing user');
    },
    async deleteUser(userId) {
      if (confirm('Are you sure you want to delete this user?')) {
        try {
          await apiClient.delete(`/users/${userId}`);
          this.users = this.users.filter(user => user.id !== userId);

          this.$nextTick(() => {
            $('#usersTable').DataTable().destroy();
            $('#usersTable').DataTable();
          });

          toastr.success('User deleted successfully');
        } catch (error) {
          toastr.error('Error deleting user');
          console.error('Error deleting user:', error.message);
        }
      }
    },
  },
};

</script>

<style>
.table {
  margin-top: 20px;
  width: 100%;
}
</style>
