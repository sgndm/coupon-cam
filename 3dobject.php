<!DOCTYPE html>
<html lang="en">
	<head>
		<title>3d Model</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<style>
			body {
				font-family: Monospace;
				background-color: #000;
				color: #fff;
				margin: 0px;
				overflow: hidden;
			}
			#info {
				color: #fff;
				position: absolute;
				top: 10px;
				width: 100%;
				text-align: center;
				z-index: 100;
				display:block;
			}
			#info a, .button { color: #f00; font-weight: bold; text-decoration: underline; cursor: pointer }
		</style>
	</head>

	<body>

		<script src="resources/assets/three.js-master/build/three.js"></script>

		<script src="resources/assets/three.js-master/examples/js/controls/OrbitControls.js"></script>

		<script src="resources/assets/three.js-master/examples/js/curves/NURBSCurve.js"></script>
		<script src="resources/assets/three.js-master/examples/js/curves/NURBSUtils.js"></script>
		<script src="resources/assets/three.js-master/examples/js/loaders/FBXLoader.js"></script>

		<script src="resources/assets/three.js-master/examples/js/Detector.js"></script>
		<script src="resources/assets/three.js-master/examples/js/libs/stats.min.js"></script>

		<script>
			if ( ! Detector.webgl ) Detector.addGetWebGLMessage();
			var container, stats, controls;
			var camera, scene, renderer, light;
			var clock = new THREE.Clock();
			var mixers = [];
			init();
			function init() {
				container = document.createElement( 'div' );
				document.body.appendChild( container );
				camera = new THREE.PerspectiveCamera( 45, window.innerWidth / window.innerHeight, 1, 2000 );
				scene = new THREE.Scene();
				// grid
				var gridHelper = new THREE.GridHelper( 28, 28, 0x303030, 0x303030 );
				gridHelper.position.set( 0, - 0.04, 0 );
				scene.add( gridHelper );
				// stats
				stats = new Stats();
				container.appendChild( stats.dom );
				// model
				var manager = new THREE.LoadingManager();
				manager.onProgress = function( item, loaded, total ) {
					console.log( item, loaded, total );
				};
				var onProgress = function( xhr ) {
					if ( xhr.lengthComputable ) {
						var percentComplete = xhr.loaded / xhr.total * 100;
						console.log( Math.round( percentComplete, 2 ) + '% downloaded' );
					}
				};
				var onError = function( xhr ) {
					console.error( xhr );
				};
				var loader = new THREE.FBXLoader( manager );
				loader.load( 'resources/assets/media/<?PHP echo $_GET['file']; ?>', function( object ) {
					object.mixer = new THREE.AnimationMixer( object );
					mixers.push( object.mixer );
					var action = object.mixer.clipAction( object.animations[ 0 ] );
					action.play();
					scene.add( object );
				}, onProgress, onError );
				loader.load( 'resources/assets/three.js-master/examples/models/fbx/nurbs.fbx', function( object ) {
					scene.add( object );
				}, onProgress, onError );
				renderer = new THREE.WebGLRenderer();
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth, window.innerHeight );
				container.appendChild( renderer.domElement );
				// controls, camera
				controls = new THREE.OrbitControls( camera, renderer.domElement );
				controls.target.set( 0, 12, 0 );
				camera.position.set( 2, 18, 28 );
				controls.update();
				window.addEventListener( 'resize', onWindowResize, false );
				light = new THREE.HemisphereLight(0xffffff, 0x444444, 1.0);
				light.position.set(0, 1, 0);
				scene.add(light);
				light = new THREE.DirectionalLight(0xffffff, 1.0);
				light.position.set(0, 1, 0);
				scene.add(light);
				animate();
			}
			function onWindowResize() {
				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();
				renderer.setSize( window.innerWidth, window.innerHeight );
			}
			//
			function animate() {
				requestAnimationFrame( animate );
				if ( mixers.length > 0 ) {
					for ( var i = 0; i < mixers.length; i ++ ) {
						mixers[ i ].update( clock.getDelta() );
					}
				}
				stats.update();
				render();
			}
			function render() {
				renderer.render( scene, camera );
			}
		</script>

	</body>
</html>