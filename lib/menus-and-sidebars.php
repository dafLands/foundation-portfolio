<?php

function register_foundation_portfolio_menus() {
  register_nav_menus(
    array(
      'primary_navigation' => __( 'Primary Navigation' ),
      'footer_navigation' => __( 'Footer Navigation' )
      ));
}
add_action( 'init', 'register_foundation_portfolio_menus' );

function foundation_portfolio_widget_init() {

  register_sidebar( array(
    'name'          => __( 'Jumbotron', 'foundation-porfolio' ),
    'id'            => 'sidebar_jumbotron',
    'description'   => 'The big ass header area on the home page',
          'class'         => 'primary-color',
    'before_widget' => '<div class="content row">
        <section class="large-8 columns">',
    'after_widget'  => '      </section>
      </div>',
    'before_title'  => '<h1 class="jumbo-title">',
    'after_title'   => '</h1>'
  ));

  register_sidebar( array(
    'name'          => __( 'Contact Form', 'foundation-porfolio' ),
    'id'            => 'sidebar_contact_form',
    'description'   => 'For use with contact form widget',
          'class'         => 'form',
    'before_widget' => '<div class="contact-form">',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="form-title" style="display:none">',
    'after_title'   => '</h2>'
  ));

}
add_action( 'widgets_init', 'foundation_portfolio_widget_init');

