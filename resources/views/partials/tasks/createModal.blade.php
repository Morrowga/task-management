
  <!-- Modal -->
  <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
            <form id="createTaskFormData">
                <div class="form-group">
                    <label for="">Name <span class="required">*</span></label>
                    <input type="text" name="name" placeholder="Enter task name" class="form-control my-2 create-task-input" required>
                </div>
                <div class="form-group float-right">
                    <button type="button" class="btn btn-secondary mt-3 border-radius-20" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn custom-btn mt-3 border-radius-20">Create</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
