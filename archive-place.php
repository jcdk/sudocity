<?php
/**
 * The template for displaying archive pages.
 *
 * @package Nu Themes
 */
 
 	## https://www.mapbox.com/maki-icons/
 
	$mapjson = json_encode($geojson);
	$map_icos = array('cluster'=>'warehouse',
 						'factory' => 'industrial',
 						'town' => 'city',
 						'network' => 'circle-stroked',
 						'church' => 'place-of-worship');

	get_header();

		if ( have_posts() ) : 
			$geojson = array( 'type' => 'FeatureCollection', 'features' => array() );
			while ( have_posts() ) : the_post(); 
		
				$location = get_field('place_location');
				$place = get_field('place_name');
				$excerpt = get_field('place_line');
				$place_type = get_field('place_type');
				$place_itype = $place_type['value']; 
			
				if ($location['lng']>0||$location['lng']<0) {

					$feature = array(
						'type' => 'Feature', 
					  'geometry' => array(
						'type' => 'Point',
						'coordinates' => array($location['lng'],$location['lat'])
							),
					  'properties' => array(
							'name' => $place,
							'description' => esc_html($excerpt)."<br/>",
							'link' => get_permalink(),
							'marker-color' => '#ffe267',
							'marker-symbol' => $map_icos[$place_itype]
							)
						);
					array_push($geojson['features'], $feature);

				}
				
			endwhile; 
			$mapjson = json_encode($geojson);
			wp_reset_query();
		endif; ?>

	<div class="row">
		<main id="content" class="col-sm-12 content-area" role="main">		
		<article class="page" style="margin-bottom:0px;" >
			<div class="row">
				<div class="col-xs-12 col-sm-9 col-lg-9">
					<h1 class="entry-title" style="font-size:24px;">Places of Interest</h1>
					<p>A personal database of inspiring places around the world that foster local and global impact. Know a place that ought to be on this list?</p>
				</div>
				<div class="col-xs-12 col-sm-3 col-lg-3" style="text-align:right;" >
					<a href="/add-place/" class="btn btn-primary start">Suggest a place</a>
				</div>
			</div>
		
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-lg-12">
				<div id='map'></div>
				<p></p>
				</div>
			</div>
		
		</article>

			<script src='//api.tiles.mapbox.com/mapbox-gl-js/v0.26.0/mapbox-gl.js'></script>		
			<script type='text/javascript'>

			mapboxgl.accessToken = 'pk.eyJ1IjoiZGVrbGVyayIsImEiOiIyLXpKZDFvIn0.qiF1bsGVvvMt6EapjAs6pQ';
			var map = new mapboxgl.Map({
				container: 'map', // container id
				style: 'mapbox://styles/deklerk/ciu4zljnr00bb2hq5nkk9bfyr', //stylesheet location
				center: [11, 25	], // starting position
				zoom: 1 // starting zoom
			});

			map.addControl(new mapboxgl.NavigationControl());

			map.scrollZoom.disable();

			map.on('style.load', function () {
		

				map.addSource("markers", {
					type: "geojson",
					data: <?php echo $mapjson; ?>,
					cluster: true,
					clusterMaxZoom: 14, // Max zoom to cluster points on
					clusterRadius: 50 // Radius of each cluster when clustering points (defaults to 50)
				});

				map.addLayer({
					"id": "markers",
					"interactive": true,
					"type": "symbol",
					"source": "markers",
					"layout": {
						"icon-image": "{marker-symbol}-24",
						"text-field": "{name}",
						"text-offset": [0, 1],
						"text-size": 10,
						"text-anchor": "top",
						"icon-offset": [0,1]
					},
					"paint": {
						"icon-color": "#000",
						"text-color": "#000",
						"text-halo-color": "#fff",
						"text-halo-width": 1,
						"text-halo-blur": 1
					}
				});

				// Display the earthquake data in three layers, each filtered to a range of
				// count values. Each range gets a different fill color.
				var layers = [
					[150, '#fff'],
					[20, '#fff'],
					[0, '#fff']
				];

				layers.forEach(function (layer, i) {
					map.addLayer({
						"id": "cluster-" + i,
						"type": "circle",
						"source": "markers",
						"paint": {
							"circle-color": layer[1],
							"circle-radius": 10
						},
						"filter": i === 0 ?
							[">=", "point_count", layer[0]] :
							["all",
								[">=", "point_count", layer[0]],
								["<", "point_count", layers[i - 1][0]]]
					});
				});

				// Add a layer for the clusters' count labels
				map.addLayer({
					"id": "cluster-count",
					"type": "symbol",
					"source": "markers",
					"layout": {
						"text-field": "{point_count}",
						"text-font": [
							"DIN Offc Pro Medium",
							"Arial Unicode MS Bold"
						],
						"text-size": 10
					}
				});
		
			});

			// When a click event occurs near a marker icon, open a popup at the location of
			// the feature, with description HTML from its properties.
			map.on('click', function (e) {
				var features = map.queryRenderedFeatures(e.point, { layers: ['markers'] });

				if (!features.length) {
					return;
				}

				var feature = features[0];

				// Populate the popup and set its coordinates
				// based on the feature found.
				var popup = new mapboxgl.Popup()
					.setLngLat(feature.geometry.coordinates)
					.setHTML('<h5>' + feature.properties.name + '</h5>' + 
							'<p>' + feature.properties.description +'</p>' + 
							'<p><a href="'+feature.properties.link+'">read more</a></p>')
					.addTo(map);
			});

			// Use the same approach as above to indicate that the symbols are clickable
			// by changing the cursor style to 'pointer'.
			map.on('mousemove', function (e) {
				var features = map.queryRenderedFeatures(e.point, { layers: ['markers'] });
				map.getCanvas().style.cursor = (features.length) ? 'pointer' : '';
			});
	
			</script>
		
		<?php if ( have_posts() ) : ?>
		
				<div id="masonry" class="row">
				<?php while ( have_posts() ) : the_post(); ?>

					<div class="col-xs-12 col-sm-4 col-lg-3 masonry-item">
						<?php get_template_part( 'placeloop', get_post_format() ); ?>
					</div>

				<?php endwhile; ?>
			<!-- #masonry --></div>

			<?php nuthemes_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'archive' ); ?>

		<?php endif; ?>

		<!-- #content --></main>

	<!-- .row --></div>

<?php get_footer(); ?>
