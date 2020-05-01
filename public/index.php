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

$app->run();