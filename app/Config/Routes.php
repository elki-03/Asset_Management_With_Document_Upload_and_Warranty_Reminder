<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\HardwareController;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Lade alle Shield-Routen (Login, Register, Logout...)
// service('auth')->routes($routes); // Shield trägt seine Routen automatisch ein --> alle
service('auth')->routes($routes, ['except' => ['register']]); // without register

//Wegen SICHERHEIT wollen wir keine AUto-Routen!! No auto routes bcs of security!
$routes->setAutoRoute(false);

$routes->get('dashboard', 'DashboardController::showDashboard');//show Dashboard page 
$routes->get('hardware/hardware_asset_table', 'HardwareController::index');//HW-Assets read

$routes->get('hardware/hardware_asset_detail/(:num)', 'HardwareController::showDetail/$1');//HW-Asset-Detail read
//$routes->get('hardware/hardware_asset_detail/(:num)', 'HardwareController::index/$1');//HW-Asset-Detail read

// $routes->get('hardware/hardware_asset_detail_create', 'HardwareController::showCreateDetailForm');//shows HW-Asset-Detail-Create

// Create: leeres Formular
// $routes->get('hardware/hardware_asset_detail_create', 'HardwareController::showCreateDetailForm'); //anderer name

// // Edit: Formular mit bestehenden Daten befüllen (GET)
// $routes->get('hardware/hardware_asset_detail_edit/(:num)', 'HardwareController::showEditDetailForm/$1');// anderer name

// // Update: Daten speichern (POST)
// $routes->post('hardware/update/(:num)', 'HardwareController::update/$1');

// // Create: Daten speichern (POST)
// $routes->post('hardware/createHw', 'HardwareController::createHw');

//delete hw 
// // $routes->get('hardware/deleteHw/(:num)', 'HardwareController::deleteHw/$1');//--> prüfen ob sicherer machen wegen spoofing etc
// $routes->post('hardware/deleteHw/(:num)', 'HardwareController::deleteHw/$1'); //post weil sonst löschen bei nur Aufrufn der Seite

// document upload of hardware hardwareID
// $routes->get('/hardware/(:num)/documents', 'HardwareDocumentController::showDocument/$1');
// $routes->post('/hardware/(:num)/documents/upload', 'HardwareDocumentController::uploadDocument/$1');


// routes for upload: show single hw, download, delete
$routes->get('hardware/(:num)/documents/(:num)/show', 'HardwareDocumentController::showSingleHwDoc/$1/$2');
// Das _method=DELETE im Formular funktioniert dann, weil CI4 Method Spoofing tatsächlich standardmäßig aktiviert ist.
//wasnn ist das der Fall?
// $routes->delete('hardware/(:num)/documents/(:num)/delete', 'HardwareDocumentController::deleteHwDoc/$1/$2'); //Das _method=DELETE im Formular funktioniert dann, weil CI4 Method Spoofing tatsächlich standardmäßig aktiviert ist.

// was draufsteht (POST) ist auch das, was tatsächlich passiert. // Ein Angreifer der POST nicht kann, kann auch DELETE nicht. Der Browser blockiert beide gleichermaßen von fremden Seiten – das macht der CSRF-Schutz, nicht der HTTP-Verb.
// $routes->post('hardware/(:num)/documents/(:num)/delete', 'HardwareDocumentController::deleteHwDoc/$1/$2');

// EmailTutorial
// Nur explizite HTTP-Verben – NIEMALS $routes->add() für Formulare!
// Grund: $routes->add() akzeptiert GET und POST gleichzeitig, was CSRF umgehen kann.
$routes->get('/kontakt',  'ContactController::index');
$routes->post('/kontakt', 'ContactController::send');
$routes->get('/kontakt/danke', 'ContactController::success');


//Warranty
// $routes->get('/garantie', 'WarrantyController::showWarrantyForm'); //nur über Garntie Button brauchen wir nicht
// $routes->post('/garantie', 'WarrantyController::saveHwWarranty');
$routes->get('/garantie/fertig', 'ContactController::success'); //nochmal ändern nur zu testzwecken

//open warranty part with documentID as data in background
$routes->get('/hardware/(:num)/documents/(:num)/warranty', 'HardwareDocumentController::openWarrantyWindow/$1/$2');

// Logout
// $routes->get('logout', 'AuthController::logout');
$routes->post('logout', 'AuthController::logout'); //better post than get bcs "change of state"

// admin and superadmin only 
$routes->group('', ['filter' => 'group:admin,superadmin'], static function($routes) { //static coz recommendation from official ci4 -> performance
    $routes->get('hardware/hardware_asset_detail_create', 'HardwareController::showCreateDetailForm');
    $routes->get('hardware/hardware_asset_detail_create', 'HardwareController::showCreateDetailForm'); //anderer name
    $routes->get('hardware/hardware_asset_detail_edit/(:num)', 'HardwareController::showEditDetailForm/$1');
    $routes->post('hardware/update/(:num)', 'HardwareController::update/$1');
    $routes->post('hardware/createHw', 'HardwareController::createHw');
    $routes->post('hardware/(:num)/documents/upload', 'HardwareDocumentController::uploadDocument/$1');
    $routes->get('/hardware/(:num)/documents', 'HardwareDocumentController::showDocument/$1');
    $routes->post('/garantie', 'WarrantyController::saveHwWarranty');
    $routes->post('hardware/deleteHw/(:num)', 'HardwareController::deleteHw/$1');
    $routes->post('hardware/(:num)/documents/(:num)/delete', 'HardwareDocumentController::deleteHwDoc/$1/$2');
});






