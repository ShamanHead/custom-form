<?php

add_action( 'wp_ajax_form_submit', 'endpoint' );

function endpoint($data) {
    echo "da";

    return $data;
}
