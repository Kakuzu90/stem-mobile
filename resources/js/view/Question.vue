<template>
<div class="sidebar-left">
    <div class="sidebar">
        <div class="sidebar-file-manager">
            <div class="sidebar-inner">
                <div class="p-2 border-bottom">
                    <button 
                        class="btn btn-relief-primary add-file-btn text-center w-100" 
                        type="button">
                        <span class="align-middle">Add Section</span>
                    </button>
                </div>

                <div class="sidebar-list">
                    <div class="list-group">
                        <a 
                            href="javascript:void(;)" 
                            class="list-group-item list-group-item-action active">
                            <i data-feather="star" class="me-50 font-medium-3"></i>
                            <span class="align-middle">Test I. Multiple Choice</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content-right">
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="body-content-overlay"></div>
            <div class="file-manager-main-content">
                <div class="file-manager-content-header d-flex justify-content-end align-items-center">
                    <div class="d-flex align-items-center">
                        <button
                            type="button"
                            class="btn btn-relief-success me-25"
                        >
                            <span class="align-middle">Save Changes</span>
                        </button>
                        <button
                            type="button"
                            class="btn btn-relief-warning me-25"
                        >
                            <span class="align-middle">Show Answers</span>
                        </button>
                        <button
                            type="button"
                            class="btn btn-relief-primary"
                        >
                            <span class="align-middle">Add Question</span>
                        </button>
                    </div>
                </div>
                <div class="file-manager-content-body pb-2">
                    <h4 class="text-dark fw-bolder mb-0">
                        Test I. Multiple Choice
                    </h4>
                    <p>
                        <span class="text-danger fw-bold">Direction:</span> Please select 1 answer only
                    </p>
                    <div class="row g-1">
                        <div class="col-12">
                            <div class="border rounded p-1">
                                <div class="d-flex justify-content-end align-items-center">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-icon btn-relief-success me-25"
                                    >
                                        <i data-feather="edit"></i>
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-icon btn-relief-danger"
                                    >
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </div>
                                <p class="mb-0 text-dark">
                                    1. What is your favorite color? <span class="text-warning fw-bolder">(5 points)</span>
                                </p>
                                <span class="text-muted">
                                    Direction: Sample direction here
                                </span>
                                <div class="row justify-content-center align-items-center mt-1">
                                    <div class="col-6">
                                        <span class="fw-bolder text-dark">A.</span> Red
                                    </div>
                                    <div class="col-6">
                                        <span class="fw-bolder text-dark">B.</span> Blue
                                    </div>
                                    <div class="col-6">
                                        <span class="fw-bolder text-dark">C.</span> Green
                                    </div>
                                    <div class="col-6">
                                        <span class="fw-bolder text-dark">D.</span> Yellow
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="border rounded p-1">
                                <p class="mb-0 text-dark">
                                    2. NORSU-BSC? <span class="text-warning fw-bolder">(10 points)</span>
                                </p>
                                <span class="text-muted">
                                    Direction: Sample direction here
                                </span>
                                <input type="text" placeholder="Answer Here" class="form-control mt-1" readonly />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="border rounded p-1">
                                <p class="mb-0 text-dark">
                                    3. 1+1. Show your solution <span class="text-warning fw-bolder">(10 points)</span>
                                </p>
                                <span class="text-muted">
                                    Direction: Sample direction here
                                </span>
                                <div class="mt-1">
                                    <img src="/images/placeholder.png" class="img-fluid" alt="Placeholder Image"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
  mounted() {
    this.hideLoader();
  },
  methods: {
    hideLoader() {
      $.unblockUI();
    }
  },
}
</script>
