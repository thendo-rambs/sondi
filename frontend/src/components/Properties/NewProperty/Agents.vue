<template>
  <el-form-item label="Agents">
    <el-select v-model="selectedAgents.list" @click="listChanged([])" multiple>
      <el-option
        v-for="agent in agents.list"
        :key="agent.id"
        :label="agent.name"
        :value="agent.id"
      />
    </el-select>
  </el-form-item>
</template>

<script lang="ts">
import GetError, { ResponseError } from "@/Helpers/GetError";
import { List } from "@/Types";
import { IAgent } from "@/Types/Property";
import PropertyService from "@/services/PropertyService";
import { defineComponent, onMounted, reactive, watch } from "vue";

export default defineComponent({
  emits: {
    agentListChange: (list: number[]) => {
      return (list && true) || false;
    },
  },
  setup(_, { emit }) {
    const agents = reactive<List<IAgent>>({ list: [] });
    const selectedAgents = reactive<List<number>>({ list: [] });
    function listChanged(list: number[]) {
      emit("agentListChange", list);
    }
    watch(selectedAgents, ({ list }) => {
      listChanged(list);
    });

    onMounted(async () => {
      try {
        const { data: responseData } = await PropertyService.getAgents();
        agents.list = responseData.data;
      } catch (e) {
        GetError(e as ResponseError);
      }
    });
    return {
      agents,
      selectedAgents,
      listChanged,
    };
  },
});
</script>
