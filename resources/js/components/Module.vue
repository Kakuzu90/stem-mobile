<template>
  <div class="col-lg-5 mx-auto">
    <div class="card" v-if="filteredCollection.length === 0">
      <div class="card-body text-center">
        <h4 class="card-text text-danger fw-bolder mb-0">
          No Items Found!
        </h4>
      </div>
    </div>
    <div
        v-for="item in filteredCollection"
        :key="item.title"
    >
      <div class="card border-right-danger mb-2">
        <div class="card-header p-1">
          <div>
              <h4 class="fw-bolder mb-0">{{ item.title }}</h4>
              <a :href="item.link" class="badge badge-pill bg-light-primary" download>
                Download
              </a>
          </div>
          <div class="avatar bg-light-danger p-50 m-0">
              <div class="avatar-content">
                <vue-feather type="file-text" size="30" />
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['collection', 'sort'],
  computed: {
    filteredCollection() {
      return this.collection.sort((a, b) => {
        let comparison = 0;
        if (a['title'] > b['title']) {
          comparison = 1;
        } else if (a['title'] < b['title']) {
          comparison = -1;
        }
        return this.sort ? comparison : -comparison;
      });
    }
  }
}
</script>
