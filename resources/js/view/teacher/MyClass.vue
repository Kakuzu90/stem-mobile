<template>
  <div class="content-body">
    <div class="col-lg-6 mx-auto mt-1">
      <section class="searchbar-class">
        <div class="d-flex justify-content-between align-items-center">
          <div class="input-group input-group-merge">
            <input type="text" class="form-control search-booking"
                    name="search" 
                    placeholder="Search Subject..." aria-label="Search Subject..." />
            <div class="input-group-append">
                <span class="input-group-text">
                  <i data-feather="search" class="text-muted"></i>
                </span>
            </div>
          </div>
          <div class="dropdown">
            <button
                type="button"
                data-bs-toggle="dropdown"
                aria-haspopup="true" 
                aria-expanded="false"
                class="btn btn-icon btn-relief-primary ms-50 dropdown-toggle hide-arrow"
                >
              <i data-feather="filter"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end dropdown-filter">
              <div class="p-1 pb-0">
                <div class="mb-1">
                  <label class="form-label">School Year</label>
                  <v-select 
                    placeholder="Select a school year"
                    :options="school_years"
                    v-model="school_year"
                    :reduce="(e)=>e.value"
                  />
                </div>
                <div class="mb-1">
                  <label class="form-label">Filter By</label>
                  <v-select 
                    placeholder="Select a filter by"
                    :options="[{label: 'Subject', value: 'subject'}, {label: 'Seciton', value: 'section'}]"
                    v-model="filter.by"
                    :reduce="(e)=>e.value"
                  />
                </div>
                <div class="mb-1">
                  <label class="form-label">Filter Type</label>
                  <v-select 
                    placeholder="Select a filter by"
                    :options="[{label: 'Ascending', value: 'asc'}, {label: 'Descending', value: 'desc'}]"
                    v-model="filter.type"
                    :reduce="(e)=>e.value"
                  />
                </div>
              </div>
              <div class="dropdown-divider"></div>
              <div class="d-flex justify-content-end align-items-center me-50">
                <button type="button" class="btn btn-sm btn-relief-primary" @click="applyFilter">Apply Filter</button>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="row justify-content-center align-items-center mt-2">
      <h4 class="fw-bolder text-primary">S.Y 2023 - 2024</h4>
      <div 
        class="col-lg-4 col-sm-6"
        v-for="item in filtered"
        :key="item.year"
        >
        <div class="card">
          <img class="card-img-top" :src="image" height="150" alt="Card image cap" />
          <div class="card-body text-center">
            <h3 class="fw-bolder text-primary">{{ item.subject }}</h3>
            <h4>{{ item.section }}</h4>
            <span class="badge bg-success">{{ item.students }}</span>
          </div>
          <div class="card-footer d-flex justify-content-around align-items-center">
            <div class="position-relative d-inline-block">
              <vue-feather type="file-text" size="20" class="text-dark" />
              <span v-if="item.module > 0" class="badge rounded-pill bg-danger badge-up">{{ item.module }}</span>
            </div>

            <div class="position-relative d-inline-block">
              <vue-feather type="file-plus" size="20" class="text-dark" />
              <span v-if="item.quiz > 0" class="badge rounded-pill bg-danger badge-up">{{ item.quiz }}</span>
            </div>

            <div class="position-relative d-inline-block">
              <vue-feather type="file-minus" size="20" class="text-dark" />
              <span v-if="item.assignment > 0" class="badge rounded-pill bg-danger badge-up">{{ item.assignment }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['api', 'image'],
  data() {
    return {
      my_class : [],
      school_years: [],
      search: null,
      school_year: null,
      filter: {by:null,type: null},
    }
  },
  mounted() {
    this.getMyClass();
    this.getSchoolYear();
  },
  computed: {
    filtered() {
      return this.my_class;
    }
  },
  methods: {
    getMyClass() {
      axios.get(this.api)
        .then(response => {
          this.my_class = response.data.data
        })
    },
    getSchoolYear() {
      axios.get(this.api + '/school-years')
        .then(response => {
          this.hideLoader();
          this.school_years = response.data.data;
        })
      
    },
    applyFilter() {
      alert("trigger")
    },
    showLoader() {
        $.blockUI({
            message: '<div class="spinner-border text-primary" role="status"></div>',
            css: {
                backgroundColor: 'transparent',
                border: '0'
            },
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8
            }
        });
    },
    hideLoader() {
      $.unblockUI();
    },
  },
}
</script>
