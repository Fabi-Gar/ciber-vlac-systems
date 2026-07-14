<?php
/**
 * Cabecera del sitio.
 *
 * @package Vlac_Systems
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- HEADER -->
<header>
	<div class="wrap">
		<nav class="nav" aria-label="<?php esc_attr_e( 'Principal', 'vlac-systems' ); ?>">

			<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> inicio">
				<span class="logo-chip">
					<?php
					if ( has_custom_logo() ) {
						$logo_id  = get_theme_mod( 'custom_logo' );
						$logo_src = wp_get_attachment_image_src( $logo_id, 'full' );
						if ( $logo_src ) {
							printf(
								'<img src="%s" alt="%s" />',
								esc_url( $logo_src[0] ),
								esc_attr( get_bloginfo( 'name' ) )
							);
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
				<span class="logo-text">
					<span class="l1"><b>Ciber</b> Vlac Systems</span>
					<span class="l2"><?php esc_html_e( 'Sociedad Anónima', 'vlac-systems' ); ?></span>
				</span>
			</a>

			<div class="menu">
				<div class="menu-item">
					<button class="menu-link" aria-haspopup="true" aria-expanded="false">
						Aplicaciones
						<svg class="chev" width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
					<div class="mega" role="menu">
						<div class="mega-grid">
							<div class="mega-col">
								<h5>Facturación y ventas</h5>
								<a href="<?php echo esc_url( home_url( '/facturacion/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M6 3h9l3 3v15l-2-1.4L14 21l-2-1.4L10 21l-2-1.4L6 21V3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 8h6M9 12h6M9 16h3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>Facturador FEL</a>
								<a href="<?php echo esc_url( home_url( '/ventas-clientes/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Gestión de ventas y clientes</a>
								<a href="<?php echo esc_url( home_url( '/contratos/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M4 20h16M6 16l8-8 3 3-8 8H6v-3z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Gestión de contratos</a>
							</div>
							<div class="mega-col">
								<h5>Compras e inventario</h5>
								<a href="<?php echo esc_url( home_url( '/compras-proveedores/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M3 7h11v8H3zM14 10h4l3 3v2h-7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="7" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/><circle cx="17.5" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/></svg>Gestión de compras y proveedores</a>
								<a href="<?php echo esc_url( home_url( '/inventario/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>Gestión de inventario y productos</a>
							</div>
							<div class="mega-col">
								<h5>Finanzas e informes</h5>
								<a href="<?php echo esc_url( home_url( '/financiera/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Gestión financiera</a>
								<a href="#"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>Informes</a>
							</div>
							<div class="mega-col">
								<h5>Administración</h5>
								<a href="<?php echo esc_url( home_url( '/usuarios/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M2 21a7 7 0 0114 0M16 11l2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Gestión de usuarios</a>
								<a href="<?php echo esc_url( home_url( '/sucursales/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M3 21V9l9-6 9 6v12M3 21h18M9 21v-6h6v6M7 12h.01M12 12h.01M17 12h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>Múltiples sucursales</a>
							</div>
						</div>
						<div class="mega-foot">
							<p><strong>Todo en una sola plataforma.</strong> Con la marca y el flujo de tu negocio.</p>
							<a class="btn btn-red" href="<?php echo esc_url( vlac_cta_url( 'hdr_cta_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hdr_cta_txt', 'Prueba gratis' ) ); ?></a>
						</div>
					</div>
				</div>
				<div class="menu-item">
					<button class="menu-link" aria-haspopup="true" aria-expanded="false">
						Industrias
						<svg class="chev" width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</button>
					<div class="mega" role="menu">
						<div class="mega-grid">
							<div class="mega-col">
								<h5>Venta minorista</h5>
								<a href="<?php echo esc_url( home_url( '/industrias/punto-de-venta/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M4 7h16l-1 12H5L4 7zM8 7V5a4 4 0 018 0v2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>Punto de venta</a>
								<a href="<?php echo esc_url( home_url( '/industrias/venta-de-ropa/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M8 4l-4 5 3 2v9h10v-9l3-2-4-5-3 2-1-1-1 1-3-2z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>Venta de ropa</a>
								<a href="<?php echo esc_url( home_url( '/industrias/ferreteria-y-vidrieria/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M6 9V6a2 2 0 012-2h2v6M14 4h2a2 2 0 012 2v3M4 9h16v11H4V9z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>Ferretería y vidriería</a>
							</div>
							<div class="mega-col">
								<h5>Alimentos y hospitalidad</h5>
								<a href="<?php echo esc_url( home_url( '/industrias/restaurantes/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M5 3v7a2 2 0 002 2v9M9 3v9M7 3v4M19 3c-2 0-3 3-3 6h3V3zm0 9v9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>Bar y Restaurantes</a>
								<a href="<?php echo esc_url( home_url( '/industrias/hoteles/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M3 21V8l9-4 9 4v13M3 21h18M9 21v-6h6v6M7 11h.01M12 11h.01M17 11h.01" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Hoteles</a>
							</div>
							<div class="mega-col">
								<h5>Servicios profesionales</h5>
								<a href="<?php echo esc_url( home_url( '/industrias/clinicas-y-hospitales/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M12 3v18M3 12h18M8 6h8v4H8zM8 14h8v4H8z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>Clínicas y hospitales</a>
								<a href="<?php echo esc_url( home_url( '/industrias/veterinarias/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M12 12a3 3 0 100-6 3 3 0 000 6zM5 21c0-3.9 3.1-7 7-7s7 3.1 7 7M6 6a2 2 0 11-2-2M20 4a2 2 0 11-2 2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>Veterinarias</a>
								<a href="<?php echo esc_url( home_url( '/industrias/talleres/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M14 6l4 4-8 8H6v-4l8-8zM13 7l4 4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>Talleres</a>
							</div>
							<div class="mega-col">
								<h5>Distribución</h5>
								<a href="<?php echo esc_url( home_url( '/industrias/venta-de-repuestos/' ) ); ?>"><svg class="ic" viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg>Venta de repuestos</a>
							</div>
						</div>
						<div class="mega-foot">
							<p><strong>¿No ves tu industria?</strong> Adaptamos Vlac Systems a tu operación.</p>
							<a class="btn btn-red" href="<?php echo esc_url( vlac_cta_url( 'hdr_asesor_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hdr_asesor_txt', 'Hablar con un asesor' ) ); ?></a>
						</div>
					</div>
				</div>
				<div class="menu-item"><a class="menu-link" href="#">Precios</a></div>
				<div class="menu-item"><a class="menu-link" href="<?php echo esc_url( vlac_contact_url() ); ?>">Ayuda</a></div>
				<div class="menu-item"><a class="menu-link" href="<?php echo esc_url( vlac_clients_url() ); ?>">Nuestros clientes</a></div>
			</div>

			<div class="nav-right">
				<a class="btn btn-red" href="<?php echo esc_url( vlac_cta_url( 'hdr_cta_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hdr_cta_txt', 'Prueba gratis' ) ); ?></a>
			</div>
			<button class="burger" id="burger" aria-label="<?php esc_attr_e( 'Abrir menú', 'vlac-systems' ); ?>" aria-expanded="false"><span></span><span></span><span></span></button>
		</nav>
	</div>
</header>

<!-- MOBILE PANEL -->
<div class="mobile-panel" id="mobilePanel">
	<button class="m-acc-head" aria-expanded="false">Aplicaciones
		<svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
	</button>
	<div class="m-acc-body">
		<h6>Facturación y ventas</h6>
		<a href="<?php echo esc_url( home_url( '/facturacion/' ) ); ?>">Facturador FEL</a><a href="<?php echo esc_url( home_url( '/ventas-clientes/' ) ); ?>">Gestión de ventas y clientes</a><a href="<?php echo esc_url( home_url( '/contratos/' ) ); ?>">Gestión de contratos</a>
		<h6>Compras e inventario</h6>
		<a href="<?php echo esc_url( home_url( '/compras-proveedores/' ) ); ?>">Gestión de compras y proveedores</a><a href="<?php echo esc_url( home_url( '/inventario/' ) ); ?>">Gestión de inventario y productos</a>
		<h6>Finanzas e informes</h6>
		<a href="<?php echo esc_url( home_url( '/financiera/' ) ); ?>">Gestión financiera</a><a href="#">Informes</a>
		<h6>Administración</h6>
		<a href="<?php echo esc_url( home_url( '/usuarios/' ) ); ?>">Gestión de usuarios</a><a href="<?php echo esc_url( home_url( '/sucursales/' ) ); ?>">Múltiples sucursales</a>
	</div>
	<button class="m-acc-head" id="mAcc">Industrias
		<svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
	</button>
	<div class="m-acc-body" id="mAccBody">
		<h6>Venta minorista</h6>
		<a href="<?php echo esc_url( home_url( '/industrias/punto-de-venta/' ) ); ?>">Punto de venta</a><a href="<?php echo esc_url( home_url( '/industrias/venta-de-ropa/' ) ); ?>">Venta de ropa</a><a href="<?php echo esc_url( home_url( '/industrias/ferreteria-y-vidrieria/' ) ); ?>">Ferretería y vidriería</a>
		<h6>Alimentos y hospitalidad</h6>
		<a href="<?php echo esc_url( home_url( '/industrias/restaurantes/' ) ); ?>">Bar y Restaurantes</a><a href="<?php echo esc_url( home_url( '/industrias/hoteles/' ) ); ?>">Hoteles</a>
		<h6>Servicios profesionales</h6>
		<a href="<?php echo esc_url( home_url( '/industrias/clinicas-y-hospitales/' ) ); ?>">Clínicas y hospitales</a><a href="<?php echo esc_url( home_url( '/industrias/veterinarias/' ) ); ?>">Veterinarias</a><a href="<?php echo esc_url( home_url( '/industrias/talleres/' ) ); ?>">Talleres</a>
		<h6>Distribución</h6>
		<a href="<?php echo esc_url( home_url( '/industrias/venta-de-repuestos/' ) ); ?>">Venta de repuestos</a>
	</div>
	<a class="m-link" href="#">Precios</a>
	<a class="m-link" href="<?php echo esc_url( vlac_contact_url() ); ?>">Ayuda</a>
	<a class="m-link" href="<?php echo esc_url( vlac_clients_url() ); ?>">Nuestros clientes</a>
	<div class="mobile-cta">
		<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hdr_cta_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hdr_cta_txt', 'Prueba gratis' ) ); ?></a>
	</div>
</div>
