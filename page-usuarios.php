<?php
/**
 * Template Name: Gestión de Usuarios
 *
 * Página de producto del módulo de Gestión de Usuarios.
 * Muestra el listado de usuarios divididos por roles y sucursales, la ficha
 * con sus permisos, la creación de usuarios, la eliminación y el habilitar /
 * deshabilitar accesos.
 *
 * IMÁGENES (elígelas en el Personalizador o guárdalas en /assets/img/ con
 * estos nombres exactos):
 *   usr-listado.png      → Listado de usuarios con sus roles (captura 1)
 *   usr-ficha.png        → Ficha y permisos por sucursal (captura 2)
 *   usr-crear.png        → Crear un usuario (captura 3)
 *   usr-eliminar.png     → Confirmación de eliminación (captura 4)
 *   usr-deshabilitar.png → Confirmación de deshabilitar (captura 5)
 *   usr-hero.png         → (opcional) imagen destacada del hero
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Gestión de Usuarios» y el slug «usuarios», y en «Atributos de página →
 * Plantilla» elige «Gestión de Usuarios». No necesita contenido. Los textos
 * y los medios se editan en Apariencia → Personalizar → Contenido del sitio →
 * «Página Gestión de Usuarios».
 *
 * @package Vlac_Systems
 */

get_header();

$img     = get_template_directory_uri() . '/assets/img';
$img_dir = get_template_directory() . '/assets/img/';

// Renderiza una captura enmarcada. Prioridad de la imagen:
//   1) La elegida en el Personalizador (Biblioteca de medios de WordPress).
//   2) El archivo en /assets/img/.
//   3) Un marcador con las instrucciones.
$usr_shot = function ( $file, $caption, $opt_key = '' ) use ( $img, $img_dir ) {
	$url    = $opt_key ? vlac_opt( $opt_key ) : '';
	$exists = file_exists( $img_dir . $file );
	echo '<figure class="usr-shot"><div class="usr-frame"><div class="bar"><i></i><i></i><i></i></div>';
	if ( $url ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $url ), esc_attr( $caption ) );
	} elseif ( $exists ) {
		printf( '<img src="%s" alt="%s" loading="lazy" />', esc_url( $img . '/' . $file ), esc_attr( $caption ) );
	} else {
		printf( '<div class="usr-ph usr-ph-img">Elige la imagen en <b>Personalizar → Página Gestión de Usuarios</b><br>o sube <code>assets/img/%s</code></div>', esc_html( $file ) );
	}
	echo '</div>';
	if ( $caption ) {
		printf( '<figcaption>%s</figcaption>', esc_html( $caption ) );
	}
	echo '</figure>';
};

?>

<style>
	/* Estilos de la página de Gestión de Usuarios (ámbito local). */
	#usr-page{--usr-green:#2e9e5b;--usr-amber:#e0a800;}

	/* HERO */
	#usr-page .usr-hero{position:relative;overflow:hidden;}
	#usr-page .usr-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(700px 380px at 82% 8%,rgba(193,39,45,.07),transparent 60%),linear-gradient(180deg,#fff,var(--bg-alt));}
	#usr-page .usr-hero .hero-grid{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1.12fr;gap:48px;align-items:center;padding:66px 0 84px;}
	#usr-page .usr-hero h1{font-size:clamp(32px,4.4vw,50px);font-weight:800;}
	#usr-page .usr-hero .lead{color:var(--muted);font-size:18px;margin:20px 0 8px;max-width:520px;}
	#usr-page .usr-hero .hero-cta{display:flex;gap:14px;flex-wrap:wrap;margin-top:28px;}
	#usr-page .usr-hero .hero-note{display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--muted);margin-top:22px;}
	#usr-page .usr-hero .hero-note svg{width:16px;height:16px;color:var(--usr-green);}

	/* Métricas rápidas bajo el hero */
	#usr-page .usr-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:34px;max-width:540px;}
	#usr-page .usr-stat{background:#fff;border:1px solid var(--line);border-radius:12px;padding:16px 18px;box-shadow:var(--shadow-sm);}
	#usr-page .usr-stat b{display:block;font-family:'Manrope';font-weight:800;font-size:21px;color:var(--red);line-height:1;}
	#usr-page .usr-stat span{display:block;color:var(--muted);font-size:12.5px;margin-top:7px;}

	/* MARCO (estilo navegador) para las capturas */
	#usr-page .usr-frame{background:#fff;border:1px solid #d9d9de;border-radius:14px;overflow:hidden;box-shadow:var(--shadow-md);}
	#usr-page .usr-frame .bar{display:flex;align-items:center;gap:6px;padding:9px 12px;background:#f3f3f5;border-bottom:1px solid #e6e6ea;}
	#usr-page .usr-frame .bar i{width:10px;height:10px;border-radius:50%;background:#d6d6dc;display:block;}
	#usr-page .usr-frame img{width:100%;height:auto;display:block;background:#000;}
	#usr-page .usr-hero .usr-frame{box-shadow:var(--shadow-lg);}

	/* Marcador (placeholder) */
	#usr-page .usr-ph{aspect-ratio:16/10;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;text-align:center;background:var(--bg-alt);color:var(--muted);padding:24px;font-size:14px;}
	#usr-page .usr-ph svg{width:46px;height:46px;color:#c9c9d0;}
	#usr-page .usr-ph b{font-family:'Manrope';font-weight:700;color:var(--ink-strong);font-size:15px;}
	#usr-page .usr-ph code{font-size:13px;color:var(--red-dark);background:var(--red-soft);padding:4px 10px;border-radius:6px;}
	#usr-page .usr-ph-img{aspect-ratio:auto;padding:52px 20px;}

	/* ROLES: fichas tipo credencial */
	#usr-page .usr-roles{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;}
	#usr-page .usr-role{background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:22px 20px;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;}
	#usr-page .usr-role:hover{transform:translateY(-4px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#usr-page .usr-role .usr-ic{width:46px;height:46px;border-radius:12px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:14px;}
	#usr-page .usr-role .usr-ic svg{width:23px;height:23px;color:var(--red);}
	#usr-page .usr-role h3{font-size:15.5px;font-weight:700;margin-bottom:6px;}
	#usr-page .usr-role p{color:var(--muted);font-size:13.5px;}

	/* FILAS ALTERNADAS (texto + imagen juntos) */
	#usr-page .usr-rows{display:flex;flex-direction:column;gap:60px;}
	#usr-page .usr-row{display:grid;grid-template-columns:1fr 1.15fr;gap:46px;align-items:center;}
	#usr-page .usr-row.reverse .usr-row-text{order:2;}
	#usr-page .usr-row.reverse .usr-row-media{order:1;}
	#usr-page .usr-row-text .usr-ic{width:52px;height:52px;border-radius:13px;background:var(--red-soft);display:grid;place-items:center;margin-bottom:18px;}
	#usr-page .usr-row-text .usr-ic svg{width:26px;height:26px;color:var(--red);}
	#usr-page .usr-row-text h3{font-size:clamp(20px,2.4vw,26px);font-weight:800;}
	#usr-page .usr-row-text p{color:var(--muted);font-size:16.5px;margin-top:14px;max-width:430px;}
	#usr-page .usr-row-text .usr-list{list-style:none;margin:18px 0 0;padding:0;display:flex;flex-direction:column;gap:10px;max-width:430px;}
	#usr-page .usr-row-text .usr-list li{display:flex;align-items:flex-start;gap:10px;color:var(--ink-strong);font-size:15px;}
	#usr-page .usr-row-text .usr-list svg{width:19px;height:19px;color:var(--usr-green);flex-shrink:0;margin-top:1px;}

	/* Variantes de acento para acciones sensibles */
	#usr-page .usr-row-text.is-danger .usr-ic{background:#ffe8ec;}
	#usr-page .usr-row-text.is-danger .usr-ic svg{color:#e11d48;}
	#usr-page .usr-row-text.is-warn .usr-ic{background:#fff5d6;}
	#usr-page .usr-row-text.is-warn .usr-ic svg{color:var(--usr-amber);}

	@media (max-width:980px){
		#usr-page .usr-roles{grid-template-columns:repeat(2,1fr);}
	}
	@media (max-width:900px){
		#usr-page .usr-hero .hero-grid{grid-template-columns:1fr;gap:34px;padding:52px 0 56px;}
		#usr-page .usr-stats{max-width:none;}
		#usr-page .usr-row{grid-template-columns:1fr;gap:22px;}
		#usr-page .usr-row.reverse .usr-row-text{order:0;}
		#usr-page .usr-row.reverse .usr-row-media{order:0;}
	}
	@media (max-width:560px){
		#usr-page .usr-stats{grid-template-columns:1fr;}
		#usr-page .usr-roles{grid-template-columns:1fr;}
	}
</style>

<div id="usr-page">

	<!-- HERO -->
	<section class="usr-hero">
		<div class="wrap">
			<div class="hero-grid">
				<div class="hero-copy">
					<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'usr_eyebrow', 'Gestión de Usuarios' ) ); ?></span>
					<h1><?php echo wp_kses_post( vlac_opt( 'usr_title', 'Cada persona con su <span class="accent">rol</span> y sus <span class="accent">permisos</span>' ) ); ?></h1>
					<p class="lead"><?php echo esc_html( vlac_opt( 'usr_sub', 'Crea usuarios, asígnales roles por sucursal, y habilita, deshabilita o elimina accesos cuando lo necesites. Tu equipo, bajo control.' ) ); ?></p>
					<div class="hero-cta">
						<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hero_cta1_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
						<a class="btn btn-ghost" href="<?php echo esc_url( vlac_opt( 'hero_cta2_url', '#' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta2_txt', 'Ver una demo' ) ); ?></a>
					</div>
					<div class="hero-note">
						<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
						Roles por sucursal · Permisos por tipo · Altas y bajas al instante
					</div>

					<div class="usr-stats">
						<div class="usr-stat"><b>Por rol</b><span>Administrador, cajero, bodeguero y más</span></div>
						<div class="usr-stat"><b>Por sucursal</b><span>Permisos distintos en cada una</span></div>
						<div class="usr-stat"><b>1 clic</b><span>Habilita o deshabilita el acceso</span></div>
					</div>
				</div>

				<div class="usr-visual">
					<?php
					$usr_hero_key  = vlac_opt( 'usr_img_hero' ) ? 'usr_img_hero' : 'usr_img_listado';
					$usr_hero_file = file_exists( $img_dir . 'usr-hero.png' ) ? 'usr-hero.png' : 'usr-listado.png';
					$usr_shot( $usr_hero_file, '', $usr_hero_key );
					?>
				</div>
			</div>
		</div>
	</section>

	<!-- ROLES -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Roles</div>
				<h2>Un rol para cada función de tu negocio</h2>
				<p>Asigna a cada usuario el rol que le toca —y hazlo distinto en cada sucursal si lo necesitas.</p>
			</div>

			<div class="usr-roles">
				<div class="usr-role">
					<div class="usr-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M2 21a7 7 0 0114 0M16 11l2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Administrador</h3>
					<p>Acceso completo a la operación y la configuración.</p>
				</div>
				<div class="usr-role">
					<div class="usr-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="3" y="6" width="18" height="12" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M3 10h18M7 15h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Cajero</h3>
					<p>Cobra, factura y cierra su caja del turno.</p>
				</div>
				<div class="usr-role">
					<div class="usr-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/></svg></div>
					<h3>Bodeguero</h3>
					<p>Controla existencias, conteos y traslados.</p>
				</div>
				<div class="usr-role">
					<div class="usr-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16l-1 12H5L4 7zM8 7V5a4 4 0 018 0v2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Vendedor</h3>
					<p>Toma órdenes y suma a sus comisiones.</p>
				</div>
				<div class="usr-role">
					<div class="usr-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M3 7h11v8H3zM14 10h4l3 3v2h-7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="7" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/><circle cx="17.5" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/></svg></div>
					<h3>Repartidor</h3>
					<p>Entrega pedidos a domicilio y confirma la entrega.</p>
				</div>
				<div class="usr-role">
					<div class="usr-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Sub bodeguero</h3>
					<p>Apoya en bodega con permisos acotados.</p>
				</div>
				<div class="usr-role">
					<div class="usr-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l3 3v15l-2-1.4L14 21l-2-1.4L10 21l-2-1.4L6 21V3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 8h6M9 12h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg></div>
					<h3>Facturación</h3>
					<p>Emite y consulta los DTE de la sucursal.</p>
				</div>
				<div class="usr-role">
					<div class="usr-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></div>
					<h3>Roles a tu medida</h3>
					<p>Combina roles y tipos según tu operación.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- USUARIOS POR ROLES: LISTADO Y FICHA -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Usuarios y permisos</div>
				<h2>Todo tu equipo, dividido por roles</h2>
				<p>Del listado completo a la ficha con los permisos de cada persona en cada sucursal.</p>
			</div>

			<div class="usr-rows">
				<div class="usr-row">
					<div class="usr-row-text">
						<div class="usr-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Listado por roles</h3>
						<p>Cada usuario con su foto, nombre, login y alias, y las etiquetas de su rol en cada sucursal a simple vista. Busca por nombre y filtra por habilitados.</p>
						<ul class="usr-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Roles visibles por sucursal en la misma fila</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Búsqueda y filtro de habilitados / deshabilitados</li>
						</ul>
					</div>
					<div class="usr-row-media"><?php $usr_shot( 'usr-listado.png', '', 'usr_img_listado' ); ?></div>
				</div>

				<div class="usr-row reverse">
					<div class="usr-row-text">
						<div class="usr-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="3" width="16" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 8h8M8 12h8M8 16h5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
						<h3>Permisos por sucursal</h3>
						<p>Abre la ficha y define, sucursal por sucursal, el rol y el tipo de cada usuario. Con sus datos —nombre, alias, NIT, teléfono, correo y login— y quién lo creó.</p>
						<ul class="usr-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Rol y tipo distintos en cada sucursal</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Trazabilidad: creado por y creado en</li>
						</ul>
					</div>
					<div class="usr-row-media"><?php $usr_shot( 'usr-ficha.png', '', 'usr_img_ficha' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- CICLO DE VIDA: CREAR / DESHABILITAR / ELIMINAR -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Altas y bajas</div>
				<h2>Del alta al cierre de acceso, en segundos</h2>
				<p>Crea usuarios, corta el acceso temporalmente o elimínalos, siempre con confirmación.</p>
			</div>

			<div class="usr-rows">
				<div class="usr-row">
					<div class="usr-row-text">
						<div class="usr-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM19 8v6M22 11h-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Crear un usuario</h3>
						<p>Registra nombre, alias, NIT, teléfono, correo y login, define su contraseña y asígnale de una vez sus permisos en cada sucursal.</p>
						<ul class="usr-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Contraseña con confirmación y mínimos de seguridad</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Cambio de contraseña cuando lo necesites</li>
						</ul>
					</div>
					<div class="usr-row-media"><?php $usr_shot( 'usr-crear.png', '', 'usr_img_crear' ); ?></div>
				</div>

				<div class="usr-row reverse">
					<div class="usr-row-text is-warn">
						<div class="usr-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="10" width="16" height="11" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 10V7a4 4 0 018 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><path d="M12 14v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></div>
						<h3>Habilitar y deshabilitar</h3>
						<p>Corta el acceso de un usuario sin borrar su historial: no podrá iniciar sesión hasta que lo habilites de nuevo. Ideal para bajas temporales o personal de temporada.</p>
						<ul class="usr-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Reversible: vuelve a habilitarlo cuando quieras</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Conserva su historial y sus registros</li>
						</ul>
					</div>
					<div class="usr-row-media"><?php $usr_shot( 'usr-deshabilitar.png', '', 'usr_img_deshabilitar' ); ?></div>
				</div>

				<div class="usr-row">
					<div class="usr-row-text is-danger">
						<div class="usr-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
						<h3>Eliminar un usuario</h3>
						<p>Cuando alguien deja el equipo de forma definitiva, elimínalo de la lista. El sistema pide confirmación explícita porque la acción es irreversible.</p>
						<ul class="usr-list">
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>Confirmación clara antes de borrar</li>
							<li><svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>¿Solo es temporal? Mejor deshabilítalo</li>
						</ul>
					</div>
					<div class="usr-row-media"><?php $usr_shot( 'usr-eliminar.png', '', 'usr_img_eliminar' ); ?></div>
				</div>
			</div>
		</div>
	</section>

	<!-- CAPACIDADES -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Todo lo que incluye</div>
				<h2>Pensado para tu equipo</h2>
			</div>
			<div class="feat-grid">
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M2 21a7 7 0 0114 0M16 11l2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Roles por sucursal</h3>
					<p>El mismo usuario, con permisos distintos en cada una.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM19 8v6M22 11h-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Alta rápida</h3>
					<p>Datos, contraseña y permisos en una sola pantalla.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><rect x="4" y="10" width="16" height="11" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M8 10V7a4 4 0 018 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg></div>
					<h3>Habilitar / deshabilitar</h3>
					<p>Corta el acceso sin perder el historial.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Eliminación segura</h3>
					<p>Con confirmación explícita antes de borrar.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.7"/><path d="M20 20l-3.5-3.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></div>
					<h3>Búsqueda y filtros</h3>
					<p>Encuentra a cualquiera por nombre, login o alias.</p>
				</div>
				<div class="feat">
					<div class="feat-ic"><svg viewBox="0 0 24 24" fill="none"><path d="M6 3h9l3 3v15H6z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3>Trazabilidad</h3>
					<p>Quién creó cada usuario y cuándo lo hizo.</p>
				</div>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'usr_cta_title', 'Ordena los accesos de tu equipo hoy' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'usr_cta_sub', 'Define quién entra, a qué sucursal y con qué permisos, desde un solo lugar.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'cta_btn_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hero_cta1_txt', 'Prueba gratis' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
