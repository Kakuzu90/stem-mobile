<template>
  <div class="col-lg-5 mx-auto mt-1">
    <section class="searchbar-class">
      <div class="d-flex justify-content-between align-items-center">
        <div class="input-group input-group-merge">
          <input type="text" class="form-control search-booking"
                  name="search" v-model="search"
                  placeholder="Search Subject..." aria-label="Search Subject..." />
          <div class="input-group-append">
              <span class="input-group-text">
                <i data-feather="search" class="text-muted"></i>
              </span>
          </div>
        </div>
        <div class="dropdown dropdown-filter-container">
          <button
              type="button"
              id="dropdownFilterButton"
              aria-haspopup="true"
              aria-expanded="false"
              class="btn btn-icon btn-relief-primary ms-50 d-block dropdown-filter-toggle hide-arrow"
              >
            <i data-feather="filter"></i>
          </button>
          <div 
            class="dropdown-filter dropdown-menu dropdown-menu-end"
            data-bs-popper="none"
            aria-labelledby="dropdownFilterButton"
            >
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
              <button type="button" class="btn dropdown-close btn-sm btn-relief-primary" @click="applyFilter">Apply Filter</button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="row justify-content-center align-items-center mt-2">
    <h4 class="fw-bolder text-primary">{{ selectedSY }}</h4>
    <h3 v-if="filtered.length === 0" class="text-dark fw-bolder">
      No Subjects Found!
    </h3>
    <div 
      class="col-lg-3 col-md-6 col-sm-6"
      v-for="item in filtered"
      :key="item.year"
      >
      <div class="card cursor-pointer" @click="openClassroom(item.classroom_id, item.subject_id)">
        <img class="card-img-top" :src="image" height="150" alt="Card image cap" />
        <div class="card-body text-center">
          <h3 class="fw-bolder text-primary mb-0">{{ item.subject }}</h3>
          <h4>{{ item.section }}</h4>
          <div class="d-flex jusitfy-content-center align-items-center flex-column">
            <div class="avatar avatar-lg">
                <img :src="item.teacher_profile" alt="avatar" />
            </div>
            <h6 class="text-primary fw-bolder mb-0">{{ item.teacher_name }}</h6>
          </div>
        </div>
        <div class="card-footer d-flex justify-content-around align-items-center">
          <div class="badge bg-light-secondary p-50 border border-dark">
            <span class="text-dark">Modules</span>
            <span v-if="item.module > 0" class="badge rounded-pill bg-danger ms-25">{{ item.module }}</span>
          </div>

          <div class="badge bg-light-secondary p-50 border border-dark">
            <span class="text-dark">Quiz</span>
            <span v-if="item.quiz > 0" class="badge rounded-pill bg-danger ms-25">{{ item.quiz }}</span>
          </div>

          <div class="badge bg-light-secondary p-50 border border-dark">
            <span class="text-dark">Assignments</span>
            <span v-if="item.assignment > 0" class="badge rounded-pill bg-danger ms-25">{{ item.assignment }}</span>
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
      old_school_year: null,
      school_year: null,
      filter: {by:null,type: null},
    }
  },
  async mounted() {
    await this.getMySchoolYear();
    this.getMyClass();
  },
  computed: {
    filtered() {
      let filtered = this.my_class;
      if (this.search) {
        filtered = filtered.filter(item => {
          return item.subject.toLowerCase().includes(this.search.toLowerCase());
        });
      }
      if (this.filter.by && this.filter.type) {
        filtered = filtered.sort((a, b) => {
          const modifier = this.filter.type === 'asc' ? 1 : -1;
          return modifier * (a[this.filter.by] > b[this.filter.by] ? 1 : -1);
        });
      }
      return filtered;
    },
    selectedSY() {
      const selected = this.school_years?.find(item => item.value === this.school_year);
      if (selected) {
        return "S.Y. " + selected?.label;
      }
    },
  },
  methods: {
    getMyClass() {
      axios.get(this.api + '/' + this.school_year)
          .then(response => {
            this.hideLoader();
            this.my_class = response.data.data;
          });
    },
    async getMySchoolYear() {
      await axios.get(this.api)
        .then(response => {
          this.school_years = response.data.data;
          this.school_year = this.school_years[0].value;
          this.old_school_year = this.school_year;
        })
    },
    openClassroom(classroom, subject) {
      window.location.assign('/student/classroom/' + classroom + '/subject/' + subject);
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
