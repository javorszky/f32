<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<!-- Set the viewport width to device width for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title><?php the_title(); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <nav class="top-bar">
      <ul>
        <li class="name"><h1><a href="#">Title</a></h1></li>
        <li class="toggle-topbar"><a href="#"></a></li>
      </ul>
      <section>
        <ul class="left">
          <li><a href="#">Link</a></li>
        </ul>

        <ul class="right">
          <li><a href="#">Link</a></li>
        </ul>
      </section>
    </nav>