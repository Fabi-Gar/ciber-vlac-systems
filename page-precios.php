<?php
/**
 * Template Name: Precios
 *
 * Página de planes y precios.
 *
 * Todo el contenido comercial (nombres de plan, precios, moneda, período,
 * sucursales, usuarios y la etiqueta del plan destacado) se edita desde
 * Apariencia → Personalizar → Contenido del sitio → «Página Precios», para
 * no tener que volver a subir el tema cada vez que cambie una tarifa.
 *
 * El plan destacado es el que tenga texto en su campo «Etiqueta»; si dos
 * planes tienen etiqueta, ambos se resaltan.
 *
 * Para usarla: crea una página (Páginas → Añadir nueva) con el título
 * «Precios» y el slug «precios», y en «Atributos de página → Plantilla»
 * elige «Precios». No necesita contenido.
 *
 * @package Vlac_Systems
 */

get_header();

$pre_currency = vlac_opt( 'pre_currency', 'Q' );
$pre_period   = vlac_opt( 'pre_period', 'al mes' );

// Los cuatro planes, armados desde el Personalizador.
$pre_plans = array();
$pre_defs  = array(
	1 => array( 'Básico', '200', '1', '3', '' ),
	2 => array( 'Esencial', '550', '1', '10', '' ),
	3 => array( 'Estándar', '1000', '2', '20', 'Más popular' ),
	4 => array( 'Premium', '2000', '4', '50', '' ),
);
foreach ( $pre_defs as $i => $d ) {
	$pre_plans[] = array(
		'name'     => vlac_opt( "pre_p{$i}_name", $d[0] ),
		'price'    => vlac_opt( "pre_p{$i}_price", $d[1] ),
		'branches' => vlac_opt( "pre_p{$i}_branches", $d[2] ),
		'users'    => vlac_opt( "pre_p{$i}_users", $d[3] ),
		'badge'    => vlac_opt( "pre_p{$i}_badge", $d[4] ),
	);
}

// Módulos incluidos en todos los planes, con su página de producto.
$pre_modules = array(
	array( 'Facturador FEL', '/facturacion/', '<path d="M6 3h9l3 3v15l-2-1.4L14 21l-2-1.4L10 21l-2-1.4L6 21V3z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="M9 8h6M9 12h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>' ),
	array( 'Ventas y clientes', '/ventas-clientes/', '<path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2M9 11a4 4 0 100-8 4 4 0 000 8zM22 21v-2a4 4 0 00-3-3.87" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>' ),
	array( 'Contratos', '/contratos/', '<path d="M4 20h16M6 16l8-8 3 3-8 8H6v-3z" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>' ),
	array( 'Compras y proveedores', '/compras-proveedores/', '<path d="M3 7h11v8H3zM14 10h4l3 3v2h-7z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="7" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/><circle cx="17.5" cy="18" r="1.6" stroke="currentColor" stroke-width="1.6"/>' ),
	array( 'Inventario y productos', '/inventario/', '<path d="M12 3l8 4.5v9L12 21l-8-4.5v-9L12 3zm0 0v18M4 7.5l8 4.5 8-4.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>' ),
	array( 'Gestión financiera', '/financiera/', '<path d="M12 1v22M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>' ),
	array( 'Informes', '/informes/', '<path d="M4 20V10M10 20V4M16 20v-7M22 20H2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>' ),
	array( 'Gestión de usuarios', '/usuarios/', '<circle cx="9" cy="8" r="4" stroke="currentColor" stroke-width="1.6"/><path d="M2 21a7 7 0 0114 0M16 11l2 2 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>' ),
	array( 'Múltiples sucursales', '/sucursales/', '<path d="M3 21V9l9-6 9 6v12M3 21h18M9 21v-6h6v6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>' ),
);

$pre_svg_allow = array(
	'path'   => array( 'd' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array(), 'fill' => array() ),
	'circle' => array( 'cx' => array(), 'cy' => array(), 'r' => array(), 'stroke' => array(), 'stroke-width' => array(), 'fill' => array() ),
	'rect'   => array( 'x' => array(), 'y' => array(), 'width' => array(), 'height' => array(), 'rx' => array(), 'stroke' => array(), 'stroke-width' => array() ),
);

$pre_check = '<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>';
?>

<style>
	/* Estilos de la página de Precios (ámbito local). */
	#pre-page{--pre-green:#2e9e5b;}

	/* ---------- HERO ---------- */
	#pre-page .pre-hero{position:relative;overflow:hidden;text-align:center;}
	#pre-page .pre-hero::before{content:"";position:absolute;inset:0;z-index:0;background:radial-gradient(900px 460px at 50% -10%,rgba(193,39,45,.09),transparent 62%),linear-gradient(180deg,#fff,var(--bg-alt));}
	/* Solo padding vertical: el lateral lo pone .wrap del tema (24px / 18px en móvil). */
	#pre-page .pre-hero .wrap{position:relative;z-index:1;padding-top:70px;padding-bottom:84px;}
	#pre-page .pre-hero h1{font-size:clamp(32px,4.8vw,52px);font-weight:800;max-width:820px;margin:0 auto;}
	#pre-page .pre-hero .lead{color:var(--muted);font-size:18.5px;margin:22px auto 0;max-width:600px;}
	#pre-page .pre-hero .pre-note{display:inline-flex;align-items:center;gap:8px;margin-top:26px;background:#fff;border:1px solid var(--line);border-radius:999px;padding:9px 18px;font-size:13.5px;color:var(--ink-strong);box-shadow:var(--shadow-sm);}
	#pre-page .pre-hero .pre-note svg{width:16px;height:16px;color:var(--pre-green);}

	/* ---------- TARJETAS DE PLANES ---------- */
	#pre-page .pre-plans{display:grid;grid-template-columns:repeat(4,1fr);gap:22px;align-items:start;margin-top:52px;}
	#pre-page .pre-plan{position:relative;background:#fff;border:1px solid var(--line);border-radius:var(--radius);padding:30px 24px;text-align:left;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease;display:flex;flex-direction:column;}
	#pre-page .pre-plan:hover{transform:translateY(-5px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#pre-page .pre-plan.is-featured{border-color:var(--red);box-shadow:var(--shadow-lg);padding-top:38px;}
	#pre-page .pre-plan.is-featured:hover{box-shadow:0 22px 50px rgba(15,15,20,.16);}
	#pre-page .pre-plan .pre-badge{position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:var(--red);color:#fff;font-family:'Manrope';font-weight:800;font-size:11.5px;letter-spacing:.05em;text-transform:uppercase;padding:6px 14px;border-radius:999px;white-space:nowrap;box-shadow:0 6px 16px rgba(193,39,45,.34);}
	#pre-page .pre-plan h3{font-size:19px;font-weight:800;}
	#pre-page .pre-price{display:flex;align-items:baseline;gap:4px;margin:16px 0 4px;}
	#pre-page .pre-price .cur{font-family:'Manrope';font-weight:700;font-size:20px;color:var(--ink-strong);}
	#pre-page .pre-price .num{font-family:'Manrope';font-weight:800;font-size:44px;line-height:1;color:var(--ink-strong);letter-spacing:-.02em;}
	#pre-page .pre-plan.is-featured .pre-price .num,#pre-page .pre-plan.is-featured .pre-price .cur{color:var(--red);}
	#pre-page .pre-per{color:var(--muted);font-size:13.5px;}
	#pre-page .pre-specs{display:flex;gap:8px;margin:20px 0 18px;}
	#pre-page .pre-spec{flex:1;background:var(--bg-alt);border-radius:10px;padding:12px 10px;text-align:center;}
	#pre-page .pre-spec b{display:block;font-family:'Manrope';font-weight:800;font-size:19px;color:var(--ink-strong);line-height:1;}
	#pre-page .pre-spec span{display:block;color:var(--muted);font-size:11.5px;margin-top:5px;}
	#pre-page .pre-plan.is-featured .pre-spec{background:var(--red-soft);}
	#pre-page .pre-plan.is-featured .pre-spec b{color:var(--red-dark);}
	#pre-page .pre-feats{list-style:none;margin:0 0 24px;padding:0;display:flex;flex-direction:column;gap:9px;}
	#pre-page .pre-feats li{display:flex;align-items:flex-start;gap:8px;color:var(--ink);font-size:14px;}
	#pre-page .pre-feats svg{width:16px;height:16px;color:var(--pre-green);flex-shrink:0;margin-top:2px;}
	#pre-page .pre-plan .btn{width:100%;justify-content:center;margin-top:auto;}

	/* ---------- MÓDULOS INCLUIDOS ---------- */
	#pre-page .pre-mods{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;}
	#pre-page .pre-mod{display:flex;align-items:center;gap:13px;background:#fff;border:1px solid var(--line);border-radius:12px;padding:16px 18px;color:var(--ink-strong);font-family:'Manrope';font-weight:600;font-size:15px;transition:transform .16s ease,box-shadow .16s ease,border-color .16s ease;}
	#pre-page .pre-mod:hover{transform:translateY(-3px);box-shadow:var(--shadow-md);border-color:#e0d0d0;}
	#pre-page .pre-mod .ic{width:38px;height:38px;border-radius:10px;background:var(--red-soft);display:grid;place-items:center;flex-shrink:0;}
	#pre-page .pre-mod .ic svg{width:20px;height:20px;color:var(--red);}
	#pre-page .pre-mod .go{margin-left:auto;width:16px;height:16px;color:#c9c9d0;flex-shrink:0;}

	/* ---------- COMPARATIVA ---------- */
	#pre-page .pre-table-wrap{overflow-x:auto;border:1px solid var(--line);border-radius:var(--radius);background:#fff;box-shadow:var(--shadow-sm);}
	#pre-page table.pre-table{width:100%;border-collapse:collapse;min-width:640px;}
	#pre-page .pre-table th,#pre-page .pre-table td{padding:16px 18px;text-align:center;border-bottom:1px solid var(--line);font-size:14.5px;}
	#pre-page .pre-table th:first-child,#pre-page .pre-table td:first-child{text-align:left;font-family:'Manrope';font-weight:600;color:var(--ink-strong);}
	#pre-page .pre-table thead th{background:var(--bg-alt);font-family:'Manrope';font-weight:800;font-size:15px;color:var(--ink-strong);}
	#pre-page .pre-table tbody tr:last-child td{border-bottom:0;}
	#pre-page .pre-table td{color:var(--muted);}
	#pre-page .pre-table td b{color:var(--ink-strong);font-family:'Manrope';font-weight:700;}
	#pre-page .pre-table svg{width:18px;height:18px;color:var(--pre-green);}

	/* ---------- FAQ ---------- */
	#pre-page .pre-faq{max-width:780px;margin:0 auto;display:flex;flex-direction:column;gap:12px;}
	#pre-page .pre-faq details{background:#fff;border:1px solid var(--line);border-radius:12px;overflow:hidden;transition:border-color .16s ease;}
	#pre-page .pre-faq details[open]{border-color:#e0d0d0;box-shadow:var(--shadow-sm);}
	#pre-page .pre-faq summary{cursor:pointer;list-style:none;padding:18px 22px;font-family:'Manrope';font-weight:700;font-size:16px;color:var(--ink-strong);display:flex;align-items:center;justify-content:space-between;gap:16px;}
	#pre-page .pre-faq summary::-webkit-details-marker{display:none;}
	#pre-page .pre-faq summary::after{content:"";width:9px;height:9px;border-right:2px solid var(--muted);border-bottom:2px solid var(--muted);transform:rotate(45deg);flex-shrink:0;transition:transform .2s ease;margin-top:-4px;}
	#pre-page .pre-faq details[open] summary::after{transform:rotate(-135deg);margin-top:2px;}
	#pre-page .pre-faq .ans{padding:0 22px 20px;color:var(--muted);font-size:15px;}

	/* Aviso de scroll de la tabla (solo en pantallas chicas) */
	#pre-page .pre-scroll-hint{display:none;align-items:center;justify-content:center;gap:7px;color:var(--muted);font-size:13px;margin-top:14px;}
	#pre-page .pre-scroll-hint svg{width:15px;height:15px;}

	@media (max-width:1100px){
		#pre-page .pre-plans{grid-template-columns:repeat(2,1fr);gap:30px 22px;}
		#pre-page .pre-mods{grid-template-columns:repeat(2,1fr);}
	}
	@media (max-width:760px){
		#pre-page .pre-hero .wrap{padding-top:54px;padding-bottom:60px;}
		#pre-page .pre-hero .lead{font-size:17px;}
		/* Una columna: las tarjetas se centran y el hueco deja sitio a la etiqueta */
		#pre-page .pre-plans{grid-template-columns:1fr;gap:36px;margin:40px auto 0;max-width:420px;}
		#pre-page .pre-mods{grid-template-columns:1fr;}
		/* La nota deja de ser una píldora de una línea y puede envolver */
		#pre-page .pre-hero .pre-note{max-width:100%;border-radius:14px;text-align:left;align-items:flex-start;}
		#pre-page .pre-hero .pre-note svg{margin-top:3px;flex-shrink:0;}
		/* Tabla: primera columna fija para no perder la referencia al hacer scroll */
		#pre-page table.pre-table{min-width:560px;}
		#pre-page .pre-table th,#pre-page .pre-table td{padding:13px 12px;font-size:13.5px;}
		#pre-page .pre-table th:first-child,#pre-page .pre-table td:first-child{position:sticky;left:0;z-index:1;background:#fff;box-shadow:1px 0 0 var(--line);}
		#pre-page .pre-table thead th:first-child{background:var(--bg-alt);}
		#pre-page .pre-scroll-hint{display:flex;}
	}
	@media (max-width:420px){
		#pre-page .pre-price .num{font-size:38px;}
		#pre-page .pre-plan{padding:26px 20px;}
		#pre-page .pre-plan.is-featured{padding-top:34px;}
	}
</style>

<div id="pre-page">

	<!-- HERO + PLANES -->
	<section class="pre-hero">
		<div class="wrap">
			<span class="eyebrow"><span class="dot"></span> <?php echo esc_html( vlac_opt( 'pre_eyebrow', 'Planes y precios' ) ); ?></span>
			<h1><?php echo wp_kses_post( vlac_opt( 'pre_title', 'Elige el plan que le queda a tu <span class="accent">negocio</span>' ) ); ?></h1>
			<p class="lead"><?php echo esc_html( vlac_opt( 'pre_sub', 'Todos los planes incluyen el sistema completo. Lo único que cambia es cuántas sucursales y cuántos usuarios necesitas.' ) ); ?></p>

			<span class="pre-note">
				<svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
				<?php echo esc_html( vlac_opt( 'pre_note', 'Facturador FEL y todos los módulos incluidos en cada plan' ) ); ?>
			</span>

			<div class="pre-plans">
				<?php foreach ( $pre_plans as $plan ) : ?>
					<?php $is_feat = ! empty( $plan['badge'] ); ?>
					<div class="pre-plan<?php echo $is_feat ? ' is-featured' : ''; ?>">
						<?php if ( $is_feat ) : ?>
							<span class="pre-badge"><?php echo esc_html( $plan['badge'] ); ?></span>
						<?php endif; ?>

						<h3><?php echo esc_html( $plan['name'] ); ?></h3>

						<div class="pre-price">
							<span class="cur"><?php echo esc_html( $pre_currency ); ?></span>
							<span class="num"><?php echo esc_html( $plan['price'] ); ?></span>
						</div>
						<div class="pre-per"><?php echo esc_html( $pre_period ); ?></div>

						<div class="pre-specs">
							<div class="pre-spec">
								<b><?php echo esc_html( $plan['branches'] ); ?></b>
								<span><?php echo esc_html( '1' === $plan['branches'] ? 'Sucursal' : 'Sucursales' ); ?></span>
							</div>
							<div class="pre-spec">
								<b><?php echo esc_html( $plan['users'] ); ?></b>
								<span>Usuarios</span>
							</div>
						</div>

						<ul class="pre-feats">
							<li><?php echo wp_kses( $pre_check, array( 'svg' => array( 'viewbox' => array(), 'fill' => array() ), 'path' => array( 'd' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array() ) ) ); ?>Todos los módulos incluidos</li>
							<li><?php echo wp_kses( $pre_check, array( 'svg' => array( 'viewbox' => array(), 'fill' => array() ), 'path' => array( 'd' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array() ) ) ); ?>Facturador FEL certificado</li>
							<li><?php echo wp_kses( $pre_check, array( 'svg' => array( 'viewbox' => array(), 'fill' => array() ), 'path' => array( 'd' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array() ) ) ); ?>Tu marca y tu dominio</li>
							<li><?php echo wp_kses( $pre_check, array( 'svg' => array( 'viewbox' => array(), 'fill' => array() ), 'path' => array( 'd' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array() ) ) ); ?>Soporte local</li>
						</ul>

						<a class="btn <?php echo $is_feat ? 'btn-red' : 'btn-ghost'; ?>" href="<?php echo esc_url( vlac_cta_url( 'pre_cta_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'pre_btn_txt', 'Empezar' ) ); ?></a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- MÓDULOS INCLUIDOS -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Incluido en todos los planes</div>
				<h2>El sistema completo, desde el plan más pequeño</h2>
				<p>No vendemos los módulos por separado ni te cobramos extra por función. Todos los planes traen todo esto.</p>
			</div>

			<div class="pre-mods">
				<?php foreach ( $pre_modules as $mod ) : ?>
					<a class="pre-mod" href="<?php echo esc_url( home_url( $mod[1] ) ); ?>">
						<span class="ic"><svg viewBox="0 0 24 24" fill="none"><?php echo wp_kses( $mod[2], $pre_svg_allow ); ?></svg></span>
						<?php echo esc_html( $mod[0] ); ?>
						<svg class="go" viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- COMPARATIVA -->
	<section class="section">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Comparativa</div>
				<h2>Los planes, lado a lado</h2>
			</div>

			<div class="pre-table-wrap">
				<table class="pre-table">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<?php foreach ( $pre_plans as $plan ) : ?>
								<th><?php echo esc_html( $plan['name'] ); ?></th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Precio <?php echo esc_html( $pre_period ); ?></td>
							<?php foreach ( $pre_plans as $plan ) : ?>
								<td><b><?php echo esc_html( $pre_currency . ' ' . $plan['price'] ); ?></b></td>
							<?php endforeach; ?>
						</tr>
						<tr>
							<td>Sucursales</td>
							<?php foreach ( $pre_plans as $plan ) : ?>
								<td><b><?php echo esc_html( $plan['branches'] ); ?></b></td>
							<?php endforeach; ?>
						</tr>
						<tr>
							<td>Usuarios</td>
							<?php foreach ( $pre_plans as $plan ) : ?>
								<td><b><?php echo esc_html( $plan['users'] ); ?></b></td>
							<?php endforeach; ?>
						</tr>
						<tr>
							<td>Facturador FEL</td>
							<?php foreach ( $pre_plans as $plan ) : ?>
								<td><?php echo wp_kses( $pre_check, array( 'svg' => array( 'viewbox' => array(), 'fill' => array() ), 'path' => array( 'd' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array() ) ) ); ?></td>
							<?php endforeach; ?>
						</tr>
						<tr>
							<td>Todos los módulos</td>
							<?php foreach ( $pre_plans as $plan ) : ?>
								<td><?php echo wp_kses( $pre_check, array( 'svg' => array( 'viewbox' => array(), 'fill' => array() ), 'path' => array( 'd' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array() ) ) ); ?></td>
							<?php endforeach; ?>
						</tr>
						<tr>
							<td>Traslados entre sucursales</td>
							<?php foreach ( $pre_plans as $plan ) : ?>
								<td><?php echo (int) $plan['branches'] > 1 ? wp_kses( $pre_check, array( 'svg' => array( 'viewbox' => array(), 'fill' => array() ), 'path' => array( 'd' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array() ) ) ) : '—'; ?></td>
							<?php endforeach; ?>
						</tr>
						<tr>
							<td>Soporte local</td>
							<?php foreach ( $pre_plans as $plan ) : ?>
								<td><?php echo wp_kses( $pre_check, array( 'svg' => array( 'viewbox' => array(), 'fill' => array() ), 'path' => array( 'd' => array(), 'stroke' => array(), 'stroke-width' => array(), 'stroke-linecap' => array(), 'stroke-linejoin' => array() ) ) ); ?></td>
							<?php endforeach; ?>
						</tr>
					</tbody>
				</table>
			</div>

			<p class="pre-scroll-hint">
				<svg viewBox="0 0 24 24" fill="none"><path d="M4 12h16M14 6l6 6-6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
				Desliza para ver todos los planes
			</p>
		</div>
	</section>

	<!-- PREGUNTAS FRECUENTES -->
	<section class="section section-alt">
		<div class="wrap">
			<div class="sec-head">
				<div class="sec-kicker">Preguntas frecuentes</div>
				<h2>Antes de decidir</h2>
			</div>

			<div class="pre-faq">
				<details open>
					<summary>¿Qué diferencia hay entre un plan y otro?</summary>
					<div class="ans">Solo la cantidad de sucursales y de usuarios. El sistema es el mismo en los cuatro planes: facturación FEL, ventas, clientes, contratos, compras, inventario, finanzas, informes y usuarios.</div>
				</details>
				<details>
					<summary>¿El Facturador FEL viene incluido?</summary>
					<div class="ans">Sí, en todos los planes. Emites tus facturas electrónicas certificadas ante la SAT desde el mismo sistema, sin pagar aparte.</div>
				</details>
				<details>
					<summary>¿Puedo cambiar de plan más adelante?</summary>
					<div class="ans">Sí. Si tu negocio crece y necesitas más sucursales o más usuarios, hablas con un asesor y pasamos tu cuenta al plan que te toque, sin perder tu información.</div>
				</details>
				<details>
					<summary>¿Y si necesito más de 4 sucursales o más de 50 usuarios?</summary>
					<div class="ans">Te armamos un plan a la medida. Contáctanos y lo vemos según el tamaño de tu operación.</div>
				</details>
				<details>
					<summary>¿Puedo probarlo antes de pagar?</summary>
					<div class="ans">Sí. Solicita tu prueba gratis y te acompañamos a configurar tu negocio para que lo veas funcionando con tus propios datos.</div>
				</details>
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="section">
		<div class="wrap">
			<div class="cta-strip">
				<h2><?php echo esc_html( vlac_opt( 'pre_cta_title', '¿No sabes cuál plan te conviene?' ) ); ?></h2>
				<p><?php echo esc_html( vlac_opt( 'pre_cta_sub', 'Cuéntanos cuántas sucursales tienes y cuánta gente lo va a usar. Un asesor te dice cuál te queda mejor.' ) ); ?></p>
				<a class="btn btn-red btn-lg" href="<?php echo esc_url( vlac_cta_url( 'hdr_asesor_url' ) ); ?>"><?php echo esc_html( vlac_opt( 'hdr_asesor_txt', 'Hablar con un asesor' ) ); ?></a>
			</div>
		</div>
	</section>

</div>

<?php
get_footer();
