<?php
  $rows = mysqli_query($conn, "SELECT * FROM tb_faqs");



?>

<div class="modal fade" id="faqsModal" tabindex="-1" aria-labelledby="faqsModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="faqsModal">FAQs</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <?php foreach($rows as $row) : ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5><b><?php echo $row['faqs_question'];?></b></h5>
                                <p class="mx-4"><?php echo $row['faqs_answer'];?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>