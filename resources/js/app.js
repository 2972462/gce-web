

import Alpine from 'alpinejs';

window.Alpine = Alpine;

/**
 * Calculadora de Patente Comercial: igual que la de erp.gce.com.py
 * (/consultas/patente-calculo), todo se recalcula en el navegador con
 * la tabla de tramos ya cargada, sin ida y vuelta al servidor.
 */
window.patenteCalculadora = function (tramos) {
    return {
        tramos,
        monto: '',

        get montoNumerico() {
            return this.monto === '' ? null : Number(this.monto);
        },

        get montoFormateado() {
            return this.monto === '' ? '' : this.formatearGs(this.monto);
        },

        get resultado() {
            if (this.montoNumerico === null || !this.tramos.length) return null;

            const monto = this.montoNumerico;
            const tramo = this.tramos.find((t) => monto >= t.desde && monto < t.hasta) || this.tramos[this.tramos.length - 1];
            const excedente = Math.max(0, monto - tramo.desde);
            const impuesto = Math.round(tramo.adicional + (excedente * tramo.porcentaje) / 100);
            const semestre1 = Math.floor(impuesto / 2);
            const semestre2 = impuesto - semestre1;

            return { monto, tramo, excedente, impuesto, semestre1, semestre2 };
        },

        actualizarMonto(event) {
            this.monto = event.target.value.replace(/\D/g, '');
            event.target.value = this.montoFormateado;
        },

        formatearGs(valor) {
            if (valor === null || valor === undefined || valor === '') return '';
            return new Intl.NumberFormat('es-PY', { maximumFractionDigits: 0 }).format(valor);
        },
    };
};

Alpine.start();
