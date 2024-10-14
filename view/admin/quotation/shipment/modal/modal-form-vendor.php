<!-- Modal -->
<div class="modal fade" id="modal_add_vendor" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bolder" id="exampleModalLabel">Tambah Vendor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Kode :</label>
                        <input type="text" class="form-control mb-3 inputmask_code" id="kode" name="kode" maxlength="6" placeholder="Isikan kode...">
                    </div>
                    <div class="col-md-12">
                        <label>Nama :</label>
                        <input type="text" class="form-control mb-3" id="nama" name="nama" minlength="3" maxlength="30" placeholder="Isikan nama...">
                    </div>
                    <div class="col-md-12">
                        <label>Alamat :</label>
                        <input type="text" class="form-control mb-3" id="alamat" name="alamat" minlength="7" maxlength="150" placeholder="Isikan alamat...">
                    </div>
                    <div class="col-md-12">
                        <label>NPWP :</label>
                        <input type="text" class="form-control mb-3 inputmask_npwp" id="npwp" name="npwp" pattern="^([\d]{2})[.]([\d]{3})[.]([\d]{3})[.][\d][-]([\d]{3})[.]([\d]{3})$" title="NPWP harus dituliskan seperti berikut XX.XXX.XXX.X-XXX.XXX" placeholder="Isikan npwp...">
                    </div>
                    <div class="col-md-12">
                        <label>Nama PIC :</label>
                        <input type="text" class="form-control mb-3" id="pic" name="pic" minlength="3" maxlength="50" placeholder="Isikan nama PIC...">
                    </div>
                    <div class="col-md-12">
                        <label>Telp PIC :</label>
                        <input type="text" class="form-control mb-3 inputmask_phone" id="pic_telp" name="pic_telp" pattern="^0\d{10,14}|62\d{10,14}$" title="nomor telp harus terdiri dari 10-14 angka dan harus berawalan 0 atau 62" placeholder="Isikan nama Telp PIC...">
                    </div>
                    <div class="col-md-12">
                        <label>Tipe :</label>
                        <select name="tipe" class="form-control mb-3" id="type">
                            <option disabled selected> Pilih </option>
                            <option value=Local> Local </option>
                            <option value=Oversea> Oversea </option>
                            <option value=All> Semua </option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label>Tipe Pengiriman :</label>
                        <select name="tipe_pengiriman" class="form-control mb-3" id="delivery_type">
                            <option disabled selected> Pilih </option>
                            <option value=Shipment> Shipment </option>
                            <option value=Trucking> Trucking </option>
                            <option value=All> Semua </option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label>Link Dokumen :</label>
                        <input type="text" class="form-control mb-3" id="link" name="dokumen" minlength="3" required>
                    </div>
                    <div class="col-md-12">
                        <label>Keterangan :</label>
                        <textarea type="text" class="form-control mb-3" id="note_vendor" name="keterangan"></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="mr-3">Status :</label>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="active" name="status" class="custom-control-input" checked>
                            <label class="custom-control-label" for="active">Aktif</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="nonactive" name="status" class="custom-control-input">
                            <label class="custom-control-label" for="nonactive">Non Aktif</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="createVendor()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('.inputmask_code').inputmask({regex: '[0-9|A-Z|a-z]*', casing: 'upper'});
    $('.inputmask_phone').inputmask({'mask': '9999-9999-9999', 'autoUnmask': true});
    $('.inputmask_npwp').inputmask({'mask': '99.999.999.9-999.999'});

    getValidateVendor = () => {
        if ($('#kode').val().length < 3) {
            toastr.error('Kolom Kode minimal 3 karakter', 'Required!')
            return true;
        }

        if ($('#kode').val() == '' || $('#kode').val() == null) {
            toastr.error('Kode harus diisi', 'Required!')
            return true;
        }

        if ($('#alamat').val() == '' || $('#alamat').val() == null) {
            toastr.error('Alamat harus diisi', 'Required!')
            return true;
        }

        if ($('#npwp').val() == '' || $('#npwp').val() == null) {
            toastr.error('NPWP harus diisi', 'Required!')
            return true;
        }

        if ($('#pic').val() == '' || $('#pic').val() == null) {
            toastr.error('PIC harus diisi', 'Required!')
            return true;
        }

        if ($('#pic_telp').val() == '' || $('#pic_telp').val() == null) {
            toastr.error('PIC Telp harus diisi', 'Required!')
            return true;
        }

        if ($('#type').val() == '' || $('#type').val() == null) {
            toastr.error('Tipe harus diisi', 'Required!')
            return true;
        }

        if ($('#delivery_type').val() == '' || $('#delivery_type').val() == null) {
            toastr.error('Tipe pengiriman harus diisi', 'Required!')
            return true;
        }

        if ($('#note_vendor').val() == '' || $('#note_vendor').val() == null) {
            toastr.error('Keterangan harus diisi', 'Required!')
            return true;
        }

        return false;
    };

    createVendor = () => {
        if (getValidateVendor()) {
            return;
        }
        var data = {
            method: 'createData',
            kode: $('#kode').val(),
            nama: $('#nama').val(),
            alamat: $('#alamat').val(),
            npwp: $('#npwp').val(),
            pic: $('#pic').val(),
            pic_telp: $('#pic_telp').val(),
            type: $('#type').val(),
            delivery_type: $('#delivery_type').val(),
            link: $('#link').val(),
            note: $('#note_vendor').val(),
        };
        console.log(data);

        // Swal.fire({
        //     title: "Loading...",
        //     html: "Sedang menyimpan data",
        //     timerProgressBar: true,
        //     allowOutsideClick: false, // Tidak bisa ditutup dengan mengklik di luar
        //     allowEscapeKey: false, // Tidak bisa ditutup dengan tombol Escape
        //     didOpen: () => {
        //         Swal.showLoading();
        //     },
        // });

        $.ajax({
            url: '<?php echo $base_url; ?>/config/controller/vendorControllerV2.php',
            type: 'POST',
            data: data,
            success: function(response) {
                console.log(`RESP: ${response}`);
                let resp = JSON.parse(response);
                console.log(`RESP: ${resp.data}`);
                if (resp.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data berhasil disimpan',
                    }).then(() => {
                        window.location.reload();
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat menyimpan data',
                });
            }
        });
    }   
</script>