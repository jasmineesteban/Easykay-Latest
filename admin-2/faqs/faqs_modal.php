<div class="modal fade" id="addFaqs" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addFaqsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addFaqsLabel">Add New</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> 
                <form action="" method="POST" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="form-group m-2">
                            <label for="question" class="col-sm-4 col-form-label">Question<span class="required-asterisk">*</span></label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="question" name="question" rows="3" required></textarea>
                                <div class="invalid-feedback">Please fill up the field.</div>
                            </div>
                        </div>
                        <div class="form-group m-2">
                            <label for="answer" class="col-sm-4 col-form-label">Answer<span class="required-asterisk">*</span></label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="answer" name="answer" rows="3" required></textarea>
                                <div class="invalid-feedback">Please fill up the field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-4 mx-4">
                        <button type="submit" name="add-faqs" class="btn btn-primary">Add</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    