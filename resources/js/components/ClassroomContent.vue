<template>
  <div class="mx-auto col-lg-5 col-md-5 col-sm-5 col-10 mb-1">
    <div class="d-flex justify-content-between align-items-center">
      <h4 class="card-title text-dark mb-0">
      List of {{ filteredView }}
      </h4>
      <button
        type="button"
        class="btn btn-icon btn-sm btn-relief-primary"
        @click="toggleSort"
      >
        <vue-feather :type="sortIcon" size="15" />
      </button>
    </div>
  </div>
  <activity :collection="collection" :sort="sort" v-if="isActivity" />
  <module :collection="collection" :sort="sort" v-if="isModule" />
</template>

<script>
import Activity from './Activity';
import Module from './Module';
export default {
  props: ['view', 'collection'],
  components: {
    Activity,
    Module
  },
  data() {
    return {
      sort: true,
    }
  },
  computed: {
    sortIcon() {
      return this.sort ? 'chevrons-down' : 'chevrons-up';
    },
    filteredView() {
      return this.view.charAt(0).toUpperCase() + this.view.slice(1).toLowerCase();
    },
    isActivity() {
      return this.view === 'assignments' || this.view === 'quiz';
    },
    isModule() {
      return this.view === 'modules';
    }
  },
  methods: {
    toggleSort() {
      this.sort = !this.sort;
    }
  },
}
</script>
