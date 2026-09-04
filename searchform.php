<?php
/**
 * Formulario de búsqueda del tema.
 *
 * Lo usa get_search_form() en la cabecera, en el panel móvil y en la página
 * de resultados. Cada llamada genera un identificador propio para que no se
 * repitan los «id» cuando el formulario aparece más de una vez en la página.
 *
 * @package Vlac_Systems
 */

$vlac_search_id = wp_unique_id( 'vlac-search-' );
?>
<form role="search" method="get" class="vlac-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="vlac-search-label" for="<?php echo esc_attr( $vlac_search_id ); ?>">
		<?php esc_html_e( 'Buscar en el sitio', 'vlac-systems' ); ?>
	</label>
	<span class="vlac-search-ic" aria-hidden="true">
		<svg width="17" height="17" viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.9"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="1.9" stroke-linecap="round"/></svg>
	</span>
	<input
		type="search"
		id="<?php echo esc_attr( $vlac_search_id ); ?>"
		class="vlac-search-input"
		name="s"
		value="<?php echo get_search_query(); ?>"
		placeholder="<?php esc_attr_e( 'Buscar módulos, industrias, precios…', 'vlac-systems' ); ?>"
		autocomplete="off"
	/>
	<button type="submit" class="vlac-search-btn"><?php esc_html_e( 'Buscar', 'vlac-systems' ); ?></button>
</form>
