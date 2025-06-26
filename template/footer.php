</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>



<script>

    AOS.init();

    
        const editModal = document.getElementById('editModal');
        
        if (editModal) {
            editModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nik = button.getAttribute('data-nik');
                const nama = button.getAttribute('data-nama');
                const jabatan = button.getAttribute('data-jabatan');
                const telepon = button.getAttribute('data-telepon');
                const foto = button.getAttribute('data-foto');

                const modalBodyInputId = editModal.querySelector('#edit_id_karyawan');
                const modalBodyInputNik = editModal.querySelector('#edit_nik');
                const modalBodyInputNama = editModal.querySelector('#edit_nama_lengkap');
                const modalBodyInputJabatan = editModal.querySelector('#edit_jabatan');
                const modalBodyInputTelepon = editModal.querySelector('#edit_nomor_telepon');
                const modalBodyInputFotoLama = editModal.querySelector('#edit_foto_lama');
                const modalBodyPreviewFoto = editModal.querySelector('#preview_foto_lama');

                modalBodyInputId.value = id;
                modalBodyInputNik.value = nik;
                modalBodyInputNama.value = nama;
                modalBodyInputJabatan.value = jabatan;
                modalBodyInputTelepon.value = telepon;
                modalBodyInputFotoLama.value = foto;
                modalBodyPreviewFoto.src = '<?php echo BASE_URL; ?>assets/uploads/' + foto;
            });
        }

        
        const keteranganModal = document.getElementById('keteranganModal');
        
        if (keteranganModal) {
            keteranganModal.addEventListener('show.bs.modal', event => {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');

                const modalInputId = keteranganModal.querySelector('#keterangan_id_karyawan');
                const modalInputNama = keteranganModal.querySelector('#keterangan_nama_karyawan');
                
                modalInputId.value = id;
                modalInputNama.value = nama;
            });
        }


    
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