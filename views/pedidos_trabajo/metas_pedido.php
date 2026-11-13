<?php
/**
 * Metas del pedido y de sus hitos sobre los KPI de la empresa (TAR-METAS).
 * La carga Pedidotrabajo/metas/{petr_id}; se recarga con reload('comp#metas', petr_id).
 * @var string $petr_id
 * @var array  $metas  Objetivos_model::dePedido()
 * @var array  $kpis   Objetivos_model::kpisDisponibles()
 * @var array  $hitos  hitos del pedido (objetos con hito_id, nro, numero)
 */
$fmt = function ($v) {
    if ($v === null || $v === '') return '—';
    return rtrim(rtrim(number_format((float) $v, 2, ',', '.'), '0'), ',');
};
$titulos = array();
foreach ($kpis as $k) $titulos[$k['nombre']] = $k['titulo'];
?>
<div id="metas-pedido" data-petr="<?php echo htmlspecialchars($petr_id) ?>">
    <table class="table table-condensed table-hover" id="tbl-metas">
        <thead>
            <tr>
                <th>Indicador</th>
                <th>Hito</th>
                <th class="text-right">Partida</th>
                <th class="text-right">Meta</th>
                <th class="text-right">Hoy</th>
                <th style="min-width:120px">Avance</th>
                <th>Hasta</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($metas)) { ?>
            <tr class="sin-metas"><td colspan="9" class="text-center text-muted"><cite>Este pedido todavía no tiene metas.</cite></td></tr>
            <?php } ?>
            <?php foreach ($metas as $m) {
                $titulo = isset($titulos[$m['kpi']]) ? $titulos[$m['kpi']] : ($m['descripcion'] ?: $m['kpi']);
                $sentido = $m['operador'] === '>=' ? 'subir hasta' : 'bajar hasta';
                $av = $m['avance'];
                $barra = $av === null ? 0 : max(0, min(100, $av));
                $color = $m['cumple'] === true ? 'progress-bar-success' : ($av !== null && $av < 0 ? 'progress-bar-danger' : 'progress-bar-primary');
                $estado = $m['estado'];
                if ($estado === 'vigente' && $m['cumple'] === true) $estado = 'cumplida';
                $etiqueta = array('vigente' => 'label-primary', 'cumplida' => 'label-success', 'cumplido' => 'label-success', 'vencido' => 'label-danger');
            ?>
            <tr class="meta" data-id="<?php echo $m['objetivo_id'] ?>" data-kpi="<?php echo htmlspecialchars($m['kpi']) ?>">
                <td><?php echo htmlspecialchars($titulo) ?><br><small class="text-muted"><?php echo $sentido ?></small></td>
                <td><?php echo $m['hito'] !== '' ? htmlspecialchars($m['hito']) : '<span class="text-muted">Todo el pedido</span>' ?></td>
                <td class="text-right partida"><?php echo $fmt($m['linea_base']) ?></td>
                <td class="text-right valor-meta"><?php echo $fmt($m['meta']) ?></td>
                <td class="text-right hoy"><?php echo $fmt($m['valor_actual']) ?></td>
                <td class="avance">
                    <?php if ($av === null) { ?>
                        <small class="text-muted">Sin datos para medir</small>
                    <?php } else { ?>
                        <div class="progress progress-xs" style="margin:4px 0 0 0" title="<?php echo $fmt($av) ?>%">
                            <div class="progress-bar <?php echo $color ?>" style="width: <?php echo $barra ?>%"></div>
                        </div>
                        <small><?php echo $fmt($av) ?>%</small>
                    <?php } ?>
                </td>
                <td><?php echo htmlspecialchars($m['hasta']) ?></td>
                <td><span class="label <?php echo isset($etiqueta[$estado]) ? $etiqueta[$estado] : 'label-default' ?> estado"><?php echo ucfirst($estado) ?></span></td>
                <td><?php if ($m['estado'] === 'vigente') { ?><i class="fa fa-times text-red" style="cursor:pointer" title="Cancelar meta" onclick="cancelarMeta(<?php echo $m['objetivo_id'] ?>)"></i><?php } ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <form id="frm-meta" class="form-inline" onsubmit="guardarMeta(); return false;" style="border-top:1px solid #f4f4f4; padding-top:10px">
        <div class="form-group">
            <select name="kpi" class="form-control input-sm" required>
                <option value="">Indicador...</option>
                <?php foreach ($kpis as $k) { ?>
                <option value="<?php echo htmlspecialchars($k['nombre']) ?>"><?php echo htmlspecialchars($k['titulo']) ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <select name="hito_id" class="form-control input-sm">
                <option value="">Todo el pedido</option>
                <?php foreach ($hitos as $h) { ?>
                <option value="<?php echo $h->hito_id ?>"><?php echo htmlspecialchars((!empty($h->nro) ? 'Hito ' . $h->nro . ' · ' : '') . $h->numero) ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <select name="operador" class="form-control input-sm">
                <option value=">=">tiene que subir hasta</option>
                <option value="<=">tiene que bajar hasta</option>
            </select>
        </div>
        <div class="form-group">
            <input name="meta" type="number" step="any" class="form-control input-sm" placeholder="Valor meta (ej. 70)" required style="width:130px">
        </div>
        <div class="form-group">
            <label class="small">antes del</label>
            <input name="hasta" type="date" class="form-control input-sm" required min="<?php echo date('Y-m-d') ?>">
        </div>
        <div class="form-group">
            <input name="responsable" type="text" maxlength="255" class="form-control input-sm" placeholder="Responsable (opcional)">
        </div>
        <button type="submit" class="btn btn-primary btn-sm btn-flat" id="btn-guardar-meta"><i class="fa fa-plus mr-2"></i>Agregar meta</button>
        <p class="help-block small" style="margin-top:6px">El sistema guarda el valor de hoy del indicador como punto de partida y muestra cuánto se avanzó hacia la meta.</p>
    </form>
</div>

<script>
function guardarMeta() {
    var petr = $('#metas-pedido').data('petr');
    var datos = $('#frm-meta').serialize();
    $('#btn-guardar-meta').prop('disabled', true);
    $.post('<?php echo base_url(BPM) ?>Pedidotrabajo/guardarMeta/' + petr, datos, function (r) {
        try { r = (typeof r === 'string') ? JSON.parse(r) : r; } catch (e) { r = { ok: false, error: 'Respuesta inválida del servidor.' }; }
        if (r.ok) {
            Swal.fire('Hecho!', 'Meta agregada al pedido', 'success');
            reload('comp#metas', petr);
        } else {
            Swal.fire('No se guardó la meta', r.error || 'Probá de nuevo en un momento.', 'error');
        }
    }).fail(function () {
        Swal.fire('No se guardó la meta', 'No se pudo conectar con el servidor.', 'error');
    }).always(function () { $('#btn-guardar-meta').prop('disabled', false); });
}

function cancelarMeta(id) {
    var petr = $('#metas-pedido').data('petr');
    Swal.fire({
        title: '¿Cancelar la meta?', text: 'Deja de medirse; queda en el historial.', type: 'warning',
        showCancelButton: true, confirmButtonText: 'Sí, cancelar', cancelButtonText: 'No'
    }).then(function (res) {
        if (!res.value) return;
        $.post('<?php echo base_url(BPM) ?>Pedidotrabajo/cancelarMeta/' + petr + '/' + id, {}, function (r) {
            try { r = (typeof r === 'string') ? JSON.parse(r) : r; } catch (e) { r = { ok: false }; }
            if (r.ok) {
                reload('comp#metas', petr);
            } else {
                Swal.fire('No se canceló', r.error || 'Probá de nuevo en un momento.', 'error');
            }
        });
    });
}
</script>
