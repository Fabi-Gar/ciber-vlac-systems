<?php
/**
 * Pie de página del sitio.
 *
 * @package Vlac_Systems
 */
?>

<!-- FOOTER -->
<footer>
	<div class="wrap">
		<div class="foot-grid">
			<div class="foot-brand">
				<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="logo-chip">
						<?php
						if ( has_custom_logo() ) {
							$logo_id  = get_theme_mod( 'custom_logo' );
							$logo_src = wp_get_attachment_image_src( $logo_id, 'full' );
							if ( $logo_src ) {
								printf( '<img src="%s" alt="%s" />', esc_url( $logo_src[0] ), esc_attr( get_bloginfo( 'name' ) ) );
							}
						} else {
							printf(
								'<img src="%s" alt="%s" />',
								esc_url( get_template_directory_uri() . '/assets/img/logo.png' ),
								esc_attr__( 'Logo Ciber Vlac Systems', 'vlac-systems' )
							);
						}
						?>
					</span>
					<span class="logo-text"><span class="l1"><b>Ciber</b> Vlac Systems</span><span class="l2"><?php esc_html_e( 'Sociedad Anónima', 'vlac-systems' ); ?></span></span>
				</a>
				<p><?php echo esc_html( vlac_opt( 'foot_desc', 'ERP personalizado con Facturación Electrónica FEL para negocios en Guatemala.' ) ); ?></p>
			</div>

			<div class="foot-col">
				<h5>Producto</h5>
				<?php
				if ( has_nav_menu( 'footer_prod' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer_prod',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				} else {
					echo '<a href="#">Aplicaciones</a><a href="#">Facturador FEL</a><a href="#">Precios</a><a href="#">App móvil</a>';
				}
				?>
			</div>

			<div class="foot-col">
				<h5>Industrias</h5>
				<?php
				if ( has_nav_menu( 'footer_ind' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer_ind',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				} else {
					echo '<a href="#">Restaurantes</a><a href="#">Punto de venta</a><a href="#">Clínicas</a><a href="#">Talleres</a>';
				}
				?>
			</div>

			<div class="foot-col">
				<h5>Empresa</h5>
				<?php
				if ( has_nav_menu( 'footer_emp' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'footer_emp',
							'container'      => false,
							'items_wrap'     => '%3$s',
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				} else {
					printf(
						'<a href="%s">%s</a>',
						esc_url( vlac_clients_url() ),
						esc_html__( 'Nuestros clientes', 'vlac-systems' )
					);
				}
				?>
			</div>
		</div>

		<div class="foot-bottom">
			<span><?php echo esc_html( vlac_opt( 'foot_copy', '© ' . date( 'Y' ) . ' Ciber Vlac Systems S.A. Todos los derechos reservados.' ) ); ?></span>
			<span><?php echo esc_html( vlac_opt( 'foot_legal', 'Guatemala · Certificado ante la SAT' ) ); ?></span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
