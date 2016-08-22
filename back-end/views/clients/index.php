<?php
/**
 * Created by IntelliJ IDEA.
 * User: lucasnascimento
 * Date: 26/06/2016
 * Time: 2:06 PM
 */

?>


<section class="bg-primary" id="about">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center">

                <h2 class="section-heading">First Step</h2>
                <hr class="light">

                <p class="text-faded">Select a client to update o click on Create New</p>

                <form method="post" name="frmClient" action="?controller=clients&action=show">



                    <div class="form-group">
                        <label for="client_id">Select list:</label>
                        <?php if ( !empty($clients) ) { ?>
                            <select data-live-search="true" name="client_id" class="form-control" id="client_id">
                                <?php foreach($clients as $client) { ?>
                                    <option data-tokens="<?php echo $client->business_name; ?>" value="<?php echo $client->roc_id; ?>" ><?php echo $client->business_name; ?></option>
                                <?php } ?>
                            </select>
                            <div style="padding: 10px"></div>
                            <button type="submit" value="Update" class="page-scroll btn btn-default btn-xl sr-button">Update</button>
                        <?php } else { ?>
                            <select data-live-search="true" name="client_id" class="form-control" id="client_id" disabled="false">
                                <option selected>
                                    No clients found
                                </option>
                            </select>
                            <div style="padding: 10px"></div>
                            <button type="submit" value="Update" class="page-scroll btn btn-default btn-xl sr-button" disabled="false">Update</button>
                        <?php } ?>
                    </div>


                </form>
            </div>
        </div>
    </div>
</section>

<aside class="bg-dark">
    <div class="container text-center">
        <div class="call-to-action">
            <h2>Create New!</h2>
            <a href="?controller=clients&action=home" class="page-scroll btn btn-default btn-xl sr-button">Create a new</a>
        </div>
    </div>
</aside>

