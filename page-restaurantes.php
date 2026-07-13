<?php
/**
 * Template Name: Industria — Restaurantes
 *
 * Plantilla de la página de Restaurantes.
 * Se aplica automáticamente a la página con slug «restaurantes»
 * (p. ej. /industrias/restaurantes/) o puede asignarse manualmente
 * desde Editor de página → Plantilla.
 *
 * @package Vlac_Systems
 */

get_header();
?>

<!-- ============================================================
     RESTAURANTES — diseño con Tailwind (cargado solo en esta página).
     Se conserva el <header>/<footer> del tema; Tailwind se usa
     únicamente dentro de este bloque.
     ============================================================ -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<script>
	tailwind.config = {
		darkMode: "class",
		theme: {
			extend: {
				"colors": {
					"primary-fixed-dim": "#ffb3ae",
					"tertiary-container": "#6e6262",
					"on-secondary-container": "#616366",
					"muted": "#6B6F76",
					"success": "#2E9E5B",
					"tertiary": "#554a4b",
					"secondary-container": "#dfdfe3",
					"inverse-surface": "#303030",
					"secondary-fixed-dim": "#c6c6ca",
					"primary-container": "#c1272d",
					"on-tertiary": "#ffffff",
					"primary": "#9e0418",
					"secondary-fixed": "#e2e2e6",
					"surface-container-high": "#eae8e7",
					"surface-container": "#f0eded",
					"surface-dim": "#dcd9d9",
					"on-surface-variant": "#5a403e",
					"on-surface": "#1b1c1c",
					"primary-fixed": "#ffdad7",
					"outline": "#8f706d",
					"tertiary-fixed": "#efdfdf",
					"surface-bright": "#fbf9f8",
					"outline-variant": "#e3bebb",
					"on-primary-container": "#ffdbd8",
					"inverse-primary": "#ffb3ae",
					"line": "#E9E9EC",
					"surface-container-low": "#f6f3f2",
					"tertiary-fixed-dim": "#d2c3c3",
					"surface": "#fbf9f8",
					"error": "#ba1a1a",
					"on-primary-fixed-variant": "#930015",
					"on-secondary": "#ffffff",
					"on-primary-fixed": "#410004",
					"inverse-on-surface": "#f3f0f0",
					"on-error-container": "#93000a",
					"on-primary": "#ffffff",
					"bg-alt": "#FAFAFB",
					"surface-container-lowest": "#ffffff",
					"on-tertiary-container": "#efdfdf",
					"red-dark": "#8E1B20",
					"on-error": "#ffffff",
					"surface-variant": "#e4e2e1",
					"on-background": "#1b1c1c",
					"error-container": "#ffdad6",
					"on-secondary-fixed": "#1a1c1f",
					"on-secondary-fixed-variant": "#45474a",
					"on-tertiary-fixed": "#221a1a",
					"surface-container-highest": "#e4e2e1",
					"secondary": "#5d5e62",
					"background": "#fbf9f8",
					"on-tertiary-fixed-variant": "#4e4445",
					"surface-tint": "#b71f27"
				},
				"borderRadius": {
					"DEFAULT": "0.25rem",
					"lg": "0.5rem",
					"xl": "0.75rem",
					"full": "9999px"
				},
				"spacing": {
					"max-width": "1180px",
					"gap-ui": "16px",
					"gap-grid": "22px",
					"section-v-padding": "86px",
					"gutter-mobile": "18px",
					"gutter": "24px"
				},
				"fontFamily": {
					"body-lg": ["Inter"],
					"label-caps": ["Manrope"],
					"headline-lg": ["Manrope"],
					"headline-sm": ["Manrope"],
					"headline-lg-mobile": ["Manrope"],
					"headline-md-mobile": ["Manrope"],
					"badge": ["Manrope"],
					"headline-md": ["Manrope"],
					"body-sm": ["Inter"],
					"body-md": ["Inter"]
				},
				"fontSize": {
					"body-lg": ["18px", {"lineHeight": "1.55", "fontWeight": "400"}],
					"label-caps": ["13px", {"lineHeight": "1", "letterSpacing": "0.14em", "fontWeight": "700"}],
					"headline-lg": ["54px", {"lineHeight": "1.12", "letterSpacing": "-0.02em", "fontWeight": "800"}],
					"headline-sm": ["18px", {"lineHeight": "1.2", "fontWeight": "700"}],
					"headline-lg-mobile": ["34px", {"lineHeight": "1.12", "letterSpacing": "-0.02em", "fontWeight": "800"}],
					"headline-md-mobile": ["28px", {"lineHeight": "1.12", "letterSpacing": "-0.02em", "fontWeight": "800"}],
					"badge": ["11px", {"lineHeight": "1", "letterSpacing": "0.03em", "fontWeight": "700"}],
					"headline-md": ["40px", {"lineHeight": "1.12", "letterSpacing": "-0.02em", "fontWeight": "800"}],
					"body-sm": ["14px", {"lineHeight": "1.5", "fontWeight": "400"}],
					"body-md": ["15px", {"lineHeight": "1.55", "fontWeight": "400"}]
				}
			},
		},
	}
</script>
<style>
	#restaurantes-page .material-symbols-outlined {
		font-family: 'Material Symbols Outlined';
		font-weight: normal;
		font-style: normal;
		line-height: 1;
		letter-spacing: normal;
		text-transform: none;
		display: inline-block;
		white-space: nowrap;
		word-wrap: normal;
		direction: ltr;
		font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
	}
	#restaurantes-page .btn-shadow {
		box-shadow: 0 4px 14px 0 rgba(193, 39, 45, 0.39);
	}
	#restaurantes-page .card-lift {
		transition: all 0.2s ease-out;
	}
	#restaurantes-page .card-lift:hover {
		transform: translateY(-4px);
		box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
	}
	#restaurantes-page .feature-gradient {
		background: linear-gradient(135deg, #ffffff 0%, #f6f3f2 100%);
	}
</style>

<div id="restaurantes-page" class="bg-background text-on-surface font-body-md overflow-x-hidden">
	<section class="relative pt-section-v-padding pb-section-v-padding overflow-hidden">
		<div class="max-w-[1180px] mx-auto px-gutter flex flex-col md:flex-row items-center gap-12">
			<div class="flex-1 text-center md:text-left">
				<span class="inline-block bg-primary-fixed text-primary px-4 py-1 rounded-full font-badge text-badge mb-6">RESTAURANTES 4.0</span>
				<h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg mb-6 leading-tight">
					Transformación Digital para tu <span class="text-primary">Restaurante</span>
				</h1>
				<p class="font-body-lg text-body-lg text-muted mb-8 max-w-2xl">
					Gestión total desde el pedido hasta la factura FEL. El ERP más potente de Guatemala adaptado para el sector gastronómico, optimizando tiempos y maximizando ganancias.
				</p>
				<div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
					<a href="<?php echo esc_url( vlac_cta_url( 'rest_cta1_url' ) ); ?>" class="cta-press inline-block text-center bg-primary text-white px-8 py-4 rounded-[10px] font-bold text-body-lg btn-shadow hover:bg-red-dark transition-all">
						<?php echo esc_html( vlac_opt( 'rest_cta1_txt', 'Empezar ahora' ) ); ?>
					</a>
					<a href="<?php echo esc_url( vlac_opt( 'rest_cta2_url', '#' ) ); ?>" class="cta-press inline-block text-center border border-line text-on-surface px-8 py-4 rounded-[10px] font-bold text-body-lg hover:bg-surface-variant transition-all">
						<?php echo esc_html( vlac_opt( 'rest_cta2_txt', 'Ver Demostración' ) ); ?>
					</a>
				</div>
			</div>
			<div class="flex-1 relative w-full aspect-video md:aspect-square">
				<div class="absolute inset-0 bg-primary-fixed-dim/20 rounded-[32px] transform rotate-3"></div>
				<div class="relative h-full w-full rounded-[32px] overflow-hidden border border-line shadow-lg">
					<img alt="Interface de gestión de restaurante" class="w-full h-full object-cover" src="https://vlac.systems/wp-content/uploads/2026/07/mesero-con-comanda-e1783462269206.png">
				</div>
			</div>
		</div>
	</section>

	<section class="bg-white py-section-v-padding border-y border-line">
		<div class="max-w-[1180px] mx-auto px-gutter">
			<div class="text-center mb-20">
				<h2 class="font-headline-md text-headline-md-mobile md:text-headline-md mb-4">Todo lo que necesitas para operar</h2>
				<p class="text-muted font-body-md max-w-2xl mx-auto">Nuestra plataforma integra cada aspecto de tu negocio en una interfaz intuitiva y poderosa, diseñada específicamente para el mercado guatemalteco.</p>
			</div>
			<div class="space-y-32 mb-32">
				<div class="flex flex-col md:flex-row items-center gap-12">
					<div class="flex-1 space-y-6">
						<div class="w-14 h-14 bg-primary text-white flex items-center justify-center rounded-xl shadow-lg shadow-primary/20">
							<span class="material-symbols-outlined text-3xl">restaurant_menu</span>
						</div>
						<h3 class="font-headline-md text-3xl">Comanda Digital en Tiempo Real</h3>
						<p class="text-body-lg text-muted">
							Elimina errores de comunicación entre salón y cocina. Los pedidos llegan instantáneamente a monitores personalizados en barra y cocina, organizados por tiempos de preparación.
						</p>
						<ul class="space-y-3">
							<li class="flex items-center gap-3 text-body-md text-on-surface">
								<span class="material-symbols-outlined text-primary text-sm">check_circle</span>
								Monitores táctiles para cocina y barra
							</li>
							<li class="flex items-center gap-3 text-body-md text-on-surface">
								<span class="material-symbols-outlined text-primary text-sm">check_circle</span>
								Alertas de demora y prioridad de órdenes
							</li>
						</ul>
					</div>
					<div class="w-full md:flex-[1.9]">
						<div class="bg-surface-container-low p-2 rounded-[2rem] border border-line">
							<img alt="Comanda Digital Interface" class="rounded-[1.5rem] shadow-xl w-full h-auto bg-white" src="https://vlac.systems/wp-content/uploads/2026/07/download.gif">
						</div>
					</div>
				</div>
				<!-- Mapa de Mesas -->
				<div class="flex flex-col md:flex-row-reverse items-center gap-12">
					<div class="flex-1 space-y-6">
						<div class="w-14 h-14 bg-primary text-white flex items-center justify-center rounded-xl shadow-lg shadow-primary/20">
							<span class="material-symbols-outlined text-3xl">grid_view</span>
						</div>
						<h3 class="font-headline-md text-3xl">Control Visual de Mesas</h3>
						<p class="text-body-lg text-muted">
							Replica la arquitectura de tu restaurante. Gestiona ocupación, une mesas, separa cuentas y monitorea el tiempo de estancia de cada cliente de forma 100% visual.
						</p>
						<ul class="space-y-3">
							<li class="flex items-center gap-3 text-body-md text-on-surface">
								<span class="material-symbols-outlined text-primary text-sm">check_circle</span>
								Gestión multi-piso y áreas exteriores
							</li>
						</ul>
					</div>
					<div class="flex-1 w-full">
						<div class="bg-surface-container-low p-4 rounded-[2rem] border border-line">
							<img alt="Table Layout Map" class="rounded-[1.5rem] shadow-xl w-full aspect-[4/3] object-contain bg-white" src="https://vlac.systems/wp-content/uploads/2026/07/mapa-comanda-e1783463509112.png">
						</div>
					</div>
				</div>
				<!-- App Repartidores -->
				<div class="flex flex-col md:flex-row items-center gap-12">
					<div class="flex-1 space-y-6">
						<div class="w-14 h-14 bg-primary text-white flex items-center justify-center rounded-xl shadow-lg shadow-primary/20">
							<span class="material-symbols-outlined text-3xl">delivery_dining</span>
						</div>
						<h3 class="font-headline-md text-3xl">Logística de Delivery Inteligente</h3>
						<p class="text-body-lg text-muted">
							Toma el control de tus envíos a domicilio. App nativa para motoristas con seguimiento en tiempo real, asignación de rutas y liquidación de efectivo automática.
						</p>
						<ul class="space-y-3">
							<li class="flex items-center gap-3 text-body-md text-on-surface">
								<span class="material-symbols-outlined text-primary text-sm">check_circle</span>
								Historial de entregas y comisiones por repartidor
							</li>
						</ul>
					</div>
					<div class="flex-1 w-full">
						<div class="bg-surface-container-low p-4 rounded-[2rem] border border-line">
							<img alt="Delivery App Interface" class="rounded-[1.5rem] shadow-xl w-full aspect-[4/3] object-contain bg-white" src="https://vlac.systems/wp-content/uploads/2026/07/delivery.png">
						</div>
					</div>
				</div>
				<!-- Facturador FEL -->
				<div class="flex flex-col md:flex-row-reverse items-center gap-12">
					<div class="flex-1 space-y-6">
						<div class="w-14 h-14 bg-primary text-white flex items-center justify-center rounded-xl shadow-lg shadow-primary/20">
							<span class="material-symbols-outlined text-3xl">point_of_sale</span>
						</div>
						<h3 class="font-headline-md text-3xl">Facturación Electrónica Nativa</h3>
						<p class="text-body-lg text-muted">
							La integración más fluida con la SAT en Guatemala. Emite Facturas Especiales, Notas de Crédito y Recibos FEL al instante directamente desde el POS.
						</p>
						<ul class="space-y-3">
							<li class="flex items-center gap-3 text-body-md text-on-surface">
								<span class="material-symbols-outlined text-primary text-sm">check_circle</span>
								Envío automático de PDF al correo o WhatsApp
							</li>
						</ul>
					</div>
					<div class="flex-1 w-full">
						<div class="bg-surface-container-low p-4 rounded-[2rem] border border-line">
							<img alt="FEL Billing Screen" class="rounded-[1.5rem] shadow-xl w-full aspect-[4/3] object-contain bg-white" src="https://vlac.systems/wp-content/uploads/2026/07/termica-con-factura.jpg">
						</div>
					</div>
				</div>
			</div>
			<!-- Secondary Features Grid -->
			<div class="border-t border-line pt-20">
				<div class="text-center mb-12">
					<span class="text-primary font-label-caps text-label-caps uppercase tracking-widest">Funcionalidades Adicionales</span>
					<h4 class="font-headline-sm text-2xl mt-2">Gestión Integral 360°</h4>
				</div>
				<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
					<!-- Feature Card -->
					<div class="bg-surface-container-lowest p-6 rounded-xl border border-line hover:border-primary/30 transition-all group">
						<div class="w-10 h-10 bg-surface-container text-primary flex items-center justify-center rounded-lg mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
							<span class="material-symbols-outlined">qr_code_2</span>
						</div>
						<h5 class="font-bold text-on-surface mb-2">Menú Digital QR</h5>
						<p class="text-body-sm text-muted">Venta en línea y menú auto-gestionado por el cliente.</p>
					</div>
					<div class="bg-surface-container-lowest p-6 rounded-xl border border-line hover:border-primary/30 transition-all group">
						<div class="w-10 h-10 bg-surface-container text-primary flex items-center justify-center rounded-lg mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
							<span class="material-symbols-outlined">volunteer_activism</span>
						</div>
						<h5 class="font-bold text-on-surface mb-2">Propinas</h5>
						<p class="text-body-sm text-muted">Cálculo automático y distribución transparente por mesero.</p>
					</div>
					<div class="bg-surface-container-lowest p-6 rounded-xl border border-line hover:border-primary/30 transition-all group">
						<div class="w-10 h-10 bg-surface-container text-primary flex items-center justify-center rounded-lg mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
							<span class="material-symbols-outlined">history</span>
						</div>
						<h5 class="font-bold text-on-surface mb-2">Auditoría Total</h5>
						<p class="text-body-sm text-muted">Control total de anulaciones y modificaciones de pedidos.</p>
					</div>
					<div class="bg-surface-container-lowest p-6 rounded-xl border border-line hover:border-primary/30 transition-all group">
						<div class="w-10 h-10 bg-surface-container text-primary flex items-center justify-center rounded-lg mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
							<span class="material-symbols-outlined">mail</span>
						</div>
						<h5 class="font-bold text-on-surface mb-2">Cierre Remoto</h5>
						<p class="text-body-sm text-muted">Reportes de caja diarios enviados directo a tu correo.</p>
					</div>
					<div class="bg-surface-container-lowest p-6 rounded-xl border border-line hover:border-primary/30 transition-all group">
						<div class="w-10 h-10 bg-surface-container text-primary flex items-center justify-center rounded-lg mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
							<span class="material-symbols-outlined">chat</span>
						</div>
						<h5 class="font-bold text-on-surface mb-2">Envío WhatsApp</h5>
						<p class="text-body-sm text-muted">Comunicación directa de facturas y órdenes con clientes.</p>
					</div>
					<div class="bg-surface-container-lowest p-6 rounded-xl border border-line hover:border-primary/30 transition-all group">
						<div class="w-10 h-10 bg-surface-container text-primary flex items-center justify-center rounded-lg mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
							<span class="material-symbols-outlined">print</span>
						</div>
						<h5 class="font-bold text-on-surface mb-2">Multi-formato</h5>
						<p class="text-body-sm text-muted">PDF, Térmico y Excel para todos tus reportes.</p>
					</div>
					<div class="bg-surface-container-lowest p-6 rounded-xl border border-line hover:border-primary/30 transition-all group">
						<div class="w-10 h-10 bg-surface-container text-primary flex items-center justify-center rounded-lg mb-4 group-hover:bg-primary group-hover:text-white transition-colors">
							<span class="material-symbols-outlined">label</span>
						</div>
						<h5 class="font-bold text-on-surface mb-2">Etiquetado</h5>
						<p class="text-body-sm text-muted">Diseño e impresión de stickers de producto personalizados.</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Branding & Domain Section -->
	<section class="py-section-v-padding bg-surface-container-low">
		<div class="max-w-[1180px] mx-auto px-gutter space-y-32">
			<div class="flex flex-col md:flex-row items-center gap-16">
				<div class="flex-1">
					<h2 class="font-headline-md text-headline-md-mobile md:text-headline-md mb-6 leading-tight">Tu Marca, <span class="text-primary">Tu Dominio</span></h2>
					<p class="font-body-lg text-body-lg text-muted mb-6">
						Refuerza la identidad de tu negocio. No eres un cliente más en una plataforma genérica; te proporcionamos tu propia URL personalizada y adaptamos todo el ERP con los colores y logos de tu empresa.
					</p>
					<div class="bg-white p-6 rounded-[14px] border border-line shadow-sm">
						<div class="flex items-center gap-2 mb-4">
							<span class="material-symbols-outlined text-primary">language</span>
							<span class="font-mono text-body-sm font-bold">tunegocio.softcontext.com</span>
						</div>
						<p class="text-body-sm italic">Branding completo: Facturas, App de meseros y Menú digital 100% con tu imagen corporativa.</p>
					</div>
				</div>
				<div class="flex-1">
					<div class="w-full aspect-video rounded-[24px] overflow-hidden shadow-md border border-line">
						<img alt="Branding personalizado" class="w-full h-full object-cover" src="https://vlac.systems/wp-content/uploads/2026/07/pc-y-telefono-con-sistema-e1783465037588.jpg">
					</div>
				</div>
			</div>
			<!-- Mobility Section -->
			<div class="flex flex-col md:flex-row items-center gap-16">
				<div class="flex-1 order-2 md:order-1">
					<div class="w-full aspect-square rounded-[24px] overflow-hidden shadow-md border border-line">
						<img alt="Movilidad y control total" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCRXIDkNK-iI0ifwjMJs9iz6DoKojg4Np1dr43uDwHq2YG5TslWUk_PXhb6sbNU-7QAYSKMcZ3xjSIGC5VmKdbq5A4bapReEf2a58bN0ub8idyGr6TOkePu0E0xtlHTj5fc_Ykg_NaEedSSfdtk-G62xGfyVQ6xigdLnfcZ5R6yTiPtDE8rTvdYgh9KUwhW_nXPZt8ob3hKNwSPPMC3NbI-qhTKJ9WHVORW3VS-mWjdrhS_rutTD7h4XJT441Zc80MVcHkje46FD2U">
					</div>
				</div>
				<div class="flex-1 order-1 md:order-2">
					<h2 class="font-headline-md text-headline-md-mobile md:text-headline-md mb-6 leading-tight">Nube y Movilidad <span class="text-primary">Total</span></h2>
					<p class="font-body-lg text-body-lg text-muted mb-6">
						Controla tu negocio desde cualquier lugar del mundo. Accede a ventas en tiempo real, inventarios y reportes financieros desde tu tablet o smartphone.
					</p>
					<div class="grid grid-cols-2 gap-4">
						<div class="bg-white border border-line p-4 rounded-[12px] flex items-center gap-3">
							<span class="material-symbols-outlined text-primary">tablet_android</span>
							<span class="font-bold">Optimizado Tablets</span>
						</div>
						<div class="bg-white border border-line p-4 rounded-[12px] flex items-center gap-3">
							<span class="material-symbols-outlined text-primary">smartphone</span>
							<span class="font-bold">App Móvil</span>
						</div>
						<div class="bg-white border border-line p-4 rounded-[12px] flex items-center gap-3">
							<span class="material-symbols-outlined text-primary">cloud_done</span>
							<span class="font-bold">Sincronización 24/7</span>
						</div>
						<div class="bg-white border border-line p-4 rounded-[12px] flex items-center gap-3">
							<span class="material-symbols-outlined text-primary">security</span>
							<span class="font-bold">Datos Encriptados</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Final CTA -->
	<section class="bg-primary py-section-v-padding text-white">
		<div class="max-w-[1180px] mx-auto px-gutter text-center">
			<h2 class="font-headline-md text-headline-md-mobile md:text-headline-md mb-6 text-white">¿Listo para llevar tu restaurante al siguiente nivel?</h2>
			<p class="text-on-primary-container font-body-lg mb-10 max-w-2xl mx-auto">
				Únete a los más de 500 establecimientos que ya confían en Ciber Vlac Systems para su operación diaria.
			</p>
			<div class="flex flex-col sm:flex-row gap-6 justify-center">
				<a href="<?php echo esc_url( vlac_cta_url( 'rest_cta3_url' ) ); ?>" class="cta-press inline-block text-center bg-white text-primary px-10 py-5 rounded-[10px] font-extrabold text-body-lg hover:bg-surface transition-all shadow-lg">
					<?php echo esc_html( vlac_opt( 'rest_cta3_txt', 'Solicitar Demo Gratuita' ) ); ?>
				</a>
				<a href="<?php echo esc_url( vlac_cta_url( 'rest_cta4_url' ) ); ?>" class="cta-press inline-block text-center border-2 border-white text-white px-10 py-5 rounded-[10px] font-extrabold text-body-lg hover:bg-white/10 transition-all">
					<?php echo esc_html( vlac_opt( 'rest_cta4_txt', 'Hablar con un experto' ) ); ?>
				</a>
			</div>
		</div>
	</section>
</div>

<script>
	(function () {
		var root = document.getElementById('restaurantes-page');
		if (!root) return;
		root.querySelectorAll('button, .cta-press').forEach(function (button) {
			button.addEventListener('mousedown', function () { button.classList.add('scale-95'); });
			button.addEventListener('mouseup', function () { button.classList.remove('scale-95'); });
			button.addEventListener('mouseleave', function () { button.classList.remove('scale-95'); });
		});
	})();
</script>

<?php
get_footer();
