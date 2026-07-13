<?php
/**
 * Plantilla de respaldo (blog, archivos, resultados de búsqueda).
 *
 * @package Vlac_Systems
 */

get_header();
?>

<main class="page-content">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class(); ?>>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div><?php the_excerpt(); ?></div>
			</article>
			<?php
		endwhile;

		the_posts_pagination();
	else :
		?>
		<p><?php esc_html_e( 'No se encontró contenido.', 'vlac-systems' ); ?></p>
		<?php
	endif;
	?>
</main>

<?php
get_footer();
