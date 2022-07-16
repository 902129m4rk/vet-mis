<!-- Add Pet Modal -->
<div class="modal fade" id="add_productcat<?php echo $addproductcat['id'] ?>" aria-hidden="true" tabindex="-1" aria-labelledby="add_productcat">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class=" modal-content bg-light">
            <form action="includes/modal/add_product_category_query.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add Product Category
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
                </div>
                <div class="modal-body ml-xl-5 mr-xl-5 mr-lg-5 ml-lg-5 mr-sm-3 ml-sm-3 ml-md-3 mr-md-3 ml-3 mr-3">
                    <div class="form-group ">
                        <label for="prod_cat_name"> <span>Name </span> <span class="text-danger"> * </span> </label>
                        <input class="form-control" type="text" placeholder="Enter Product Category Name" name="prod_cat_name" required="required">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-dismiss="modal"> Close</button>
                    <button name="add" class="btn btn-primary"> Add Product Category</button>
                </div>
            </form>
        </div>
    </div>
</div>