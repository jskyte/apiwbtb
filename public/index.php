<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//use Slim\Factory\AppFactory;

require '../vendor/autoload.php';

require '../includes/DbOperations.php';

$app = new \Slim\App;

$app->get('/allprovinsi', function(Request $request, Response $response) {

	$db = new DbOperations;
	$provinsis = $db->getAllProvinsi();

	$response_data = array();
	$response_data['error'] = false;
	$response_data['provinsi'] = $provinsis;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});

$app->get('/allkategori/{id}', function(Request $request, Response $response, array $args){

	$id = $args['id'];

	$db = new DbOperations;
	$kategoris = $db->getAllKategori($id);

	$response_data = array();
	$response_data['error'] = false;
	$response_data['kategori'] = $kategoris;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

}); 

$app->get('/viewkaryabudaya/{provinsi}/{kategori}', function(Request $request, Response $response, array $args) {

	$id1 = $args['provinsi'];
	$id2 = $args['kategori'];

	$db = new DbOperations;
	$kbudayas = $db->getKaryaBudaya($id1, $id2);

	$response_data = array();
	$response_data['error'] = false;
	$response_data['karyabudaya'] = $kbudayas;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);
});

$app->get('/detilbudaya/{id}', function(Request $request, Response $response, array $args){

	$id = $args['id'];

	$db = new DbOperations;
	$kdbudayas = $db->getDetailKaryaBudaya($id);
	$dtunsurs = $db->getDetailUnsurKaryaBudaya($id);
	$maestro = $db->getMaestro($id);
	$penanggungjawab = $db->getPenanggungJawab($id);
	$pelestarian = $db->getPelestarian($id);

	$response_data = array();
	$response_data['error'] = false;
	$response_data['DetailKaryaBudaya'] = $kdbudayas;
	$response_data['DetailUnsur'] = $dtunsurs;
	$response_data['Maestro'] = $maestro;
	$response_data['Penanggungjawab'] = $penanggungjawab;
	$response_data['Pelestarian'] = $pelestarian;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

}); 

$app->get('/detilunsurbudaya/{id}', function(Request $request, Response $response, array $args) {

	$id = $args['id'];

	$db = new DbOperations;
	$dtunsurs = $db->getDetailUnsurKaryaBudaya($id);

	$response_data = array();
	$response_data['error'] = false;
	$response_data['DetailUnsur'] = $dtunsurs;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});

$app->get('/detilpenanggungjawab/{id}', function(Request $request, Response $response, array $args) {

	$id = $args['id'];

	$db = new DbOperations;
	$pngjwb = $db->getDetailPenanggungJawab($id);

	$response_data = array();
	$response_data['error'] = false;
	$response_data['DetailPenanggungJawab'] = $pngjwb;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});

$app->get('/kabupatenkota/{id}', function(Request $request, Response $response, array $args) {

	$id = $args['id'];

	$db = new DbOperations;
	$kabupatenkota = $db->getKabupatenKota($id);

	$response_data = array();
	$response_data['error'] = false;
	$response_data['KabupatenKota'] = $kabupatenkota;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});

$app->get('/kecamatan/{id}', function(Request $request, Response $response, array $args) {

	$id = $args['id'];

	$db = new DbOperations;
	$kecamatan = $db->getKecamatan($id);

	$response_data = array();
	$response_data['error'] = false;
	$response_data['Kecamatan'] = $kecamatan;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});

$app->get('/haversine/{lat}/{lng}', function(Request $request, Response $response, array $args) {

	$lat = $args['lat'];
	$lng = $args['lng'];

	$db = new DbOperations;
	$haversine = $db->Haversine($lat, $lng);

	$response_data = array();
	$response_data['error'] = false;
	$response_data['Haversine'] = $haversine;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});

$app->get('/allpencatatan', function(Request $request, Response $response) {

	$db = new DbOperations;
	$pencatatans = $db->getAllPencatatan();

	$response_data = array();
	$response_data['error'] = false;
	$response_data['Pencatatan'] = $pencatatans;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});

$app->get('/allpenetapan', function(Request $request, Response $response) {

	$db = new DbOperations;
	$penetapans = $db->getAllPenetapan();

	$response_data = array();
	$response_data['error'] = false;
	$response_data['Penetapan'] = $penetapans;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});

$app->get('/searchkb/{kb}', function(Request $request, Response $response, array $args) {

	$kb = $args['kb'];

	$db = new DbOperations;
	$searchkbs = $db->searchKaryaBudaya($kb);

	$response_data = array();
	$response_data['error'] = false;
	$response_data['SearchKb'] = $searchkbs;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});

$app->get('/searchmaestro/{kb}', function(Request $request, Response $response, array $args) {

	$kb = $args['kb'];

	$db = new DbOperations;
	$searchkbs = $db->searchMaestro($kb);

	$response_data = array();
	$response_data['error'] = false;
	$response_data['SearchMaestro'] = $searchkbs;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});

$app->get('/alllocations', function(Request $request, Response $response) {

	$db = new DbOperations;
	$locations = $db->getAllLocations();

	$response_data = array();
	$response_data['error'] = false;
	$response_data['location'] = $locations;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});

$app->get('/allbudayas', function(Request $request, Response $response) {

	$db = new DbOperations;
	$budayas = $db->getAllKaryaBudaya();

	$response_data = array();
	$response_data['error'] = false;
	$response_data['allkaryabudaya'] = $budayas;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});

$app->get('/allmaestro', function(Request $request, Response $response) {

	$db = new DbOperations;
	$maestros = $db->getAllMaestro();

	$response_data = array();
	$response_data['error'] = false;
	$response_data['allmaestro'] = $maestros;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});

$app->get('/slider', function(Request $request, Response $response) {

	$db = new DbOperations;
	$sliders = $db->getFotoSlider();

	$response_data = array();
	$response_data['error'] = false;
	$response_data['slider'] = $sliders;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});

$app->get('/detailhaversine/{kb}', function(Request $request, Response $response, array $args) {

	$kdpngjwb = $args['kb'];

	$db = new DbOperations;
	$searchkbs = $db->getDetailHaversine($kdpngjwb);

	$response_data = array();
	$response_data['error'] = false;
	$response_data['DetailHaversine'] = $searchkbs;

	$response->write(json_encode($response_data));

	return $response	
	->withHeader('Content-type', 'application/json')
	->withStatus(200);

});


$app->run();