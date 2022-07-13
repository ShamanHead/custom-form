<?php
/**
 * Main template file, all magic here
 */
if( wp_is_block_theme() ) {
    block_template_part('header'); //Будет рендерить, но плохенько
} else {
    get_header();
}
?>
<main class="custom-form__wrapper"> 
     <div class="custom-form__form" id="custom-form">
        <div class="box-message"></div>
        <input type="hidden" name="is-form-submitted"> 
        <input type="text" name="first_name" placeholder="First name">
        <input type="text" name="last_name" placeholder="Last name">
        <input type="text" name="subject" placeholder="Subject">
        <input type="text" name="message" placeholder="Message">
        <input type="text" name="email" placeholder="Email">
        <input type="submit" name="submit-form" id="submit-form"> 
    </div> 
</main>
<?php

if( wp_is_block_theme() ) {
    block_template_part('header');
} else {
    get_footer();
}
