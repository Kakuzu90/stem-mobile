<div class="modal fade" id="delete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-body text-center">
                    <h4 class="modal-title">Confirm Deletion</h4>
                    <h6 class="card-text my-2">
                        Are you sure you want to delete <span class="item-to-delete text-danger"></span>?
                    </h6>
                </div>
                <div class="modal-footer justify-content-center align-items-center pt-0">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-sm btn-relief-dark">
                        <i data-feather="x"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-sm btn-relief-danger">
                        <i data-feather="trash"></i> Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>