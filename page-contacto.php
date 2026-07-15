<?php
/**
 * Template Name: Contacto
 *
 * Plantilla de la página de contacto. El formulario se inserta como
 * contenido de la página con el shortcode de Contact Form 7, por ejemplo:
 *   [contact-form-7 id="123" title="Contacto"]
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * que quieras (p. ej. «Contacto»), en «Atributos de página → Plantilla»
 * elige «Contacto», pega el shortcode de CF7 en el contenido y publica.
 *
 * @package Vlac_Systems
 */

get_header();

$img = get_template_directory_uri() . '/assets/img';
?>

<style>
	/* Estilos de la página de contacto (ámbito local). */
	#contacto-page{padding:64px 0 96px;background:linear-gradient(180deg,#fff,var(--bg-alt));}
	/* Columna izquierda: panel (fila 1) + medios (fila 2). El formulario abarca
	   ambas filas para que la altura de la fila 1 la marque el panel y no él;
	   si no, los medios se irían hasta debajo del formulario.
	   row-gap:0 porque cada medio ya trae su propio margen superior. */
	#contacto-page .contact-grid{display:grid;grid-template-columns:0.9fr 1.1fr;grid-template-rows:auto auto;column-gap:48px;row-gap:0;align-items:start;}
	#contacto-page .contact-aside{grid-column:1;grid-row:1;}
	#contacto-page .contact-media{grid-column:1;grid-row:2;}
	#contacto-page .contact-card{grid-column:2;grid-row:1 / span 2;}
	#contacto-page .contact-aside .sec-kicker{margin-bottom:14px;}
	#contacto-page .contact-aside h1{font-size:clamp(30px,3.6vw,44px);font-weight:800;}
	#contacto-page .contact-aside .lead{color:var(--muted);font-size:17px;margin-top:16px;max-width:440px;}
	#contacto-page .contact-points{margin-top:30px;display:flex;flex-direction:column;gap:16px;}
	#contacto-page .contact-point{display:flex;align-items:flex-start;gap:12px;}
	#contacto-page .contact-point svg{width:22px;height:22px;color:var(--red);flex-shrink:0;margin-top:2px;}
	#contacto-page .contact-point b{font-family:'Manrope',sans-serif;display:block;color:var(--ink-strong);font-size:15px;}
	#contacto-page .contact-point span{color:var(--muted);font-size:14px;}

	/* Área editable del panel izquierdo (texto y/o imagen). */
	#contacto-page .contact-aside-extra{margin-top:28px;color:var(--muted);font-size:15px;line-height:1.6;}
	#contacto-page .contact-aside-extra p{margin:0 0 12px;}
	#contacto-page .contact-aside-extra a{color:var(--red);font-weight:600;}
	#contacto-page .contact-aside-media{margin-top:28px;}
	#contacto-page .contact-aside-media img{width:100%;height:auto;border-radius:16px;border:1px solid var(--line);box-shadow:var(--shadow-sm);}

	/* Montaje de dispositivos (reutiliza .montage del hero) dentro del panel. */
	#contacto-page .contact-montage{margin-top:40px;min-height:auto;padding-bottom:40px;}
	#contacto-page .contact-montage .monitor{margin:0 auto;max-width:520px;}
	#contacto-page .contact-montage .tablet{left:0;width:210px;}
	#contacto-page .contact-montage .phone{right:0;width:118px;}

	#contacto-page .contact-card{background:#fff;border:1px solid var(--line);border-radius:20px;box-shadow:var(--shadow-md);padding:32px;}

	/* Contact Form 7 dentro de la tarjeta. */
	#contacto-page .wpcf7-form p{margin:0 0 18px;}
	#contacto-page .wpcf7-form label{display:block;margin:0;font-family:'Manrope',sans-serif;font-weight:600;font-size:14px;color:var(--ink-strong);}
	/* Elimina saltos de línea sobrantes de CF7 que separan la etiqueta del campo. */
	#contacto-page .wpcf7-form br{display:none;}
	#contacto-page .wpcf7-form .wpcf7-form-control-wrap{display:block;}
	#contacto-page .wpcf7-form input[type="text"],
	#contacto-page .wpcf7-form input[type="email"],
	#contacto-page .wpcf7-form input[type="tel"],
	#contacto-page .wpcf7-form input[type="url"],
	#contacto-page .wpcf7-form input[type="number"],
	#contacto-page .wpcf7-form textarea,
	#contacto-page .wpcf7-form select{
		width:100%;margin-top:7px;padding:12px 14px;font-family:'Inter',sans-serif;font-size:15px;
		color:var(--ink);background:#fff;border:1px solid var(--line);border-radius:10px;transition:border-color .16s,box-shadow .16s;
	}
	#contacto-page .wpcf7-form input:focus,
	#contacto-page .wpcf7-form textarea:focus,
	#contacto-page .wpcf7-form select:focus{outline:none;border-color:var(--red);box-shadow:0 0 0 3px rgba(193,39,45,.14);}
	#contacto-page .wpcf7-form textarea{min-height:130px;resize:vertical;}
	#contacto-page .wpcf7-form .wpcf7-submit{
		width:100%;margin-top:6px;background:var(--red);color:#fff;border:none;cursor:pointer;
		font-family:'Manrope',sans-serif;font-weight:700;font-size:16px;padding:15px 26px;border-radius:12px;
		box-shadow:0 6px 16px rgba(193,39,45,.28);transition:transform .16s,background .16s,box-shadow .16s;
	}
	#contacto-page .wpcf7-form .wpcf7-submit:hover{background:var(--red-dark);transform:translateY(-1px);box-shadow:0 10px 22px rgba(193,39,45,.34);}

	/* Texto introductorio y asteriscos de requerido. */
	#contacto-page .cf7-intro{color:var(--muted);font-size:15px;margin:0 0 26px;}
	#contacto-page .wpcf7-form .req{color:var(--red);}

	/* Filas de dos columnas (Correo/Teléfono y Segmento/Plan). */
	#contacto-page .cf7-row{display:grid;grid-template-columns:1fr 1fr;gap:18px;margin:0 0 18px;}
	#contacto-page .cf7-row > p{margin:0;}

	@media (max-width:860px){
		#contacto-page{padding-top:40px;}
		#contacto-page .contact-grid{grid-template-columns:1fr;grid-template-rows:none;row-gap:28px;}
		/* Se anula la colocación de escritorio y se ordena con `order`. */
		#contacto-page .contact-aside,
		#contacto-page .contact-media,
		#contacto-page .contact-card{grid-column:1;grid-row:auto;}
		/* En el teléfono el formulario sube justo debajo del título: nadie
		   debería tener que bajar la página para escribirnos. */
		#contacto-page .contact-aside{order:1;}
		#contacto-page .contact-card{order:2;}
		#contacto-page .contact-media{order:3;}
		/* El montaje de dispositivos es decorativo y ocupa muchísimo alto. */
		#contacto-page .contact-media.is-montage{display:none;}
		#contacto-page .contact-aside-media{margin-top:0;}
		#contacto-page .contact-aside .lead{margin-top:12px;}
		#contacto-page .contact-points{margin-top:22px;}
		#contacto-page .contact-card{padding:24px 20px;}
	}
	@media (max-width:520px){
		#contacto-page .cf7-row{grid-template-columns:1fr;}
	}
</style>

<section id="contacto-page">
	<div class="wrap">
		<div class="contact-grid">

			<div class="contact-aside">
				<div class="sec-kicker"><?php echo esc_html( vlac_opt( 'contact_kicker', 'Contacto' ) ); ?></div>
				<h1><?php the_title(); ?></h1>
				<p class="lead"><?php echo esc_html( vlac_opt( 'contact_lead', 'Cuéntanos sobre tu negocio y un asesor te contactará para activar tu prueba gratis o resolver tus dudas.' ) ); ?></p>

				<div class="contact-points">
					<?php if ( vlac_opt( 'contact_phone' ) ) : ?>
						<div class="contact-point">
							<svg viewBox="0 0 24 24" fill="none"><path d="M6.5 3h3l1.5 5-2 1.5a12 12 0 005.5 5.5l1.5-2 5 1.5v3a2 2 0 01-2 2A16 16 0 014.5 5a2 2 0 012-2z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
							<div><b><?php esc_html_e( 'Teléfono', 'vlac-systems' ); ?></b><span><?php echo esc_html( vlac_opt( 'contact_phone' ) ); ?></span></div>
						</div>
					<?php endif; ?>
					<?php if ( vlac_opt( 'contact_email' ) ) : ?>
						<div class="contact-point">
							<svg viewBox="0 0 24 24" fill="none"><path d="M3 6h18v12H3V6zm0 1l9 6 9-6" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
							<div><b><?php esc_html_e( 'Correo', 'vlac-systems' ); ?></b><span><?php echo esc_html( vlac_opt( 'contact_email' ) ); ?></span></div>
						</div>
					<?php endif; ?>
					<?php if ( vlac_opt( 'contact_hours' ) ) : ?>
						<div class="contact-point">
							<svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/><path d="M12 7v5l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
							<div><b><?php esc_html_e( 'Horario', 'vlac-systems' ); ?></b><span><?php echo esc_html( vlac_opt( 'contact_hours' ) ); ?></span></div>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( vlac_opt( 'contact_aside_text' ) ) : ?>
					<div class="contact-aside-extra"><?php echo wp_kses_post( wpautop( vlac_opt( 'contact_aside_text' ) ) ); ?></div>
				<?php endif; ?>
			</div>

			<div class="contact-card">
				<?php
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
				?>
			</div>

			<?php
			/*
			 * Bloque de medios: va fuera del panel para poder reordenarlo. En
			 * escritorio cae bajo el panel izquierdo; en el teléfono se manda
			 * debajo del formulario (y el montaje decorativo se oculta).
			 */
			$vlac_aside_img = vlac_opt( 'contact_aside_image' );
			?>
			<div class="contact-media <?php echo $vlac_aside_img ? 'is-image' : 'is-montage'; ?>">
				<?php if ( $vlac_aside_img ) : ?>
					<div class="contact-aside-media">
						<img src="<?php echo esc_url( $vlac_aside_img ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" loading="lazy" />
					</div>
				<?php else : ?>
					<div class="contact-montage montage" aria-hidden="true">
						<div class="monitor">
							<div class="screen">
								<div class="browserbar"><i></i><i></i><i></i><span class="url">app.tunegocio.com.gt</span></div>
								<img class="shot" src="<?php echo esc_url( $img . '/hero-monitor.jpg' ); ?>" alt="" loading="lazy" />
							</div>
							<div class="stand-neck"></div>
							<div class="stand"></div>
						</div>

						<div class="tablet">
							<span class="badge">Factura FEL</span>
							<div class="tscreen"><img class="shot" src="<?php echo esc_url( $img . '/hero-tablet.png' ); ?>" alt="" loading="lazy" /></div>
						</div>

						<div class="phone">
							<div class="pscreen"><img class="shot" src="<?php echo esc_url( $img . '/hero-phone.png' ); ?>" alt="" loading="lazy" /></div>
						</div>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>

<?php
get_footer();
