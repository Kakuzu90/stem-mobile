<template>
  <div class="content-body">
    <classroom-information 
      :information="information" 
      @pageView="onPageClick" />
    <classroom-content :view="view" ref="body"
      :collection="collection" 
       />
  </div>
</template>

<script>
import ClassroomInformation from '../../components/ClassroomInformation';
import ClassroomContent from '../../components/ClassroomContent';
export default {
  props: ['api'],
  components: {
    ClassroomInformation,
    ClassroomContent
  },
  data() {
    return {
      information: {},
      collection: [],
      view: 'assignments',
    }
  },
  mounted() {
    this.getClassroomInfo();
    const currentUrl = new URL(window.location.href);
    const urlParams = new URLSearchParams(currentUrl.search);
    if (!urlParams.has('view')) {
      const newUrl = `${currentUrl}?view=${this.view}`;
      window.history.replaceState({}, '', newUrl);
    }else {
      const view = urlParams.get('view');
      if (view !== 'assignments' && view !== 'quiz' && view !== 'modules' || view !== '') {
        urlParams.set('view', view);
        this.view = view;
        currentUrl.search = urlParams.toString();
        window.history.replaceState({}, '', currentUrl.href);
      }else {
        this.view = view;
      }
    }
    this.getCollection(this.view);
  },
  methods: {
    getClassroomInfo() {
      axios.get(this.api)
        .then(response => {
          this.information = response.data.data;
        })
    },
    getCollection(page) {
      axios.get(this.api + '/' + page)
        .then(response => {
          this.hideLoader();
          this.collection = response.data.data;
        }) 
    },
    onPageClick(page) {
      if (page !== this.view) {
        this.showLoader();
        this.view = page;
        const currentUrl = new URL(window.location.href);
        const urlParams = new URLSearchParams(currentUrl.search);
        if (!urlParams.has('view')) {
          const newUrl = `${currentUrl}?view=${this.view}`;
          window.history.replaceState({}, '', newUrl);
        }else {
          urlParams.set('view', page);
          currentUrl.search = urlParams.toString();
          window.history.replaceState({}, '', currentUrl.href);
        }
        this.getCollection(page);
        const content = this.$refs.body;
        if (content) {
          content.$el.nextElementSibling.scrollIntoView({ behavior: 'smooth', block: 'start'});
        }
      }
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
