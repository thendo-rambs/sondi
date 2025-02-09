<template>
  <el-container class="user-list" v-loading="loading">
    <transition v-for="user in users" name="el-fade-in" :key="user.id">
      <user-item @onDeleted="deleted" @onUpdated="updated" :user="user" />
    </transition>
  </el-container>
</template>

<script lang="ts">
import { defineComponent, onMounted, ref } from "vue";
import { IUserDataType } from "@/store/auth";
import UserItem from "@/components/User/UserItem.vue";
import UserService from "@/services/UsersService";

export default defineComponent({
  components: {
    UserItem,
  },
  setup() {
    const loading = ref(false);
    const photo = ref("");
    const users = ref<IUserDataType[]>([]);
    onMounted(async () => {
      loading.value = true;
      try {
        const response = await UserService.getAll();
        users.value = response.data.data;
        loading.value = false;
      } catch (error) {
        loading.value = false;
      }
    });
    async function updated(id: number) {
      try {
        const response = await UserService.get(id);
        const currentUser = response.data.data;
        if (currentUser) {
          const index = users.value.findIndex((user) => user.id === id);
          users.value[index] = currentUser;
        }
      } catch (error) {
        loading.value = false;
      }
    }
    function deleted(id: number) {
      users.value = users.value.filter((user) => user.id !== id);
    }
    return {
      deleted,
      updated,
      users,
      loading,
    };
  },
});
</script>

<style lang="scss" scoped>
.user-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(20rem, 1fr));
  max-width: 1024px;
}
</style>
