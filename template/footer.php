</div> </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script src="<?php echo BASE_URL; ?>assets/js/script.js"></script>

    <script>
        // Inisialisasi AOS
        AOS.init();
        // Script untuk mengisi data ke modal edit
const editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', event => {
    // Tombol yang memicu modal
    const button = event.relatedTarget;
    
    // Ekstrak info dari atribut data-*
    const id = button.getAttribute('data-id');
    const nik = button.getAttribute('data-nik');
    const nama = button.getAttribute('data-nama');
    const jabatan = button.getAttribute('data-jabatan');
    const telepon = button.getAttribute('data-telepon');
    const foto = button.getAttribute('data-foto');

    // Dapatkan elemen form di dalam modal
    const modalBodyInputId = editModal.querySelector('#edit_id_karyawan');
    const modalBodyInputNik = editModal.querySelector('#edit_nik');
    const modalBodyInputNama = editModal.querySelector('#edit_nama_lengkap');
    const modalBodyInputJabatan = editModal.querySelector('#edit_jabatan');
    const modalBodyInputTelepon = editModal.querySelector('#edit_nomor_telepon');
    const modalBodyInputFotoLama = editModal.querySelector('#edit_foto_lama');
    const modalBodyPreviewFoto = editModal.querySelector('#preview_foto_lama');

    // Update isi dari elemen form
    modalBodyInputId.value = id;
    modalBodyInputNik.value = nik;
    modalBodyInputNama.value = nama;
    modalBodyInputJabatan.value = jabatan;
    modalBodyInputTelepon.value = telepon;
    modalBodyInputFotoLama.value = foto;
    modalBodyPreviewFoto.src = '<?php echo BASE_URL; ?>assets/uploads/' + foto;
});

        // Script untuk toggle sidebar (opsional)
        const sidebarToggle = document.querySelector("#sidebarToggle");
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', event => {
                event.preventDefault();
                document.body.classList.toggle('sb-sidenav-toggled');
            });
        }
    </script>
</body>
</html>