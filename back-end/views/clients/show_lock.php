<?php

require_once ('config/MetaConstants.php');

/**
 * Created by IntelliJ IDEA.
 * User: lucasnascimento
 * Date: 24/06/2016
 * Time: 2:54 PM
 */

foreach($metas as $meta) {

    if ($meta -> meta_key == MetaConstants::WEBSITE_URL) {
        $website_url = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::MAIN_KEYPHRASE) {
        $main_keyphrase = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::BUSINESS_ADDRESS) {
        $business_address = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::ABN) {
        $abn = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::ABOUT_US) {
        $about_us = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::ABOUT_US_SHORT) {
        $about_us_short = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::ABOUT_US_SHORT) {
        $about_us_short = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::CALL_TO_ACTION) {
        $call_to_action = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::SERVICE_1) {
        $service_1 = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::SERVICE_1_TEXT) {
        $service_1_text = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::SERVICE_1_EXCERPT) {
        $service_1_excerpt = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::AREA_1) {
        $area_1 = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::SERVICE_2) {
        $service_2 = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::SERVICE_2_TEXT) {
        $service_2_text = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::SERVICE_2_EXCERPT) {
        $service_2_excerpt = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::AREA_2) {
        $area_2 = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::SERVICE_3) {
        $service_3 = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::SERVICE_3_TEXT) {
        $service_3_text = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::SERVICE_3_EXCERPT) {
        $service_3_excerpt = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::AREA_3) {
        $area_3 = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::SERVICE_4) {
        $service_4 = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::SERVICE_4_TEXT) {
        $service_4_text = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::SERVICE_4_EXCERPT) {
        $service_4_excerpt = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::AREA_4) {
        $area_4 = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::TESTIMONIAL_1) {
        $testimonial_1 = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::TESTIMONIAL_1_TEXT) {
        $testimonial_1_text = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::TESTIMONIAL_2) {
        $testimonial_2 = $meta -> meta_value;
    }
    if ($meta -> meta_key == MetaConstants::TESTIMONIAL_2_TEXT) {
        $testimonial_2_text = $meta -> meta_value;
    }

}

$business_name  = $client->business_name;
$business_phone = $client->business_phone;
$business_email = $client->business_email;
$roc_id         = $client -> roc_id;

?>

<form method="post" name="frmClient" action="?controller=clients&action=generate_sql">
    <!-- About Section -->
    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">[ABOUT CLIENT]</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label for="website_url">[Website_URL]</label>
                        <input type="text" class="form-control" id="website_url" name="website_url" placeholder="website_url" value="<?php echo $website_url ?>" readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label for="main_keyphrase">[Main_Keyphrase]</label>
                        <input type="text" class="form-control" id="main_keyphrase" name="main_keyphrase" placeholder="main_keyphrase" value="<?php echo $main_keyphrase ?>" readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label for="business_name">[Business-Name]</label>
                        <input type="text" class="form-control" id="business_name" name="business_name" placeholder="business_name" value="<?php echo $business_name ?>" readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label for="business_phone">[Business-Phone]</label>
                        <input type="text" class="form-control" id="business_phone" name="business_phone" placeholder="business_phone" value="<?php echo $business_phone; ?>" readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label for="business_email">[Business-Email]</label>
                        <input type="email" class="form-control" id="business_email" name="business_email" placeholder="business_email" value="<?php echo $business_email; ?>" readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label for="business_address">[Business-Address]</label>
                        <input type="text" class="form-control" id="business_address" name="business_address" placeholder="business_address" value="<?php echo $business_address; ?>" readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label for="abn">[ABN]</label>
                        <input type="text" class="form-control" id="abn" name="abn" placeholder="abn" value="<?php echo $abn; ?>" readonly="readonly">
                    </div>
                    
                    <div class="form-group">
                        <label for="about_us">[About-Us]</label>
                        <textarea class="form-control" rows="5" id="about_us" name="about_us" placeholder="about_us" readonly="readonly"><?php echo $about_us ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="about_us_short">[About-Us-Short]</label>
                        <textarea class="form-control" rows="2" id="about_us_short" name="about_us_short" placeholder="about_us_short" readonly="readonly"><?php echo $about_us_short ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="call_to_action">[Call-To-Action]</label>
                        <textarea class="form-control" rows="2" id="call_to_action" name="call_to_action" placeholder="call_to_action" readonly="readonly"><?php echo $call_to_action ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service 1 Section -->
    <section id="service-1" class="bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">[SERVICE 1]</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label for="service_1">[Service-1]</label>
                        <input type="text" class="form-control" id="service_1" name="service_1" placeholder="service_1" value="<?php echo $service_1 ?>" readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label for="service_1_excerpt">[Service-1-Excerpt] * short description</label>
                        <textarea class="form-control" rows="2" id="service_1_excerpt" name="service_1_excerpt" placeholder="service_1_excerpt" readonly="readonly"><?php echo $service_1_excerpt ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="service_1_text">[Service-1-Text] * long description</label>
                        <textarea class="form-control" rows="5" id="service_1_text" name="service_1_text" placeholder="service_1_text" readonly="readonly"><?php echo $service_1_text ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="area_1">[Area-1]</label>
                        <textarea class="form-control" rows="2" id="area_1" name="area_1" placeholder="area_1" readonly="readonly"><?php echo $area_1 ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service 2 Section -->
    <section id="service-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">[SERVICE 2]</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label for="service_2">[Service-2]</label>
                        <input type="text" class="form-control" id="service_2" name="service_2" placeholder="service_2" value="<?php echo $service_2 ?>" readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label for="service_2_excerpt">[Service-2-Excerpt] * short description</label>
                        <textarea class="form-control" rows="2" id="service_2_excerpt" name="service_2_excerpt" placeholder="service_2_excerpt" readonly="readonly"><?php echo $service_2_excerpt ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="service_2_text">[Service-2-Text] * long description</label>
                        <textarea class="form-control" rows="5" id="service_2_text" name="service_2_text" placeholder="service_2_text" readonly="readonly"><?php echo $service_2_text ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="area_2">[Area-2]</label>
                        <textarea class="form-control" rows="2" id="area_2" name="area_2" placeholder="area_2" readonly="readonly"><?php echo $area_2 ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service 3 Section -->
    <section id="service-3" class="bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">[SERVICE 3]</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label for="service_3">[Service-3]</label>
                        <input type="text" class="form-control" id="service_3" name="service_3" placeholder="service_3" value="<?php echo $service_3 ?>" readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label for="service_3_excerpt">[Service-3-Excerpt] * short description</label>
                        <textarea class="form-control" rows="2" id="service_3_excerpt" name="service_3_excerpt" placeholder="service_3_excerpt" readonly="readonly"><?php echo $service_3_excerpt ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="service_3_text">[Service-3-Text] * long description</label>
                        <textarea class="form-control" rows="5" id="service_3_text" name="service_3_text" placeholder="service_3_text" readonly="readonly"><?php echo $service_3_text ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="area_3">[Area-3]</label>
                        <textarea class="form-control" rows="2" id="area_3" name="area_3" placeholder="area_3" readonly="readonly"><?php echo $area_3 ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Service 4 Section -->
    <section id="service-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">[SERVICE 4]</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label for="service_4">[Service-4]</label>
                        <input type="text" class="form-control" id="service_4" name="service_4" placeholder="service_4" value="<?php echo $service_4 ?>" readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label for="service_4_excerpt">[Service-4-Excerpt] * short description</label>
                        <textarea class="form-control" rows="2" id="service_4_excerpt" name="service_4_excerpt" placeholder="service_4_excerpt" readonly="readonly"><?php echo $service_4_excerpt ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="service_4_text">[Service-4-Text] * long description</label>
                        <textarea class="form-control" rows="5" id="service_4_text" name="service_4_text" placeholder="service_4_text" readonly="readonly"><?php echo $service_4_text ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="area_4">[Area-4]</label>
                        <textarea class="form-control" rows="2" id="area_4" name="area_4" placeholder="area_4" readonly="readonly"><?php echo $area_4 ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Testimonial Section -->
    <section id="testimonial" class="bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">[TESTIMONIAL 1]</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label for="testimonial_1">[Testimonial-1] author</label>
                        <textarea class="form-control" rows="2" id="testimonial_1" name="testimonial_1" placeholder="testimonial_1" readonly="readonly"><?php echo $testimonial_1 ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="testimonial_1_text">[Testimonial-1-Text] content</label>
                        <textarea class="form-control" rows="5" id="testimonial_1_text" name="testimonial_1_text" placeholder="testimonial_1_text" readonly="readonly"><?php echo $testimonial_1_text ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="testimonial" class="bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">[TESTIMONIAL 2]</h2>
                    <hr class="primary">
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                        <label for="testimonial_2">[Testimonial-2] author</label>
                        <textarea class="form-control" rows="2" id="testimonial_2" name="testimonial_2" placeholder="testimonial_2" readonly="readonly"><?php echo $testimonial_2 ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="testimonial_2_text">[Testimonial-2-Text] content</label>
                        <textarea class="form-control" rows="5" id="testimonial_2_text" name="testimonial_2_text" placeholder="testimonial_2_text" readonly="readonly"><?php echo $testimonial_2_text ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <aside>
        <div class="container text-center">
            <div class="call-to-action">
                <h2>Generate SQL!!!</h2>
                <input type="submit" value="Let's Generate" name="btnFrmClient" class="page-scroll btn btn-default btn-xl sr-button">
            </div>
        </div>
    </aside>

    <aside>
        <div class="container text-center">
            <div class="call-to-action">
                <h2>Edit Information</h2>
                <input type="submit" value="Let's Generate" name="btnFrmClient" class="page-scroll btn btn-primary btn-xl sr-button">
            </div>
        </div>
    </aside>

    <input type="hidden" id="client_id" name="client_id" value="<?php echo $roc_id ?>">

</form>