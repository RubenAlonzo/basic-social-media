  <!-- Reply Modal -->
  <div class="modal fade" id="replyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Reply</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <form action="../../app/controllers/home/Response.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <input type="hidden" id="postid" name="postid" value="">
              <input type="hidden" id="parentid" name="parentid" value="">
              <textarea class="form-control mb-3" rows="4" placeholder="Leave a comment here" name="textresponse"></textarea>
              <input class="form-control form-control-sm mb-3" name="photoresponse" accept=".jpg,.png,.jpeg" type="file">
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary float-end">Publish</button>
            </div>
          </form>
      </div>
    </div>
  </div>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
          <form action="../../app/controllers/home/Edit.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <input type="hidden" id="postid" name="postid" value="">
              <input type="hidden" id="parentid" name="parentid" value="">
              <textarea class="form-control mb-3" rows="4" placeholder="Leave a comment here" name="textresponse"></textarea>
              <input class="form-control form-control-sm mb-3" name="photoresponse" accept=".jpg,.png,.jpeg" type="file">
              </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary float-end">Publish</button>
            </div>
          </form>
      </div>
    </div>
  </div>
  

