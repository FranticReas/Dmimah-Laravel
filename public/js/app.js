/**
 * public/js/app.js
 * Vue 3 Global App — berjalan di semua halaman
 */
const { createApp, ref, onMounted } = Vue;

const app = createApp({
    setup() {
        const sidebarCollapsed = ref(false);

        function toggleSidebar() {
            sidebarCollapsed.value = !sidebarCollapsed.value;
            const main = document.querySelector('.main');
            if (main) main.classList.toggle('sidebar-collapsed', sidebarCollapsed.value);
        }

        function setModalAction(formId, url) {
            const f = document.getElementById(formId);
            if (f) f.action = url;
        }

        function bindDataButtons() {
            document.querySelectorAll('[data-set-delete]').forEach(btn => {
                btn.addEventListener('click', () => {
                    setModalAction(btn.dataset.setDelete, `${btn.dataset.baseUrl}/${btn.dataset.id}`);
                });
            });
            document.querySelectorAll('[data-set-edit-customer]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const f = document.getElementById('formEditCustomer');
                    if (!f) return;
                    f.action = `/customer/${btn.dataset.id}`;
                    f.querySelector('#edit_id_pelanggan').value = btn.dataset.id;
                    f.querySelector('#edit_nama').value = btn.dataset.nama;
                    f.querySelector('#edit_no_hp').value = btn.dataset.noHp;
                    f.querySelector('#edit_deskripsi').value = btn.dataset.deskripsi;
                    f.querySelector('#edit_alamat').value = btn.dataset.alamat;
                });
            });
            document.querySelectorAll('[data-set-edit-status]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const f = document.getElementById('formEditStatus');
                    if (!f) return;
                    f.action = `/order/${btn.dataset.id}`;
                    f.querySelector('#edit_status_id').value = btn.dataset.id;
                    f.querySelector('#edit_status_val').value = btn.dataset.status;
                });
            });
            document.querySelectorAll('[data-set-edit-stok]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const f = document.getElementById('formEditStok');
                    if (!f) return;
                    f.action = `/stock/${btn.dataset.id}`;
                    f.querySelector('#edit_stok_id').value = btn.dataset.id;
                    f.querySelector('#edit_stok_nama').value = btn.dataset.name;
                    f.querySelector('#edit_stok_quantity').value = btn.dataset.quantity;
                    f.querySelector('#edit_stok_minstock').value = btn.dataset.minimumStock;
                    f.querySelector('#edit_stok_unit').value = btn.dataset.measurement;
                });
            });
        }

        onMounted(() => {
            bindDataButtons();
            if (window.__openModal) {
                const el = document.getElementById(window.__openModal);
                if (el) new bootstrap.Modal(el).show();
            }
        });

        function rupiah(n) {
            return 'Rp ' + Number(n).toLocaleString('id-ID');
        }

        return { sidebarCollapsed, toggleSidebar, setModalAction, rupiah };
    }
});

app.config.compilerOptions.isCustomElement = tag => tag.startsWith('ion-');

const el = document.getElementById('app');
if (el) app.mount('#app');