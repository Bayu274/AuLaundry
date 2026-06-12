</div><!-- /#content -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function() {
    // === SIDEBAR TOGGLE ===
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');
    const closeBtn = document.getElementById('sidebarClose');

    function openSidebar() {
        if (sidebar) sidebar.classList.add('show');
        if (overlay) overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        if (sidebar) sidebar.classList.remove('show');
        if (overlay) overlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (sidebar && sidebar.classList.contains('show')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            closeSidebar();
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function() {
            closeSidebar();
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeSidebar();
    });

    // === HITUNG HARGA OTOMATIS ===
    const layananHarga = {
        'Lengkap':             { 'Ekspres': 12000, 'Cepat': 9000, 'Reguler': 6000, 'Hemat': 4500 },
        'Setrika':             { 'Ekspres': 11000, 'Cepat': 8000, 'Reguler': 5000, 'Hemat': 3500 },
        'Cuci Kering':         { 'Ekspres': 11500, 'Cepat': 8500, 'Reguler': 5500, 'Hemat': 4000 },
        'Cuci Basah':          { 'Ekspres': 10500, 'Cepat': 7500, 'Reguler': 4500, 'Hemat': 3000 },
        'Jas Lengkap':         { 'Ekspres': 40000, 'Cepat': 35000, 'Reguler': 30000, 'Hemat': 25000 },
        'Jas Atasan':          { 'Ekspres': 35000, 'Cepat': 30000, 'Reguler': 25000, 'Hemat': 20000 },
        'Sepatu Besar':        { 'Ekspres': 35000, 'Cepat': 30000, 'Reguler': 25000, 'Hemat': 20000 },
        'Sepatu Anak-anak':    { 'Ekspres': 25000, 'Cepat': 20000, 'Reguler': 15000, 'Hemat': 10000 },
        'Bed Cover':           { 'Ekspres': 15000, 'Cepat': 12000, 'Reguler': 9000, 'Hemat': 7500 },
        'Bantal Guling Besar': { 'Ekspres': 40000, 'Cepat': 35000, 'Reguler': 30000, 'Hemat': 25000 },
        'Bantal Guling Kecil': { 'Ekspres': 30000, 'Cepat': 25000, 'Reguler': 20000, 'Hemat': 15000 },
        'Sprei/Selimut':       { 'Ekspres': 14000, 'Cepat': 11000, 'Reguler': 8000, 'Hemat': 6500 },
        'Karpet Tebal':        { 'Ekspres': 17000, 'Cepat': 14000, 'Reguler': 11000, 'Hemat': 9500 },
        'Karpet Tipis':        { 'Ekspres': 15000, 'Cepat': 12000, 'Reguler': 9000, 'Hemat': 7500 },
        'Helm':                { 'Ekspres': 35000, 'Cepat': 30000, 'Reguler': 25000, 'Hemat': 20000 }
    };

    const jenisLayanan = document.getElementById('jenis_layanan');
    const jenisWaktu = document.getElementById('jenis_waktu');
    const beratInput = document.getElementById('berat');
    const totalBayarDisplay = document.getElementById('total_bayar_display');
    const totalBayarHidden = document.getElementById('total_bayar');

    function hitungHarga() {
        if (!jenisLayanan || !jenisWaktu || !beratInput) return;

        const layanan = jenisLayanan.value;
        const waktu = jenisWaktu.value;
        const jumlah = parseFloat(beratInput.value) || 0;

        if (layanan && waktu && jumlah > 0 && layananHarga[layanan] && layananHarga[layanan][waktu]) {
            const hargaPerUnit = layananHarga[layanan][waktu];
            const total = Math.round(hargaPerUnit * jumlah);
            if (totalBayarDisplay) totalBayarDisplay.value = 'Rp ' + total.toLocaleString('id-ID');
            if (totalBayarHidden) totalBayarHidden.value = total;
        } else {
            if (totalBayarDisplay) totalBayarDisplay.value = '';
            if (totalBayarHidden) totalBayarHidden.value = '';
        }
    }

    if (jenisLayanan) jenisLayanan.addEventListener('change', hitungHarga);
    if (jenisWaktu) jenisWaktu.addEventListener('change', hitungHarga);
    if (beratInput) beratInput.addEventListener('input', hitungHarga);

    // Hitung harga saat halaman dimuat (untuk edit pesanan)
    hitungHarga();
})();
</script>
</body>
</html>
