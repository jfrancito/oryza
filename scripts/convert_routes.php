<?php

$input = file_get_contents(__DIR__ . '/../routes/web_legacy.php');

$controllers = [
    'ActivoFijoController',
    'AlmacenActivoFijoController',
    'AlmacenActivoFijoTransferidoController',
    'AnalisisEstadisticosAniosController',
    'AnalisisEstadisticosController',
    'AsignarReglaController',
    'AtenderPedidoDespachoController',
    'BarraMasivoController',
    'BonosController',
    'CalcularBonosController',
    'CarteraController',
    'CategoriaController',
    'ComisionConfiguracionController',
    'ComisionPlanillaController',
    'ComisionReporteController',
    'ContablilidadReporteController',
    'CorreoController',
    'DepreciacionActivoFijoController',
    'DespachoCarroController',
    'DespachoReporteController',
    'DetraccionController',
    'EstadoCuentaReporteController',
    'ExportarFormatoIachController',
    'ExportarFormatoIatrController',
    'GeneralAjaxController',
    'GestionContactoController',
    'GestionProductoController',
    'GestionReglaController',
    'ImportExcelController',
    'LeerxmlController',
    'NotaCreditoController',
    'NotaCreditoMasivoController',
    'OrdenPedidoController',
    'OrdenPedidoReporteController',
    'PedidoDespachoController',
    'PickingController',
    'PickingReporteController',
    'ProductoController',
    'ProductoReporteController',
    'PruebaController',
    'ReglaController',
    'ReglaReporteController',
    'TransferenciaController',
    'UserController'
];

$output = "<?php\n\nuse Illuminate\Support\Facades\Route;\n";
foreach ($controllers as $c) {
    $output .= "use App\Http\Controllers\\$c;\n";
}
$output .= "\n";

// Remove the opening <?php tag from legacy
$body = preg_replace('/^<\?php\s*/i', '', $input);

// Replace Route::group(['middleware' => ['guestaw']], function () {
$body = preg_replace("/Route::group\(\s*\[\s*['\"]middleware['\"]\s*=>\s*\[\s*['\"]guestaw['\"]\s*\]\s*\]\s*,\s*function\s*\(\)\s*\{/", "Route::middleware(['guestaw'])->group(function () {", $body);

// Replace Route::group(['middleware' => ['authaw']], function () {
$body = preg_replace("/Route::group\(\s*\[\s*['\"]middleware['\"]\s*=>\s*\[\s*['\"]authaw['\"]\s*\]\s*\]\s*,\s*function\s*\(\)\s*\{/", "Route::middleware(['authaw'])->group(function () {", $body);

// Replace 'uses' => 'Controller@action'
$body = preg_replace_callback("/['\"]uses['\"]\s*=>\s*['\"]([A-Za-z0-9_]+Controller)@([A-Za-z0-9_]+)['\"]/", function ($matches) {
    return "'uses' => [" . $matches[1] . "::class, '" . $matches[2] . "']";
}, $body);

// Replace 'Controller@action'
$body = preg_replace_callback("/['\"]([A-Za-z0-9_]+Controller)@([A-Za-z0-9_]+)['\"]/", function ($matches) {
    return "[" . $matches[1] . "::class, '" . $matches[2] . "']";
}, $body);

$output .= $body;

file_put_contents(__DIR__ . '/../routes/web.php', $output);
echo "Routes converted successfully!\n";

