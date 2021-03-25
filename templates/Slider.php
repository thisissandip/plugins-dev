<?php

$args = array(
    "post_type" => "testimonial",
    "post_status" => "publish",
    "posts_per_page" => 5,
);

$query = new WP_Query( $args );

if($query->have_posts()){
    $i =1;

    echo '<div class="slider-wrapper">
    <span class="arrow-left arrow">	&#60; </span>
    <span class="arrow-right arrow"> &#62; </span>
            <div class="slider-container">
            <div class="slider">
    ';

    while($query->have_posts()):
        $query->the_post();

        $name = get_post_meta( get_the_ID(), '_sandip_testimonial_key', true )['name'] ?? '';

        echo '<div class="single-slide-container'. ($i===1 ? ' is-active': '') .' ">
                <div><strong>'. get_the_title() .'</strong></div>
                <div>'. get_the_content() .'</div>
                <div> Author: '. $name .'</div>
            </div>
            <br/>
            ';
        $i++;
    endwhile;

    echo '  </div>
            </div>
            </div>';

}


?>