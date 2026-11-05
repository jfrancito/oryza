<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivoFijoController;
use App\Http\Controllers\AlmacenActivoFijoController;
use App\Http\Controllers\AlmacenActivoFijoTransferidoController;
use App\Http\Controllers\AnalisisEstadisticosAniosController;
use App\Http\Controllers\AnalisisEstadisticosController;
use App\Http\Controllers\AsignarReglaController;
use App\Http\Controllers\AtenderPedidoDespachoController;
use App\Http\Controllers\BarraMasivoController;
use App\Http\Controllers\BonosController;
use App\Http\Controllers\CalcularBonosController;
use App\Http\Controllers\CarteraController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ComisionConfiguracionController;
use App\Http\Controllers\ComisionPlanillaController;
use App\Http\Controllers\ComisionReporteController;
use App\Http\Controllers\ContablilidadReporteController;
use App\Http\Controllers\CorreoController;
use App\Http\Controllers\DepreciacionActivoFijoController;
use App\Http\Controllers\DespachoCarroController;
use App\Http\Controllers\DespachoReporteController;
use App\Http\Controllers\DetraccionController;
use App\Http\Controllers\EstadoCuentaReporteController;
use App\Http\Controllers\ExportarFormatoIachController;
use App\Http\Controllers\ExportarFormatoIatrController;
use App\Http\Controllers\GeneralAjaxController;
use App\Http\Controllers\GestionContactoController;
use App\Http\Controllers\GestionProductoController;
use App\Http\Controllers\GestionReglaController;
use App\Http\Controllers\ImportExcelController;
use App\Http\Controllers\LeerxmlController;
use App\Http\Controllers\NotaCreditoController;
use App\Http\Controllers\NotaCreditoMasivoController;
use App\Http\Controllers\OrdenPedidoController;
use App\Http\Controllers\OrdenPedidoReporteController;
use App\Http\Controllers\PedidoDespachoController;
use App\Http\Controllers\PickingController;
use App\Http\Controllers\PickingReporteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductoReporteController;
use App\Http\Controllers\PruebaController;
use App\Http\Controllers\ReglaController;
use App\Http\Controllers\ReglaReporteController;
use App\Http\Controllers\TransferenciaController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/********************** USUARIOS *************************/
// header('Access-Control-Allow-Origin:  *');
// header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
// header('Access-Control-Allow-Headers: *');

Route::middleware(['guestaw'])->group(function () {

	Route::any('/', [UserController::class, 'actionLogin']);
	Route::any('/login', [UserController::class, 'actionLogin']);
	Route::any('/acceso', [UserController::class, 'actionAcceso']);
	Route::any('/accesobienvenido/{idempresa}/{idcargo}', [UserController::class, 'actionAccesoBienvenido']);

});

Route::get('/cerrarsession', [UserController::class, 'actionCerrarSesion']);
Route::get('/cambiarperfil', [UserController::class, 'actionCambiarPerfil']);
Route::get('/despacho/print-pdf', ['as' => 'despacho.printpdf', 'uses' => [OrdenPedidoController::class, 'RepSalida']]);
Route::any('/excel-orden-despacho-email/{idopcion}/{idordendespacho}', [AtenderPedidoDespachoController::class, 'actionExcelOrdenDespachoEmail']);
Route::any('/pedido-estado-excel-automatico', [OrdenPedidoReporteController::class, 'actionPedidoEstadoExcelAutomatico']);
Route::any('/contrato-pendiente', [OrdenPedidoReporteController::class, 'actionContratoPendiente']);
Route::any('/documentos-sin-enviar-excel-automatico', [OrdenPedidoReporteController::class, 'actionDocumentoSinEnviarExcelAutomatico']);


Route::get('/leerxml', [LeerxmlController::class, 'actionLeerXml']);
Route::get('/generartoken', [LeerxmlController::class, 'actionGenerarToken']);
Route::get('/consultarcpe', [LeerxmlController::class, 'actionConsultarCpe']);

Route::get('/descargarexcel', [PruebaController::class, 'actionDRS']);


Route::middleware(['authaw'])->group(function () {


	Route::get('/bienvenido', [UserController::class, 'actionBienvenido']);
	Route::get('/gestion-de-analitica-ventas/{idopcion}', [AnalisisEstadisticosController::class, 'actionVentaAutoservicio']);
	Route::any('/ajax-listado-de-ventasxautoservicio', [AnalisisEstadisticosController::class, 'actionAjaxListarVentasxAutoservicio']);
	Route::any('/ajax-listado-de-clientexanio', [AnalisisEstadisticosController::class, 'actionAjaxListarClientexCliente']);

	//Route::get('/gestion-de-analitica-ventas/{idopcion}', [AnalisisEstadisticosController::class, 'actionVentas']);
	Route::any('/ajax-listado-de-analitica', [AnalisisEstadisticosController::class, 'actionAjaxListarVentas']);
	Route::any('/ajax-listado-de-ventasxproducto', [AnalisisEstadisticosController::class, 'actionAjaxListarVentasxProducto']);
	Route::any('/ajax-listado-detalle-ventasxproducto', [AnalisisEstadisticosController::class, 'actionAjaxListarDetalleVentasxProducto']);
	Route::any('/ajax-modal-autoservicio-filtro', [AnalisisEstadisticosController::class, 'actionAjaxModalAutoservicioFiltro']);



	Route::get('/gestion-de-ventas-autoservicio-anios/{idopcion}', [AnalisisEstadisticosAniosController::class, 'actionVentaAutoservicioEntreAnios']);
	Route::any('/ajax-listado-de-ventasxautoservicioanio', [AnalisisEstadisticosAniosController::class, 'actionAjaxListarVentasxAutoservicioAnio']);


	Route::any('/gestion-de-usuarios/{idopcion}', [UserController::class, 'actionListarUsuarios']);
	Route::any('/agregar-usuario/{idopcion}', [UserController::class, 'actionAgregarUsuario']);
	Route::any('/modificar-usuario/{idopcion}/{idusuario}', [UserController::class, 'actionModificarUsuario']);
	Route::any('/ajax-activar-perfiles', [UserController::class, 'actionAjaxActivarPerfiles']);

	Route::any('/gestion-de-roles/{idopcion}', [UserController::class, 'actionListarRoles']);
	Route::any('/agregar-rol/{idopcion}', [UserController::class, 'actionAgregarRol']);
	Route::any('/modificar-rol/{idopcion}/{idrol}', [UserController::class, 'actionModificarRol']);

	Route::any('/gestion-de-permisos/{idopcion}', [UserController::class, 'actionListarPermisos']);
	Route::any('/ajax-listado-de-opciones', [UserController::class, 'actionAjaxListarOpciones']);
	Route::any('/ajax-activar-permisos', [UserController::class, 'actionAjaxActivarPermisos']);

	Route::any('/gestion-de-precio-producto/{idopcion}', [ProductoController::class, 'actionPrecioProducto']);
	Route::any('/ajax-guardar-precio-producto', [ProductoController::class, 'actionAjaxGuardarPrecioProducto']);

	Route::any('/gestion-de-configuracion-producto/{idopcion}', [ProductoController::class, 'actionConfiguracionProducto']);
	Route::any('/ajax-guardar-configuracion-producto', [ProductoController::class, 'actionAjaxGuardarConfiguracionProducto']);
	Route::any('/ajax-guardar-producto-indmobil', [ProductoController::class, 'actionAjaxGuardarProductoIndmobil']);


	Route::get('/gestion-de-regla-del-producto/{idopcion}', [AsignarReglaController::class, 'actionListarClienteRegla']);
	Route::any('/ajax-modal-detalle', [AsignarReglaController::class, 'actionAjaxModalDetalle']);
	Route::any('/ajax-modal-detalle-precio-regular', [AsignarReglaController::class, 'actionAjaxModalDetallePrecioRegular']);
	Route::any('/ajax-detalle-regla', [AsignarReglaController::class, 'actionAjaxDetalleRegla']);
	Route::any('/ajax-agregar-regla', [AsignarReglaController::class, 'actionAjaxAgregarRegla']);
	Route::any('/ajax-agregar-regla-precio-regular', [AsignarReglaController::class, 'actionAjaxAgregarReglaPrecioRegular']);
	Route::any('/ajax-precio-regular-descuento', [AsignarReglaController::class, 'actionAjaxPrecioRegularDescuento']);


	Route::any('/ajax-actualizar-lista-regla', [AsignarReglaController::class, 'actionAjaxActualizarListaRegla']);
	Route::any('/ajax-actualizar-modal-regla', [AsignarReglaController::class, 'actionAjaxActualizarModalRegla']);
	Route::any('/ajax-actualizar-lista-regla-pr', [AsignarReglaController::class, 'actionAjaxActualizarListaReglaPrecioRegular']);
	Route::any('/ajax-actualizar-modal-regla-pr', [AsignarReglaController::class, 'actionAjaxActualizarModalReglaPrecioRegular']);
	Route::any('/ajax-eliminar-regla', [AsignarReglaController::class, 'actionAjaxEliminarRegla']);
	Route::any('/ajax-guardar-precio-producto-contrato', [AsignarReglaController::class, 'actionAjaxGuardarPrecioProductoContrato']);
	Route::any('/ajax-cambiar-estado-contrato', [AsignarReglaController::class, 'actionAjaxCambiarEstadoContrato']);

	Route::any('/gestion-de-regla-de-negociacion/{idopcion}', [ProductoController::class, 'actionListarReglaNegociacion']);
	Route::any('/agregar-regla-negociacion/{idopcion}', [ProductoController::class, 'actionAgregarNegociacion']);
	Route::any('/modificar-regla-negociacion/{idopcion}/{idregla}', [ProductoController::class, 'actionModificarNegociacion']);


	Route::any('/gestion-de-regla-de-precio-producto/{idopcion}', [ProductoController::class, 'actionListarReglaPrecio']);
	Route::any('/agregar-regla-precio/{idopcion}', [ProductoController::class, 'actionAgregarPrecio']);
	Route::any('/modificar-regla-precio/{idopcion}/{idregla}', [ProductoController::class, 'actionModificarPrecio']);

	Route::any('/ajax-lista-reglas-descuento', [ProductoController::class, 'actionListaReglasDescuento']);

	Route::any('/gestion-masiva-regla-precio/{idopcion}/{idregla}', [GestionReglaController::class, 'actionGestionMasivaReglaPrecio']);
	Route::any('/asignar_reglas_masiva', [GestionReglaController::class, 'actionAsignarReglas']);
	Route::any('/ajax-lista-contrato-producto_masivo', [GestionReglaController::class, 'actionAjaxListaContratoProductoMasiva']);
	Route::any('/ajax-actualizar-reglas-masivas', [GestionReglaController::class, 'actionAjaxActualizarReglasMasivas']);
	Route::any('/ajax-elimnar-reglas-masivas', [GestionReglaController::class, 'actionAjaxEliminarReglasMasivas']);

	Route::any('/gestion-de-precio-regular-producto/{idopcion}', [GestionProductoController::class, 'actionGestionMasivaPrecioProducto']);
	Route::any('/ajax-lista-precio-producto_masivo', [GestionProductoController::class, 'actionAjaxListaPrecioProductoMasiva']);
	Route::any('/ajax-actualizar-precio-producto-masivas', [GestionProductoController::class, 'actionAjaxActualizarPrecioProductoMasivas']);


	Route::any('/gestion-de-contacto/{idopcion}', [GestionContactoController::class, 'actionGestionContacto']);
	// Route::any('/ajax-lista-precio-producto_masivo', [GestionProductoController::class, 'actionAjaxListaPrecioProductoMasiva']);
	// Route::any('/ajax-actualizar-precio-producto-masivas', [GestionProductoController::class, 'actionAjaxActualizarPrecioProductoMasivas']);



	Route::any('/gestion-de-regla-de-cupon-producto/{idopcion}', [ProductoController::class, 'actionListarReglaCupones']);
	Route::any('/agregar-regla-cupon/{idopcion}', [ProductoController::class, 'actionAgregarCupon']);
	Route::any('/modificar-regla-cupon/{idopcion}/{idregla}', [ProductoController::class, 'actionModificarCupon']);
	Route::any('/ajax-tramo-deuda', [OrdenPedidoController::class, 'actionAjaxDeudaSectorizada']);

	Route::any('/gestion-de-regla-de-precio-regular/{idopcion}', [ProductoController::class, 'actionListarReglaPrecioRegular']);
	Route::any('/agregar-regla-precio-regular/{idopcion}', [ProductoController::class, 'actionAgregarReglaPrecioRegular']);
	Route::any('/modificar-regla-precio-regular/{idopcion}/{idregla}', [ProductoController::class, 'actionModificarPrecioRegular']);

	Route::any('/ajax-generarcupon', [ProductoController::class, 'actionAjaxGenerarCupon']);

	Route::any('/gestion-de-toma-de-pedido/{idopcion}', [OrdenPedidoController::class, 'actionListarPedido']);
	Route::any('/agregar-orden-pedido/{idopcion}', [OrdenPedidoController::class, 'actionAgregarOrdenPedido']);
	Route::any('/ajax-direcion-cliente', [OrdenPedidoController::class, 'actionAjaxDireccioncliente']);
	Route::any('/ajax-regla-producto', [OrdenPedidoController::class, 'actionAjaxReglaProducto']);
	Route::any('/ajax-modal-detalle-pedido-rechazar', [OrdenPedidoController::class, 'actionAjaxDetallePedidoRechazar']);
	Route::any('/imprimir-pedido/{idpedido}', [OrdenPedidoReporteController::class, 'actionImprimirPedido']);
	Route::any('/ajax-modal-detalle-deuda', [OrdenPedidoController::class, 'actionImprimirDetalleDeuda']);
	Route::any('/ajax-actualizar-deuda-cliente', [OrdenPedidoController::class, 'actionActualizarDeudaCliente']);

	Route::any('/imprimir-pedido-transportista/{idpedido}/{accion}/{detalle}', [OrdenPedidoReporteController::class, 'actionImprimirPedidoTransportista']);
	Route::any('/obsequio-orden-pedido/{idpedido}/{idopcion}', [OrdenPedidoController::class, 'actionObsequioOrdenPedido']);
	Route::any('/ajax-regla-producto-obsequio', [OrdenPedidoController::class, 'actionAjaxReglaProductoObsequio']);

	Route::any('/gestion-de-orden-de-pedido/{idopcion}', [OrdenPedidoController::class, 'actionListarTomaPedido']);
	Route::any('/ajax-listado-de-toma-pedidos', [OrdenPedidoController::class, 'actionAjaxListarTomaPedido']);
	Route::any('/ajax-modal-detalle-pedido', [OrdenPedidoController::class, 'actionAjaxDetallePedido']);
	Route::any('/ajax-modal-detalle-pedido-transportista', [OrdenPedidoController::class, 'actionAjaxDetallePedidoTransportista']);


	Route::any('/gestion-de-orden-de-pedido-anulacion/{idopcion}', [OrdenPedidoController::class, 'actionListarTomaPedidoAnulacion']);
	Route::any('/ajax-modal-detalle-pedido-anulacion', [OrdenPedidoController::class, 'actionAjaxDetallePedidoAnulacion']);
	Route::any('/ajax-modal-detalle-pedido-anulacion-observacion', [OrdenPedidoController::class, 'actionAjaxModalPedidoAnulacionObservcion']);
	Route::any('/enviar-a-rechazar-siete-dias/{idopcion}', [OrdenPedidoController::class, 'actionEnviarRechazarSieteDias']);



	Route::any('/enviar-a-osiris/{idopcion}', [OrdenPedidoController::class, 'actionEnviarOsiris']);
	Route::any('/enviar-a-rechazar/{idopcion}', [OrdenPedidoController::class, 'actionEnviarRechazar']);
	Route::any('/enviar-a-osiris-rechazar/{idopcion}', [OrdenPedidoController::class, 'actionEnviarOsirisRechazar']);
	Route::any('/ajax-modal-detalle-pedido-mobil', [OrdenPedidoController::class, 'actionAjaxDetallePedidoMobil']);
	Route::any('/ajax-listado-de-toma-pedidos-vendedor', [OrdenPedidoController::class, 'actionAjaxListarTomaPedidoVendedor']);
	Route::any('/gestion-de-orden-de-pedido-autorizacion/{idopcion}', [OrdenPedidoController::class, 'actionListarTomaPedidoAutorizacion']);
	Route::any('/ajax-listado-de-toma-pedidos-autorizacion', [OrdenPedidoController::class, 'actionAjaxListarTomaPedidoAutorizacion']);
	Route::any('/ajax-modal-detalle-pedido-autorizacion', [OrdenPedidoController::class, 'actionAjaxDetallePedidoAutorizacion']);
	Route::any('/autorizar-pedido/{idopcion}', [OrdenPedidoController::class, 'actionAutorizarPedido']);
	Route::any('/no-autorizar-pedido/{idopcion}', [OrdenPedidoController::class, 'actionNoAutorizarPedido']);
	Route::any('/ajax-guardar-cantidad-producto-pedido', [OrdenPedidoController::class, 'actionAjaxGuardarCantidadProductoPedido']);
	Route::any('/ajax-guardar-precio-producto-pedido', [OrdenPedidoController::class, 'actionAjaxGuardarPrecioProductoPedido']);
	Route::any('/ajax-modal-deuda-cliente', [OrdenPedidoController::class, 'actionAjaxDeudaCliente']);
	Route::any('/ajax-modal-limite-credito', [OrdenPedidoController::class, 'actionAjaxLimiteCredito']);
	Route::any('/ajax-relacion-producto-obsequio', [OrdenPedidoController::class, 'actionAjaxObsequioRelacion']);

	Route::any('/ajax-modal-seguimiento-pedido-mobil', [OrdenPedidoController::class, 'actionAjaxSeguimientoPedidoMobil']);


	/************************************** GENERALES ********************************************/
	Route::any('/ajax-canal-responsable', [GeneralAjaxController::class, 'actionCanalResponsable']);
	Route::any('/ajax-cliente-responsable', [GeneralAjaxController::class, 'actionClienteResponsable']);
	Route::any('/ajax-subcanal_canal-responsable', [GeneralAjaxController::class, 'actionSubCanalCanalResponsable']);

	/************************************** Reportes ********************************************/

	Route::any('/reporte-reglas-cliente/{idopcion}', [ReglaReporteController::class, 'actionReglasXcliente']);
	Route::any('/ajax-reporte-lista-regla-clientes', [ReglaReporteController::class, 'actionAjaxReglasxCliente']);
	Route::any('/reglas-cliente-excel/{idcuenta}/{idtipoprecio}', [ReglaReporteController::class, 'actionReglasClienteExcel']);
	Route::any('/reglas-cliente-pdf/{idcuenta}/{idtipoprecio}', [ReglaReporteController::class, 'actionReglaClientePDF']);

	Route::any('/reporte-precio-producto-cliente/{idopcion}', [ProductoReporteController::class, 'actionPrecioProductoXcliente']);
	Route::any('/ajax-reporte-lista-precio-producto', [ProductoReporteController::class, 'actionAjaxProductosxCliente']);
	Route::any('/precio-producto-cliente-excel/{idcuenta}/{idtipoprecio}', [ProductoReporteController::class, 'actionPrecioProductoClienteExcel']);
	Route::any('/precio-producto-cliente-pdf/{idcuenta}/{idtipoprecio}', [ProductoReporteController::class, 'actionPrecioProductoClientePDF']);

	Route::any('/reporte-evolucion-precio-producto-cliente/{idopcion}', [ProductoReporteController::class, 'actionEvolucionPrecioProductoXcliente']);
	Route::any('/ajax-reporte-lista-evolucion-precio-producto', [ProductoReporteController::class, 'actionAjaxEvolucionProductosxCliente']);
	Route::any('/evolucion-precio-producto-cliente-excel/{idcuenta}/{fechadia}', [ProductoReporteController::class, 'actionEvolucionPrecioProductoClienteExcel']);
	Route::any('/evolucion-precio-producto-cliente-pdf/{idcuenta}/{fechadia}', [ProductoReporteController::class, 'actionEvolucionPrecioProductoClientePDF']);

	Route::any('/reporte-precio-canal-mayorista/{idopcion}', [ProductoReporteController::class, 'actionPrecioCanalMayorista']);
	Route::any('/ajax-reporte-precio-canal-mayorista', [ProductoReporteController::class, 'actionAjaxPrecioCanalMayorista']);
	Route::any('/precio-producto-canal-mayorista-excel/{fechadia}', [ProductoReporteController::class, 'actionPrecioCanalMayoristaExcel']);
	Route::any('/precio-producto-canal-mayorista-pdf/{fechadia}', [ProductoReporteController::class, 'actionPrecioCanalMayoristaPDF']);




	Route::any('/reporte-anticipo-prestamo-masivo/{idopcion}', [ContablilidadReporteController::class, 'actionAnticipoPrestamo']);
	//Route::any('/ajax-reporte-precio-canal-mayorista', [ProductoReporteController::class, 'actionAjaxPrecioCanalMayorista']);
	//Route::any('/precio-producto-canal-mayorista-excel/{fechadia}', [ProductoReporteController::class, 'actionPrecioCanalMayoristaExcel']);
	Route::any('/anticipo-prestamo-masivo-pdf/{centro_id}/{fechainicio}/{fechafin}', [ContablilidadReporteController::class, 'actionAnticipoPrestamoPDF']);
	Route::any('/reporte-estado-cuenta-vendedor/{idopcion}', [EstadoCuentaReporteController::class, 'actionEstadoCuentaVendedor']);
	Route::any('/ajax-combo-cliente-xjefe', [EstadoCuentaReporteController::class, 'actionComboClientexJefe']);
	Route::any('/ajax-buscar-documento-estado-cuenta', [EstadoCuentaReporteController::class, 'actionReporteEstadoCuenta']);
	Route::any('/estado-cuenta-excel/{fechainicio}/{fechafin}/{jefeventa_id}/{cliente_id}', [EstadoCuentaReporteController::class, 'actionEstadoCuentaVendedorExcel']);
	Route::any('/estado-cuenta-pdf/{fechainicio}/{fechafin}/{jefeventa_id}/{cliente_id}', [EstadoCuentaReporteController::class, 'actionEstadoCuentaVendedorPDF']);


	Route::any('/reporte-pedidos-estados/{idopcion}', [OrdenPedidoReporteController::class, 'actionPedidoXEstado']);
	Route::any('/ajax-reporte-pedido-estado', [OrdenPedidoReporteController::class, 'actionAjaxPedidoEstado']);
	Route::any('/pedido-estado-excel/{finicio}/{fechafin}/{estado_id}/{centro_id}', [OrdenPedidoReporteController::class, 'actionPedidoEstadoExcel']);

	/*Route::any('/precio-producto-canal-mayorista-pdf/{fechadia}', [ProductoReporteController::class, 'actionPrecioCanalMayoristaPDF']);*/


	Route::any('/reporte-pago-detracciones/{idopcion}', [DespachoReporteController::class, 'actionPagoDetraciones']);
	Route::any('/ajax-reporte-pago-detracciones', [DespachoReporteController::class, 'actionAjaxReportePagoDetraccion']);
	Route::any('/descargar-detraccion-guias/{cod_guia}', [DespachoReporteController::class, 'actionPagoDetraccionExcel']);





	Route::any('/gestion-de-cuentas/{idopcion}', [CarteraController::class, 'index']);
	Route::any('/cartera', [CarteraController::class, 'ListarCuentas']);
	Route::any('/cartera/saldos', [CarteraController::class, 'SaldoCuenta']);
	Route::any('/categoria/listarCategoria', [CategoriaController::class, 'ListarCategoria']);
	Route::any('/reglacredito/actualizar', [AsignarReglaController::class, 'ActualizarReglaCredito']);
	Route::any('/reglacredito-actualizar-masivo', [AsignarReglaController::class, 'ActualizarReglaCreditoMasivo']);



	Route::any('/gestion-de-nota-credito-autoservicios/{idopcion}', [NotaCreditoController::class, 'actionListarNotaCreditoAutoservicio']);
	Route::any('/agregar-reglas-orden-cen/{idopcion}', [NotaCreditoController::class, 'actionAgregarReglaOrdenCen']);
	Route::any('/ajax-reglas-cliente-fechas', [NotaCreditoController::class, 'actionAjaxReglasClienteFechas']);
	Route::any('/ajax-lista-oredencen-nota-credito', [NotaCreditoController::class, 'actionAjaxListaOrdenCenNotaCredito']);
	Route::any('/ajax-modal-detalle-documento', [NotaCreditoController::class, 'actionAjaxModalDetalleDocumento']);
	Route::any('/asociar-nota-credito/{idopcion}/{iddocumentonotacredito}', [NotaCreditoController::class, 'actionAsociarNotaCredito']);
	Route::any('/ajax-nro-documento', [NotaCreditoController::class, 'actionAjaxNroDocumento']);
	Route::any('/agregar-nota-credito', [NotaCreditoController::class, 'actionGuardarNotaCredito']);
	Route::any('/ajax-glosa-documento', [NotaCreditoController::class, 'actionAjaxGlosaDocumento']);
	Route::any('/ver-asignacion-nota-credito/{idopcion}/{iddocumentonotacredito}', [NotaCreditoController::class, 'actionVerAsignacionNotaCredito']);
	Route::any('/agregar-orden-cen/{idopcion}/{iddocumentonotacredito}', [NotaCreditoController::class, 'actionAgregarOrdenCen']);
	Route::any('/eliminar-orden-cen/{idopcion}/{iddocumentonotacredito}', [NotaCreditoController::class, 'actionEliminarOrdenCen']);
	Route::any('/ajax-eliminar-orden-cen', [NotaCreditoController::class, 'actionAjaxEliminarOrdenCen']);
	Route::any('/ajax-lista-agregar-oredencen-nota-credito', [NotaCreditoController::class, 'actionAjaxListaAgregarOrdenCenNotaCredito']);
	Route::any('/ajax-agregar-regla-orden-cen', [NotaCreditoController::class, 'actionAjaxAgregarReglaOrdenCen']);
	Route::any('/ajax-lista-detalle-oredencen-nota-credito', [NotaCreditoController::class, 'actionAjaxListaDetalleOrdenCenNotaCredito']);

	Route::any('/gestion-de-generacion-nota-credito-masivo/{idopcion}', [NotaCreditoMasivoController::class, 'actionListarNotaCreditoMasivo']);

	Route::any('/crear-nota-credito-masiva/{idopcion}', [NotaCreditoMasivoController::class, 'actionCrearNotaCreditoMasivo']);
	Route::any('/ajax-modal-lista-orden-venta-nc', [NotaCreditoMasivoController::class, 'actionAjaxModalListaOrdenVentaCuenta']);


	Route::any('/ajax-modal-lista-orden-venta-fechas', [NotaCreditoMasivoController::class, 'actionAjaxModalListaOrdenVentaFechas']);
	Route::any('/ajax-orden-venta-boletas', [NotaCreditoMasivoController::class, 'actionAjaxOrdenVentaBoletas']);
	Route::any('/ajax-modal-detalle-producto', [NotaCreditoMasivoController::class, 'actionAjaxModalDetalleProducto']);
	Route::any('/ajax-modal-generar-nota-credito', [NotaCreditoMasivoController::class, 'actionAjaxModalGenerarNotaCredito']);
	Route::any('/ajax-detalle-producto-boleta-nc', [NotaCreditoMasivoController::class, 'actionAjaxDetalleProductoBoletaNC']);

	//detracciones
	Route::any('/gestion-de-detracciones/{idopcion}', [DetraccionController::class, 'index']);
	Route::any('/detraccion/orden', [DetraccionController::class, 'getOrden']);
	Route::any('/detraccion/procesar', [DetraccionController::class, 'ProcesarPagoDetraccion']);
	Route::any('/detraccion/getserie', [DetraccionController::class, 'GetSerie']);
	/*Route::any('/ajax-lista-precio-producto_masivo', [GestionProductoController::class, 'actionAjaxListaPrecioProductoMasiva']);
	Route::any('/ajax-actualizar-precio-producto-masivas', [GestionProductoController::class, 'actionAjaxActualizarPrecioProductoMasivas']);*/


	//DESPACHO (generar pedido)
	Route::any('/gestion-de-generar-pedido/{idopcion}', [PedidoDespachoController::class, 'actionListarGeneracionPedido']);

	Route::any('/ajax-lista-pedidos-despacho', [PedidoDespachoController::class, 'actionAjaxListaPedidosDespacho']);
	Route::any('/crear-orden-pedido-despacho/{idopcion}', [PedidoDespachoController::class, 'actionCrearPedidoDepacho']);
	Route::any('/ajax-modal-lista-orden-cen-producto', [PedidoDespachoController::class, 'actionAjaxModalListaOrdenCenProducto']);
	Route::any('/ajax-modal-agregar-productos-orden-cen', [PedidoDespachoController::class, 'actionAjaxModalAgregarProductosOrdenCen']);
	Route::any('/ajax-modal-agregar-orden-cen-pedido', [PedidoDespachoController::class, 'actionAjaxModalAgregarOrdenCenPedido']);
	Route::any('/ajax-modal-agregar-producto-pedido', [PedidoDespachoController::class, 'actionAjaxModalAgregarProductosPedido']);
	Route::any('/ajax-pedido-crear-movil', [PedidoDespachoController::class, 'actionAjaxPedidoCrearMovil']);
	Route::any('/ajax-pedido-crear-movil-individuales', [PedidoDespachoController::class, 'actionAjaxPedidoCrearMovilIndividuales']);
	Route::any('/ajax-pedido-eliminar-fila', [PedidoDespachoController::class, 'actionAjaxPedidoEliminarFila']);
	Route::any('/ajax-modificar-cantidad-producto-fila', [PedidoDespachoController::class, 'actionAjaxModificarCantidadProductoFila']);
	Route::any('/ajax-modificar-muestra-producto-fila', [PedidoDespachoController::class, 'actionAjaxModificarMuestraProductoFila']);
	Route::any('/ajax-modificar-muestra-producto-fila-separado', [PedidoDespachoController::class, 'actionAjaxModificarMuestraProductoFilaSeparado']);


	Route::any('/ajax-pedido-modificar-fecha-de-entrega', [PedidoDespachoController::class, 'actionAjaxPedidoModificarFechaEntrega']);
	Route::any('/ajax-modal-configuracion-producto-cantidad', [PedidoDespachoController::class, 'actionAjaxModalConfiguracionProductoCantidad']);
	Route::any('/ajax-modificar-configuracion-del-producto', [PedidoDespachoController::class, 'actionAjaxModificarConfiguracionDelProducto']);
	Route::any('/ajax-pedido-crear-update-pedido-despacho-centro', [PedidoDespachoController::class, 'actionAjaxPedidoCrearUpdatePedidoDespachoCentro']);
	Route::any('/ajax-pedido-crear-mobil-33-palets', [PedidoDespachoController::class, 'actionAjaxCrearMobil33Palets']);

	Route::any('/ajax-modal-configuracion-tipo', [PedidoDespachoController::class, 'actionAjaxModalConfiguracionTipo']);
	Route::any('/ajax-modal-configuracion-lugar-entrega', [PedidoDespachoController::class, 'actionAjaxModalConfiguracionLugarEntrega']);

	Route::any('/ajax-modificar-configuracion-tipo', [PedidoDespachoController::class, 'modificarconfiguraciontipo']);
	Route::any('/ajax-modificar-configuracion-lugar-entrega', [PedidoDespachoController::class, 'modificarconfiguracionLugarEntrega']);

	Route::any('/gestion-pedido-orden-despacho/{idopcion}/{idordendespacho}', [PedidoDespachoController::class, 'actionGestionOrdenDespacho']);
	Route::any('/ajax-modal-lista-orden-gestion-producto', [PedidoDespachoController::class, 'actionAjaxModalListaOrdenGestionProducto']);
	Route::any('/ajax-modal-agregar-producto-pedido-gestion', [PedidoDespachoController::class, 'actionAjaxModalAgregarProductosPedidoGestion']);
	Route::any('/ajax-rechazar-producto-gestion', [PedidoDespachoController::class, 'actionAjaxRechazarProductoGestion']);


	Route::any('/gestion-de-atender-pedido/{idopcion}', [AtenderPedidoDespachoController::class, 'actionListarAtenderPedido']);
	Route::any('/atender-orden-despacho/{idopcion}/{idordendespacho}', [AtenderPedidoDespachoController::class, 'actionAtenderOrdenDespacho']);
	Route::any('/ajax-lista-atender-pedidos-despacho', [AtenderPedidoDespachoController::class, 'actionAjaxListaAtenderPedidosDespacho']);
	Route::any('/ajax-modificar-cantidad-atender-producto-id', [AtenderPedidoDespachoController::class, 'actionAjaxAjaxModificarCantidadAtenderProducto']);
	Route::any('/ajax-modal-lista-orden-atender-producto', [AtenderPedidoDespachoController::class, 'actionAjaxModalListaOrdenAtenderProducto']);
	Route::any('/ajax-modal-agregar-producto-pedido-atender', [AtenderPedidoDespachoController::class, 'actionAjaxModalAgregarProductosPedidoAtender']);
	Route::any('/ajax-asignar-muestras-mobil', [AtenderPedidoDespachoController::class, 'actionAjaxAsignarMuestrasMobil']);
	Route::any('/ajax-imprimir-pedido-despacho', [AtenderPedidoDespachoController::class, 'actionAjaxImprimirPedidoDespacho']);
	Route::any('/ajax-modal-ver-impresion', [AtenderPedidoDespachoController::class, 'actionModalImprimirPedidoDespacho']);
	Route::any('/ajax-limpiar-impresion', [AtenderPedidoDespachoController::class, 'actionLimpiarImpresion']);
	Route::any('/ajax-modal-impresion', [AtenderPedidoDespachoController::class, 'actionImpresion']);

	Route::any('/ajax-imprimir-pedido-despacho-xcantidad', [AtenderPedidoDespachoController::class, 'actionAjaxImprimirPedidoDespachoxCantidad']);
	Route::any('/ajax-imprimir-pedido-despacho-xpalets', [AtenderPedidoDespachoController::class, 'actionAjaxImprimirPedidoDespachoxPalets']);

	Route::any('/ajax-modal-detalle-pedido-imprimir', [AtenderPedidoDespachoController::class, 'actionModalDetalleImprimir']);
	Route::any('/ajax-quitar-agregar-pedido-producto', [AtenderPedidoDespachoController::class, 'actionAjaxQuitarAgregarPedidoProducto']);

	Route::any('/ajax-quitar-agregar-pedido-producto-grupo', [AtenderPedidoDespachoController::class, 'actionAjaxQuitarAgregarPedidoProductoGrupo']);





	Route::any('/ajax-pedido-atender-modificar-fecha-de-entrega', [AtenderPedidoDespachoController::class, 'actionAjaxPedidoAtenderModificarFechaEntrega']);
	Route::any('/ajax-pedido-atender-modificar-origen', [AtenderPedidoDespachoController::class, 'actionAjaxPedidoAtenderModificarOrigen']);
	Route::any('/ajax-pedido-atender-modificar-cantidad-atender', [AtenderPedidoDespachoController::class, 'actionAjaxPedidoAtenderModificarCantidadAtender']);
	Route::any('/ajax-calcular-stock-almacen-lote', [AtenderPedidoDespachoController::class, 'actionAjaxCalcularStockAlmacenLote']);
	Route::any('/ajax-combo-lote-almacen', [AtenderPedidoDespachoController::class, 'actionAjaxComboLoteAlmacen']);
	Route::any('/ajax-combo-almacen-destino', [AtenderPedidoDespachoController::class, 'actionAjaxComboAlmacenDestino']);
	Route::any('/ajax-combo-almacen-origen', [AtenderPedidoDespachoController::class, 'actionAjaxComboAlmacenOrigen']);
	Route::any('/ajax-combo-cuenta-servicio', [AtenderPedidoDespachoController::class, 'actionAjaxComboCuentaServicio']);
	Route::any('/ajax-lista-productos-transferencia-pt', [AtenderPedidoDespachoController::class, 'actionAjaxListaProductosTransferenciaPt']);
	Route::any('/crear-transferencia-pt/{idopcion}/{idordendespacho}', [AtenderPedidoDespachoController::class, 'actionCrearTransferenciaPt']);
	Route::any('/ajax-agregar-servicio', [AtenderPedidoDespachoController::class, 'actionAjaxAgregarServicio']);
	Route::any('/ajax-rechazar-producto', [AtenderPedidoDespachoController::class, 'actionAjaxRechazarProducto']);
	Route::any('/ajax-orden-cen-mobil-modal', [AtenderPedidoDespachoController::class, 'actionAjaxOrdenCenMobilModal']);
	Route::any('/excel-orden-despacho/{idopcion}/{idordendespacho}', [AtenderPedidoDespachoController::class, 'actionExcelOrdenDespacho']);
	Route::any('/ajax-modificar-muestra-pedido-creado-fila-separado', [AtenderPedidoDespachoController::class, 'actionAjaxModificarMuestraPedidoCreadoFilaSeparado']);
	Route::any('/ajax-actualizar-lista-muestra-mobil', [AtenderPedidoDespachoController::class, 'actionAjaxActualizarListaMuestraMobil']);


	Route::any('/gestion-comision-planilla/{idopcion}', [ComisionPlanillaController::class, 'actionListarComisionPlanilla']);
	Route::any('/ver-detalle-comisiones/{idopcion}/{codperiodo}', [ComisionPlanillaController::class, 'actionVerDetalleComision']);
	Route::any('/cambiar-estado-comsion/{idopcion}', [ComisionPlanillaController::class, 'actionCambiarEstadoComision']);
	Route::any('/descargar-excel-comisiones/{idopcion}/{codperiodo}/{codcategoriajefe}/{proviene}', [ComisionPlanillaController::class, 'actionDescargarExcelComisiones']);


	Route::any('/gestion-carros-ingreso-salida/{idopcion}', [DespachoCarroController::class, 'actionListarCarros']);
	Route::any('/ajax-listar-carros-ingreso-salida', [DespachoCarroController::class, 'actionAjaxListarCarros']);
	Route::any('/ajax-modal-detalle-carro', [DespachoCarroController::class, 'actionAjaxModalDetalleCarro']);
	Route::any('/editar-carro-despacho', [DespachoCarroController::class, 'actionEditarCarroDespacho']);
	Route::get('/enviar-mensaje-whatsapp', [PruebaController::class, 'actionEnviarMensajeWhatsapp']);

	Route::any('/gestion-almacen-activos/{idopcion}', [AlmacenActivoFijoController::class, 'actionListarActivosFijos']);
	Route::any('/registrar-activo-fijo/{idproducto}/{iddocumento}', [ActivoFijoController::class, 'registrarActivoFijo']);
	Route::any('/gestion-almacen-activos-transferidos/{idopcion}', [AlmacenActivoFijoTransferidoController::class, 'actionListarActivosFijosTransferidos']);
	Route::any('/modificar-activo-fijo/{idactivofijo}', [ActivoFijoController::class, 'modificarActivoFijo']);
	Route::any('/depreciacion-activo-fijo/{idopcion}', [DepreciacionActivoFijoController::class, 'index']);
	Route::any('/catalogo-activos-fijos/{idopcion}', [ActivoFijoController::class, 'catalogoActivosFijos']);
	Route::any('/registrar-obra-activo-fijo/', [ActivoFijoController::class, 'registrarObraActivoFijo']);
	Route::any('/exportar-formato-iatr/{idopcion}', [ExportarFormatoIatrController::class, 'exportarFormatoIATR']);
	Route::any('/exportar-formato-iach/{idopcion}', [ExportarFormatoIachController::class, 'exportarFormatoIACH']);

	Route::any('/gestion-cuadro-comisiones/{idopcion}', [ComisionPlanillaController::class, 'actionCuadroComisiones']);
	Route::any('/gestion-de-configurar-comision/{idopcion}', [ComisionConfiguracionController::class, 'actionConfigurarComision']);
	Route::any('/ajax-guardar-comision-configuracion', [ComisionConfiguracionController::class, 'actionAjaxGuardarComision']);
	Route::any('/ajax-modificar-comision-configuracion', [ComisionConfiguracionController::class, 'actionAjaxModificarComision']);
	Route::any('/ajax-eliminar-comision-configuracion', [ComisionConfiguracionController::class, 'actionAjaxEliminarComision']);

	Route::any('/ajax-guardar-jefe-subcanal', [ComisionConfiguracionController::class, 'actionAjaxGuardarJefeSubcanal']);
	Route::get('/exportar-excel-comisiones-configuracion', [ComisionConfiguracionController::class, 'actionExportarExcelComisiones']);
	Route::any('/gestion-de-aplicar-comision/{idopcion}', [ComisionConfiguracionController::class, 'actionAplicarComision']);
	Route::any('/gestion-de-aprobar-comision-administrativo/{idopcion}', [ComisionConfiguracionController::class, 'actionAprobarComisionAdministrativo']);
	Route::any('/ajax-guardar-fechas-periodo-comision', [ComisionConfiguracionController::class, 'actionAjaxGuardarFechasPeriodo']);
	Route::any('/ajax-listar-comisiones-vendedor', [ComisionConfiguracionController::class, 'actionAjaxListarComisionesVendedor']);
	Route::any('/ajax-aplicar-comisiones-vendedor', [ComisionConfiguracionController::class, 'actionAjaxAplicarComisionesVendedor']);
	Route::get('/exportar-excel-aplicar-comision', [ComisionConfiguracionController::class, 'actionExportarExcelAplicarComision']);
	Route::get('/exportar-excel-comision-administrativo', [ComisionConfiguracionController::class, 'actionExportarExcelComisionAdministrativo']);
	Route::any('/ajax-aprobar-comisiones-masivo', [ComisionConfiguracionController::class, 'actionAjaxAprobarComisionesMasivo']);

	Route::any('/gestion-de-regla-de-ampliacion-linea-credito/{idopcion}', [ReglaController::class, 'actionListarReglaLineaCredito']);
	Route::any('/agregar-regla-linea-credito/{idopcion}', [ReglaController::class, 'actionAgregarReglaLineaCredito']);
	Route::any('/ajax-lista-reglas-linea-credito', [ReglaController::class, 'actionListaAjaxReglasLimiteCredito']);

	Route::any('/gestion-de-regla-dias-vencimiento/{idopcion}', [ReglaController::class, 'actionListarReglaDiasVencimiento']);
	Route::any('/agregar-regla-dias-vencimiento/{idopcion}', [ReglaController::class, 'actionAgregarReglaDiasVencimiento']);
	Route::any('/ajax-lista-reglas-dias-vencimiento', [ReglaController::class, 'actionListaAjaxReglasDiasVencimiento']);

	Route::any('/gestion-de-asignar-regla-dias-vencimiento/{idopcion}', [ReglaController::class, 'actionAsignarReglaDiasVencimiento']);
	Route::any('/ajax-modal-lista-orden-venta-regla', [ReglaController::class, 'actionAjaxModalListaOrdenVentaCuenta']);
	Route::any('/ajax-modal-asignar-orden-venta-regla-dias-vencimiento', [ReglaController::class, 'actionAjaxAsignarReglaDiasVencimiento']);
	Route::any('/ajax-modal-asignar-masivo-orden-venta-regla-dias-vencimiento', [ReglaController::class, 'actionAjaxAsignarMasivoReglaDiasVencimiento']);
	Route::any('/eliminar-regla-dias-vencimiento/{asignarregla_id}/{idopcion}', [ReglaController::class, 'actionAjaxEliminarReglaDiasVencimiento']);


	Route::any('/gestion-de-asignar-regla-limite-credito/{idopcion}', [ReglaController::class, 'actionAsignarReglaLimiteCredito']);
	Route::any('/ajax-modal-lista-cliente-jefe-regla', [ReglaController::class, 'actionAjaxModalListaClienteJefeRegla']);
	Route::any('/ajax-modal-asignar-cliente-regla-limite-credito', [ReglaController::class, 'actionAjaxAsignarReglaLimiteCredito']);
	Route::any('/eliminar-regla-limite-credito/{asignarregla_id}/{idopcion}', [ReglaController::class, 'actionAjaxEliminarReglaLimiteCredito']);

	// REPORTE COMPROMISO PAGO
	Route::any('/gestion-de-regla-compromiso-pago/{idopcion}', [ReglaController::class, 'actionListarReglaCompromisoPago']);
	Route::any('/ajax-lista-reglas-compromiso-pago', [ReglaController::class, 'actionListaAjaxReglasCompromisoPago']);
	Route::any('/regla-compromiso-pago-excel/{fechainicio}/{fechafin}/{sede?}', [ReglaController::class, 'actionReglaCompromisoPagoExcel']);
	Route::any('/ajax-modal-detalle-pagos-periodo', [ReglaController::class, 'actionAjaxModalDetallePagosPeriodo']);

	// BARRAS MASIVO GRANDE
	Route::any('/gestion-de-barra-masivo-grande/{idopcion}', [BarraMasivoController::class, 'actionGestionBarraMasivoGrande']);
	Route::any('/procesar-barra-masivo-grande/{idopcion}', [BarraMasivoController::class, 'actionProcesarBarraMasivoGrande']);

	//Route::any('/ajax-modal-lista-orden-venta-nc', [NotaCreditoMasivoController::class, 'actionAjaxModalListaOrdenVentaCuenta']);

	Route::any('/gestion-de-comisiones-periodo/{idopcion}', [ComisionReporteController::class, 'actionComisionPeriodo']);
	Route::any('/comision-periodo-producto-excel/{periodoinicio}/{periodofin}/{vendedor_id}', [ComisionReporteController::class, 'actionComisionPeriodoExcel']);

	Route::get('gestion-de-comisiones-x-periodo/{idopcion}', [ComisionConfiguracionController::class, 'actionComisionMercadoMayorista']);
	Route::post('ajax-buscar-comisiones-x-periodo', [ComisionConfiguracionController::class, 'actionAjaxBuscarComisionesxPeriodo']);

	// Dashboard Mayorista
	Route::get('gestion-de-dashboard-comisiones-mayorista/{idopcion}', [ComisionConfiguracionController::class, 'actionDashboardComisionesMayorista']);
	Route::post('ajax-dashboard-comisiones-mayorista', [ComisionConfiguracionController::class, 'actionAjaxDashboardComisionesMayorista']);

	Route::get('excel-comision-mayorista', [ComisionConfiguracionController::class, 'actionExcelComisionMayorista']);

	//bonos
	Route::any('/gestion-de-bonos/{idopcion}', [BonosController::class, 'actionListarBonos']);
	Route::any('/agregar-bono/{idopcion}', [BonosController::class, 'actionAgregarBono']);
	Route::any('/ingresar-cuotas/{idopcion}/{idcuota}', [BonosController::class, 'actionIngresarCuota']);
	Route::any('/ajax-modal-configuracion-cuota-detalle', [BonosController::class, 'actionAjaxModalConfiguracionCuotaDetalle']);
	Route::any('/ajax-combo-subcanal-xcanal', [BonosController::class, 'actionAjaxComboSubCanalxCanal']);
	Route::any('/ajax-modal-modificar-configuracion-cuota-detalle', [BonosController::class, 'actionAjaxModalModificarConfiguracionCuota']);
	Route::any('/ajax-modal-clonar', [BonosController::class, 'actionAjaxClonar']);
	Route::any('/ajax-guardar-clonar', [BonosController::class, 'actionAjaxGuardarClonar']);
	Route::any('/ajax-modal-emitir-cuota', [BonosController::class, 'actionAjaxModalEmitirCuota']);
	Route::any('/ajax-guardar-emitir', [BonosController::class, 'actionAjaxGuardarEmitir']);
	//calcalubono
	Route::any('/gestion-calcular-bonos/{idopcion}', [CalcularBonosController::class, 'actionListarPeriodoBonos']);
	Route::any('/agregar-calculo-bono/{idopcion}', [CalcularBonosController::class, 'actionAgregarCalculoBono']);
	Route::any('/ingresar-calculo-vendedor/{idopcion}/{idperiodobono}', [CalcularBonosController::class, 'actionIngresarCalculoVendedor']);
	Route::any('/ajax-modal-configuracion-bono-vendedor', [CalcularBonosController::class, 'actionAjaxModalConfiguracionBonoVendedor']);
	Route::any('/ajax-modal-detalle-calculobono-rd', [CalcularBonosController::class, 'actionAjaxModalDetalleCalculoBono']);
	Route::any('/cambiar-estado-bono/{idopcion}', [CalcularBonosController::class, 'actionCambiarEstadoBono']);

	//Excel Exportar
	Route::any('/gestion-import-excel/{idopcion}', [ImportExcelController::class, 'actionGestionImportExcel']);
	Route::post('/gestion-import-excel/{idopcion}/import', [ImportExcelController::class, 'actionImportExcel']);
	Route::post('/gestion-import-excel/{idopcion}/validate', [ImportExcelController::class, 'actionValidateExcel']);
	Route::post('/ajax-listar-archivo-autoservicio', [ImportExcelController::class, 'actionAjaxListarArchivoAutoservicio']);
	Route::post('/descargar-reporte-refuerzo/{idopcion}', [ImportExcelController::class, 'actionDescargarReporteRefuerzo']);
	Route::any('/ajax-combo-periodo-xanio-xempresa', [ImportExcelController::class, 'actionAjaxComboPeriodoAnioEmpresa']);

	//-- Picking
	Route::any('/gestion-transferencia/{idopcion}', [TransferenciaController::class, 'actionListarTransferencia']);
	Route::any('/ajax-listado-transferencia', [TransferenciaController::class, 'actionAjaxListarTransferencia']);
	Route::any('/agregar-transferencia/{idopcion}/{idtranferencia}', [TransferenciaController::class, 'actionAgregarTransferencia']);
	Route::any('/modificar-transferencia/{idopcion}/{idtransferencia}', [TransferenciaController::class, 'actionModificarTransferencia']);
	Route::any('/ajax-transferencia-cliente', [TransferenciaController::class, 'actionAjaxTransferenciaCliente']);
	Route::any('/ajax-detalle-producto', [TransferenciaController::class, 'actionAjaxDetalleProducto']);
	Route::any('/ajax-modal-detalle-transferencia', [TransferenciaController::class, 'actionAjaxDetalleTransferencia']);
	Route::any('/ajax-cambiar-estado-transferencia', [TransferenciaController::class, 'actionAjaxCambiarEstadoTransferencia']);
	Route::any('/autorizar-transferencia/{idopcion}', [TransferenciaController::class, 'actionListarTransferencia']);
	Route::any('/atender-transferencia/{idopcion}', [TransferenciaController::class, 'actionListarTransferencia']);
	Route::any('/imprimir-solicitud-transferencia/{idtransferencia}', [PickingReporteController::class, 'actionImprimirSolicitudTransferencia']);

	Route::any('/gestion-picking/{idopcion}', [TransferenciaController::class, 'actionListarPicking']);
	Route::any('/ajax-listado-picking', [TransferenciaController::class, 'actionAjaxListarPicking']);
	Route::any('/agregar-picking/{idopcion}/{idpicking}', [TransferenciaController::class, 'actionAgregarPicking']);
	Route::any('/ajax-modal-lista-transferencia-autorizada', [TransferenciaController::class, 'actionAjaxModalListaTransferenciaAutorizada']);
	Route::any('/ajax-modal-agregar-producto-picking', [TransferenciaController::class, 'actionAjaxModalAgregarProductosPicking']);
	Route::any('/ajax-modal-producto-individual', [TransferenciaController::class, 'actionAjaxModalProductoIndividual']);
	Route::any('/ajax-agregar-producto-individual', [TransferenciaController::class, 'actionAjaxAgregarProductoIndividual']);

	Route::any('/ajax-validar-cantidad-atender-picking', [TransferenciaController::class, 'actionAjaxValidarCantidadesAtenderPicking']);
	Route::any('/ajax-picking-eliminar-fila/', [TransferenciaController::class, 'actionAjaxPickingEliminarFila']);
	Route::any('/ajax-modal-detalle-picking', [TransferenciaController::class, 'actionAjaxDetallePicking']);
	Route::any('/ajax-cambiar-estado-picking', [TransferenciaController::class, 'actionAjaxCambiarEstadoPicking']);

	Route::any('/atender-picking/{idopcion}', [PickingController::class, 'actionListarAtenderPicking']);
	Route::any('/ajax-listado-atender-picking', [PickingController::class, 'actionAjaxListarAtenderPicking']);
	Route::any('/atender-picking/{idopcion}/{idpicking}', [PickingController::class, 'actionAtenderPicking']);
	Route::any('/ajax-lista-productos-transferencia-picking', [PickingController::class, 'actionAjaxListaProductosTransferenciaPicking']);
	Route::any('/ajax-lista-productos-ordensalida-picking', [PickingController::class, 'actionAjaxListaProductosOrdenSalidaPicking']);
	Route::any('/crear-transferencia-picking/{idopcion}/{idpicking}', [PickingController::class, 'actionCrearTransferenciaPicking']);
	Route::any('/crear-ordensalida-picking/{idopcion}/{idpicking}', [PickingController::class, 'actionCrearOrdenSalidaPicking']);
	Route::any('/generar-detraccion-picking/{idopcion}/{idpicking}', [PickingController::class, 'actionGenerarDetraccionPicking']);
	Route::any('/ajax-calcular-detraccion', [PickingController::class, 'actionAjaxCalcularDetraccion']);
	Route::any('/guardar-detraccion-picking/{idopcion}', [PickingController::class, 'actionGuardarDetraccionPicking']);

	Route::any('/imprimir-picking-detraccion/{idpicking}', [PickingReporteController::class, 'actionImprimirPickingDetraccion']);
	Route::any('/imprimir-picking/{idpicking}', [PickingReporteController::class, 'actionImprimirPicking']);

	Route::any('/reporte-detraccion-diario/{idopcion}', [PickingReporteController::class, 'actionDetraccionDiario']);
	Route::any('/ajax-reporte-detraccion-diario', [PickingReporteController::class, 'actionAjaxDetraccionDiario']);
	Route::any('/reporte-detraccion-diario-pdf/{fechadia}', [PickingReporteController::class, 'actionDetraccionDiarioPDF']);
	Route::any('/ajax-combo-almacen-destino-pk', [PickingController::class, 'actionAjaxComboAlmacenDestinoPk']);
	Route::any('/ajax-combo-almacen-origen-pk', [PickingController::class, 'actionAjaxComboAlmacenOrigenPk']);

	//----------------------------------------







	Route::get('buscarcliente', function (Illuminate\Http\Request $request) {
		$term = $request->term ?: '';
		$tags = App\WEBListaCliente::where('NOM_EMPR', 'like', '%' . $term . '%')
			->where('COD_EMPR', '=', Session::get('empresas')->COD_EMPR)
			->where('COD_CENTRO', '=', Session::get('centros')->COD_CENTRO)
			->take(100)
			->pluck('NOM_EMPR', 'NOM_EMPR');
		$valid_tags = [];
		foreach ($tags as $id => $tag) {
			$valid_tags[] = ['id' => $id, 'text' => $tag];
		}
		return \Response::json($valid_tags);
	});


	Route::get('buscarproducto', function (Illuminate\Http\Request $request) {
		$term = $request->term ?: '';
		$tags = App\WEBPrecioProducto::join('WEB.LISTAPRODUCTOSAVENDER', 'COD_PRODUCTO', '=', 'producto_id')
			->where('NOM_PRODUCTO', 'like', '%' . $term . '%')
			->where('empresa_id', '=', Session::get('empresas')->COD_EMPR)
			->where('centro_id', '=', Session::get('centros')->COD_CENTRO)
			->take(100)
			->pluck('NOM_PRODUCTO', 'producto_id');

		$valid_tags = [];
		foreach ($tags as $id => $tag) {
			$valid_tags[] = ['id' => $id, 'text' => $tag];
		}
		return \Response::json($valid_tags);
	});



	Route::get('buscarempresadespacho', function (Illuminate\Http\Request $request) {

		$term = $request->term ?: '';
		$tags = App\STDEmpresa::where('NOM_EMPR', 'like', '%' . $term . '%')
			->take(100)
			->pluck('NOM_EMPR', 'NOM_EMPR');
		$valid_tags = [];
		foreach ($tags as $id => $tag) {
			$valid_tags[] = ['id' => $id, 'text' => $tag];
		}
		return \Response::json($valid_tags);

	});


	Route::get('buscarempresaserviciodespacho', function (Illuminate\Http\Request $request) {

		$term = $request->term ?: '';
		$tags = App\STDEmpresa::where('NOM_EMPR', 'like', '%' . $term . '%')
			->take(100)
			->select('COD_EMPR', DB::raw("(NOM_EMPR + ' ' + NRO_DOCUMENTO) AS NOM_EMPR_N"))
			->pluck('NOM_EMPR_N', 'COD_EMPR');

		$valid_tags = [];
		foreach ($tags as $id => $tag) {
			$valid_tags[] = ['id' => $id, 'text' => $tag];
		}
		return \Response::json($valid_tags);

	});







	Route::any('/enviocorreos', [CorreoController::class, 'enviocorreo']);
	Route::any('/pruebaquery', [PruebaController::class, 'pruebas']);
	Route::any('/power-bi', [PruebaController::class, 'indicadoresISL']);

});

