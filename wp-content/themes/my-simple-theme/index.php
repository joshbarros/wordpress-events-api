<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php get_header(); ?>
    
    <div id="content">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                the_title( '<h1>', '</h1>' );
                the_content();
            endwhile;
        else :
            echo '<p>No content available.</p>';
        endif;
        ?>
    </div>

    <?php get_footer(); ?>
    <?php wp_footer(); // WordPress hook for inserting scripts ?>
</body>
</html>
