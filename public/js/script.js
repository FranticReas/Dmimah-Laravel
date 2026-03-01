// ini untuk sidebar
const hamburger = document.querySelector(".toggle-btn");
if (hamburger) {
    hamburger.addEventListener("click", function () {
        document.querySelector("#sidebar").classList.toggle("expand");
    });
}

document.addEventListener('DOMContentLoaded', function () {

    // =========================
    // DELETE MODAL CUSTOMER
    // =========================
    const modalHapus = document.getElementById('modalHapusCustomer');
    if (modalHapus) {
        modalHapus.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const form = document.getElementById('formHapusCustomer');
            if (form) form.action = `/customer/${id}`;
        });
    }

    // =========================
    // EDIT MODAL CUSTOMER
    // =========================
    const modalEdit = document.getElementById('modalEditCustomer');
    if (modalEdit) {
        modalEdit.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const noHp = button.getAttribute('data-no_hp');
            const deskripsi = button.getAttribute('data-deskripsi');
            const alamat = button.getAttribute('data-alamat');

            const form = document.getElementById('formEditCustomer');
            if (form) form.action = window.location.origin + `/customer/${id}`;

            modalEdit.querySelector('#nama').value = nama;
            modalEdit.querySelector('#no_hp').value = noHp;
            modalEdit.querySelector('#deskripsi').value = deskripsi;
            modalEdit.querySelector('#alamat').value = alamat;
        });
    }

    // =========================
    // HAPUS STOCK
    // =========================
    const modalHapusStock = document.getElementById('modalHapusStock');
    if (modalHapusStock) {
        modalHapusStock.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const form = document.getElementById('formHapusStock');
            if (form) form.action = `/stock/${id}`;
        });
    }

    // =========================
    // EDIT STOCK
    // =========================
    const modalEditStok = document.getElementById('modalEditStok');
    if (modalEditStok) {
        modalEditStok.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const id = button.getAttribute('data-id');
            const name = button.getAttribute('data-name');
            const quantity = button.getAttribute('data-quantity');
            const minimumStock = button.getAttribute('data-minimum_stock');
            const measurement = button.getAttribute('data-measurement');

            const editId = document.getElementById('edit_id');
            const editNama = document.getElementById('edit_nama');
            const editQty = document.getElementById('edit_quantity');
            const editMin = document.getElementById('edit_minimum_stock');
            const editUnit = document.getElementById('edit_measurement_unit');

            if (editId) editId.value = id;
            if (editNama) editNama.value = name;
            if (editQty) editQty.value = quantity;
            if (editMin) editMin.value = minimumStock;
            if (editUnit) editUnit.value = measurement;

            const form = document.getElementById('formEditStok');
            if (form) form.action = window.location.origin + `/stock/${id}`;
        });
    }

    // =========================
    // HAPUS PRODUK
    // =========================
    const modalHapusProduk = document.getElementById('modalHapusProduk');
    if (modalHapusProduk) {
        modalHapusProduk.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const form = document.getElementById('formHapusProduk');
            if (form) form.action = `/product/${id}`;
        });
    }

    // =========================
    // HAPUS ORDER
    // =========================
    const modalHapusOrder = document.getElementById('modalHapusOrder');
    if (modalHapusOrder) {
        modalHapusOrder.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const form = document.getElementById('formHapusOrder');
            if (form) form.action = `/order/${id}`;
        });
    }

    // =========================
    // TAKARAN OTOMATIS
    // =========================
    const ingredientInput = document.getElementById('ingredientInput');
    if (ingredientInput) {
        ingredientInput.addEventListener('input', function () {
            let inputValue = this.value;
            let options = document.querySelectorAll('#ingredientList option');
            let unitSelect = document.getElementById('measurementUnit');
            options.forEach(option => {
                if (option.value === inputValue) {
                    unitSelect.value = option.getAttribute('data-unit');
                }
            });
        });
    }

    // =========================
    // CHART DASHBOARD
    // =========================
    const canvas = document.getElementById('dashboard-chart');
    if (canvas) {
        const labels = JSON.parse(canvas.dataset.labels || '[]');
        const incomeData = JSON.parse(canvas.dataset.income || '[]');
        const expenseData = JSON.parse(canvas.dataset.expense || '[]');

        const labelStart = document.getElementById('label-start');
        const labelEnd = document.getElementById('label-end');
        if (labels.length > 0) {
            if (labelStart) labelStart.textContent = labels[0];
            if (labelEnd) labelEnd.textContent = labels[labels.length - 1];
        }

        const ctx = canvas.getContext('2d');

        const gradientIncome = ctx.createLinearGradient(0, 0, 0, 300);
        gradientIncome.addColorStop(0, 'rgba(233, 90, 150, 0.5)');
        gradientIncome.addColorStop(1, 'rgba(233, 90, 150, 0.02)');

        const gradientExpense = ctx.createLinearGradient(0, 0, 0, 300);
        gradientExpense.addColorStop(0, 'rgba(150, 17, 98, 0.5)');
        gradientExpense.addColorStop(1, 'rgba(150, 17, 98, 0.02)');

        window.dashboardChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Income',
                        data: incomeData,
                        borderColor: '#e95a96',
                        borderWidth: 2,
                        backgroundColor: gradientIncome,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#e95a96',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2,
                    },
                    {
                        label: 'Expense',
                        data: expenseData,
                        borderColor: '#961162',
                        borderWidth: 2,
                        backgroundColor: gradientExpense,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: '#961162',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2,
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        display: true,
                        labels: { color: '#961162', font: { size: 11 } }
                    },
                    tooltip: {
                        backgroundColor: '#fff0f5',
                        titleColor: '#961162',
                        bodyColor: '#961162',
                        borderColor: '#e95a96',
                        borderWidth: 1,
                        padding: 10,
                        callbacks: {
                            label: ctx => ` ${ctx.dataset.label}: Rp ${Number(ctx.parsed.y).toLocaleString('id-ID')}`
                        }
                    },
                    zoom: {
                        pan: { enabled: true, mode: 'x' },
                        zoom: {
                            wheel: { enabled: true },
                            pinch: { enabled: true },
                            mode: 'x',
                        }
                    }
                },
                scales: {
                    x: { display: false, grid: { display: false } },
                    y: {
                        display: true,
                        position: 'right',
                        grid: { color: 'rgba(150, 17, 98, 0.08)', drawBorder: false },
                        ticks: {
                            color: '#c06090',
                            font: { size: 10 },
                            maxTicksLimit: 4,
                            callback: val => 'Rp ' + Number(val).toLocaleString('id-ID')
                        },
                        border: { display: false }
                    }
                }
            }
        });
    }

});

// =========================
// EDIT STATUS ORDER
// =========================
function setEditStatus(id, status) {
    const form = document.getElementById('formEditStatus');
    if (form) form.action = `/order/${id}`;
    const statusEl = document.getElementById('status');
    if (statusEl) statusEl.value = status;
}

// =========================
// CHART ZOOM & EXPORT
// =========================
window.setZoom = function (months, el) {
    document.querySelectorAll('.zoom-btn').forEach(b => b.classList.remove('active'));
    if (el) el.classList.add('active');
    const chart = window.dashboardChart;
    if (!chart) return;
    chart.resetZoom();
    if (months === null) return;
    const total = chart.data.labels.length;
    const from = Math.max(0, total - months);
    chart.zoomScale('x', { min: from, max: total - 1 }, 'default');
};

window.exportPNG = function () {
    if (!window.dashboardChart) return;
    window.dashboardChart.canvas.toBlob(blob => {
        navigator.clipboard.write([new ClipboardItem({ 'image/png': blob })]);
        alert('Chart berhasil disalin ke clipboard!');
    });
};

window.downloadPNG = function () {
    if (!window.dashboardChart) return;
    const link = document.createElement('a');
    link.download = 'chart-penjualan.png';
    link.href = window.dashboardChart.canvas.toDataURL('image/png');
    link.click();
};

window.exportCSV = function () {
    const chart = window.dashboardChart;
    if (!chart) return;
    const labels = chart.data.labels;
    const income = chart.data.datasets[0].data;
    const expense = chart.data.datasets[1].data;
    let csv = 'Bulan,Income,Expense\n';
    labels.forEach((label, i) => {
        csv += `${label},${income[i] ?? 0},${expense[i] ?? 0}\n`;
    });
    const blob = new Blob([csv], { type: 'text/csv' });
    const link = document.createElement('a');
    link.download = 'data-penjualan.csv';
    link.href = URL.createObjectURL(blob);
    link.click();
};