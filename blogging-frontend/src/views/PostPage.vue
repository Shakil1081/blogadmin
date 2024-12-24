<template>
    <div class="container mt-5">
      <h2 class="mb-4">Manage Posts</h2>
  
      <button @click="showForm = !showForm" class="btn btn-success mb-3">
        {{ showForm ? 'Hide Form' : 'Create Post' }}
      </button>
  
      <form v-if="showForm" @submit.prevent="createPost">
        <div class="row mb-3">
          <div class="col-12 col-md-6">
            <label for="title" class="form-label">Title</label>
            <input type="text" v-model="newPost.title" id="title" class="form-control" required />
          </div>
          <div class="col-12 col-md-6">
            <label for="author" class="form-label">Author</label>
            <input type="text" v-model="newPost.author" id="author" class="form-control" required />
          </div>
        </div>
  
        <div class="row mb-3">
          <div class="col-12">
            <label for="content" class="form-label">Content</label>
            <textarea v-model="newPost.content" id="content" class="form-control" rows="4" required></textarea>
          </div>
        </div>
  
        <div class="row">
          <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">Create Post</button>
          </div>
        </div>
      </form>
  
      <hr />
  
      <h3>All Posts</h3>
      <table ref="postsTable" id="postsTable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Title</th>
            <th>Content</th>
            <th>Author</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="post in posts" :key="post.id">
            <td>{{ post.title }}</td>
            <td>{{ post.content }}</td>
            <td>{{ post.author }}</td>
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
    name: 'PostPage',
    data() {
      return {
        posts: [],
        newPost: {
          title: '',
          content: '',
          author: '',
        },
        showForm: false,
      };
    },
    async created() {
      await this.fetchPosts();
      this.$nextTick(() => {
        $('#postsTable').DataTable();
      });
    },
    methods: {
      async fetchPosts() {
        try {
          const response = await apiClient.get('/posts');
          this.posts = response.data;
        } catch (error) {
          console.error('Error fetching posts:', error.message);
        }
      },
      async createPost() {
        try {
          const response = await apiClient.post('/posts', this.newPost);
          this.posts.push(response.data);
          this.newPost.title = '';
          this.newPost.content = '';
          this.newPost.author = '';
          this.showForm = false;
  
          this.$nextTick(() => {
            $('#postsTable').DataTable().destroy();
            $('#postsTable').DataTable();
          });
        } catch (error) {
          if (error.response && error.response.status === 422) {
            alert('Validation failed. Please ensure all fields are filled correctly.');
          } else {
            console.error('Error creating post:', error.message);
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
  