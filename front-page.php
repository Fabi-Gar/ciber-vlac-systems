<?php
/**
 * Plantilla de la portada (landing page).
 *
 * @package Vlac_Systems
 */

get_header();

$img = get_template_directory_uri() . '/assets/img';
?>

<!-- HERO -->
<section class="hero">
	<div class="wrap">
		<div class="hero-grid">
			<div class="hero-copy">
				<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'hero_eyebrow', 'ERP + Facturación Electrónica para Guatemala' ) ); ?></span>
				<h1><?php echo wp_kses_post( vlac_opt( 'hero_title', 'Tu <span class="accent">ERP</span> con tu <span class="accent">Identidad</span>, y el Facturador <span class="accent">FEL</span> que necesitas.' ) ); ?></h1>
				<p class="hero-sub"><?php echo esc_html( vlac_opt( 'hero_sub', 'Potencia tu negocio con una solución integral personalizada. Incluye Facturador FEL (Guatemala), dominio personalizado y almacenamiento en la nube.' ) ); ?></p>
				<div class="hero-cta">
					<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
					<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
				</div>
				<div class="hero-note">
					<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
					<?php echo esc_html( vlac_opt( 'hero_note', 'Sin tarjeta de crédito · Certificado ante la SAT · Soporte local' ) ); ?>
				</div>
			</div>

			<!-- MONTAJE DE DISPOSITIVOS -->
			<div class="montage" aria-label="<?php esc_attr_e( 'Vlac Systems en monitor, tablet y smartphone', 'vlac-systems' ); ?>">
				<div class="monitor">
					<div class="screen">
						<div class="browserbar"><i></i><i></i><i></i><span class="url">app.tunegocio.com.gt</span></div>
						<img class="shot" src="<?php echo esc_url( $img . '/hero-monitor.jpg' ); ?>" alt="<?php esc_attr_e( 'Panel ERP de Vlac Systems: módulo de Cajas y operaciones', 'vlac-systems' ); ?>" />
					</div>
					<div class="stand-neck"></div>
					<div class="stand"></div>
				</div>

				<div class="tablet">
					<span class="badge">Factura FEL</span>
					<div class="tscreen"><img class="shot" src="<?php echo esc_url( $img . '/hero-tablet.png' ); ?>" alt="<?php esc_attr_e( 'Factura electrónica FEL certificada ante la SAT emitida desde Vlac Systems', 'vlac-systems' ); ?>" /></div>
				</div>

				<div class="phone">
					<div class="pscreen"><img class="shot" src="<?php echo esc_url( $img . '/hero-phone.png' ); ?>" alt="<?php esc_attr_e( 'App móvil de Vlac Systems: punto de venta y cotización', 'vlac-systems' ); ?>" /></div>
				</div>
			</div>
		</div>
	</div>

	<div class="wrap">
		<div class="trust">
			<b>Confiado por negocios en Guatemala</b>
			<span class="sep"></span> Comercios &amp; Restaurantes
			<span class="sep"></span> Clínicas &amp; Veterinarias
			<span class="sep"></span> Talleres &amp; Distribuidores
		</div>
	</div>
</section>

<!-- FEATURES -->
<section class="section section-alt" id="caracteristicas">
	<div class="wrap">
		<div class="sec-head">
			<div class="sec-kicker">Puntos importantes</div>
			<h2>Todo lo que tu negocio necesita, en un solo lugar</h2>
			<p>Una plataforma que cumple con la ley local y refleja la marca de tu empresa.</p>
		</div>
		<div class="feat-grid">
			<div class="feat">
				<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l3 3v15l-2-1.4L14 21l-2-1.4L10 21l-2-1.4L6 21V3z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M9 8h6M9 12h6M9 16h3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
				<h3>Facturador FEL</h3>
				<p>Cumplimiento local garantizado para Guatemala, certificado ante la SAT.</p>
			</div>
			<div class="feat">
				<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3a9 9 0 100 18c1.7 0 2-1.3 1.2-2.2-.8-1 .1-2.3 1.4-2.3H17a4 4 0 004-4c0-5-4-9.5-9-9.5z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><circle cx="7.5" cy="11" r="1.2" fill="currentColor"/><circle cx="11" cy="7.5" r="1.2" fill="currentColor"/><circle cx="15" cy="8.5" r="1.2" fill="currentColor"/></svg></div>
				<h3>Tu ERP, Tu Identidad</h3>
				<p>Branding completo: logo, colores y documentos personalizados con tu marca.</p>
			</div>
			<div class="feat">
				<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M3 12h18M12 3c2.5 2.5 2.5 15 0 18M12 3c-2.5 2.5-2.5 15 0 18" stroke="currentColor" stroke-width="1.5"/></svg></div>
				<h3>Dominio Personalizado</h3>
				<p>Tu negocio con su propio nombre en internet y acceso seguro.</p>
			</div>
			<div class="feat">
				<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M7 18a4 4 0 01-.5-8A6 6 0 0118 9.5a3.5 3.5 0 01-1 6.9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><rect x="9" y="14" width="6" height="7" rx="1.4" stroke="currentColor" stroke-width="1.7"/></svg></div>
				<h3>Nube y App móvil</h3>
				<p>Datos seguros y acceso desde tu teléfono o tableta, donde estés.</p>
			</div>
		</div>
	</div>
</section>

<!-- NEGOCIOS QUE CONFÍAN (carrusel) -->
<?php
$vlac_businesses = vlac_get_businesses();
if ( ! empty( $vlac_businesses ) ) :
	// Se duplica la lista para lograr un bucle continuo sin saltos.
	$vlac_marquee = array_merge( $vlac_businesses, $vlac_businesses );
	?>
	<section class="section marquee-sec" id="negocios" aria-labelledby="negocios-title">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker"><?php esc_html_e( 'Casos de éxito', 'vlac-systems' ); ?></div>
				<h2 id="negocios-title"><?php echo esc_html( vlac_opt( 'marquee_title', 'Negocios de todo el país confían en Vlac Systems' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'marquee_sub', 'Desde restaurantes y clínicas hasta talleres y comercios: cientos de negocios ya facturan con nosotros.' ) ); ?></p>
			</div>
		</div>

		<div class="marquee" role="region" aria-label="<?php esc_attr_e( 'Negocios que usan Vlac Systems', 'vlac-systems' ); ?>">
			<div class="marquee-track">
				<?php foreach ( $vlac_marquee as $i => $biz ) : ?>
					<div class="marquee-item"<?php echo ( $i >= count( $vlac_businesses ) ) ? ' aria-hidden="true"' : ''; ?>>
						<img
							src="<?php echo esc_url( $biz['logoUrl'] ); ?>"
							alt="<?php echo esc_attr( $biz['name'] ); ?>"
							loading="lazy"
							decoding="async"
							width="120"
							height="120"
						/>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- INDUSTRIES -->
<section class="section" id="industrias">
	<div class="wrap">
		<div class="ind-grid">
			<div class="ind-left">
				<div class="sec-kicker">Industrias · Restaurantes</div>
				<h2>Personalizado para tu forma de trabajar</h2>
				<p>Un vistazo a cómo Vlac Systems se adapta a un restaurante. Cada industria recibe su propio flujo de trabajo.</p>
				<div class="ind-cards">
					<div class="ind-card">
						<div class="ind-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="12" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 20h8M12 16v4M7 8h6M7 11h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<div><h4>Comandas en pantalla</h4><p>Pedidos que llegan directo a cocina, sin papel ni errores.</p></div>
					</div>
					<div class="ind-card">
						<div class="ind-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/><circle cx="8" cy="8" r="2" stroke="currentColor" stroke-width="1.6"/><circle cx="16" cy="8" r="2" stroke="currentColor" stroke-width="1.6"/><circle cx="8" cy="16" r="2" stroke="currentColor" stroke-width="1.6"/><circle cx="16" cy="16" r="2" stroke="currentColor" stroke-width="1.6"/></svg></div>
						<div><h4>Mapa de mesas</h4><p>Vista de planta en tiempo real: mesas libres, ocupadas y por cobrar.</p></div>
					</div>
					<div class="ind-card">
						<div class="ind-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="6" cy="18" r="2.4" stroke="currentColor" stroke-width="1.7"/><circle cx="18" cy="18" r="2.4" stroke="currentColor" stroke-width="1.7"/><path d="M8.4 18h5l1-6H6l.7 3M13 8h3l2 4M13 8l1 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<div><h4>Delivery</h4><p>Gestión de repartos y seguimiento del repartidor de principio a fin.</p></div>
					</div>
				</div>
			</div>

			<div class="floor" aria-label="<?php esc_attr_e( 'Mapa de mesas real de Vlac Systems', 'vlac-systems' ); ?>">
				<div class="floor-top"><div class="ft">Mapa de mesas — en vivo</div><div class="fs"><span class="live-dot"></span>En tiempo real</div></div>
				<div class="floor-bar"><i></i><i></i><i></i></div>
				<div class="floor-shot"><img src="<?php echo esc_url( $img . '/floor-map.png' ); ?>" alt="<?php esc_attr_e( 'Mapa de mesas de un restaurante en Vlac Systems: áreas Adentro, Pérgola, Jardín y mesas por zona', 'vlac-systems' ); ?>" /></div>
			</div>
		</div>
	</div>
</section>

<!-- CTA -->
<section class="section" style="padding-top:0;">
	<div class="wrap">
		<div class="cta-strip">
			<h2><?php echo esc_html( vlac_opt( 'cta_title', 'Empieza con tu ERP personalizado hoy' ) ); ?></h2>
			<p><?php echo esc_html( vlac_opt( 'cta_sub', 'Configura tu marca, activa tu Facturador FEL y comienza a facturar en minutos.' ) ); ?></p>
			<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'cta_btn_txt', 'Prueba gratis' ) ); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();
