<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?= form_open('keranjang/edit') ?>

<!-- Notifikasi Diskon -->
<?php if (session()->get('diskon_nominal')): ?>
    <div class="alert alert-success">
        <i class="bi bi-tag"></i> Diskon Hari Ini: Rp<?= number_format(session()->get('diskon_nominal')) ?> per item
    </div>
<?php endif; ?>

<table class="table datatable">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Foto</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        $total = 0;
        $diskon = session()->get('discount_nominal') ?? 0;

        if (!empty($items)) :
            foreach ($items as $item) :
                $hargaAsli = $item['options']['harga_asli'] ?? $item['price'];
                $hargaDiskon = max($hargaAsli - $diskon, 0);
                $subtotal = $hargaDiskon * $item['qty'];
                $total += $subtotal;
        ?>
                <tr>
                    <td><?= esc($item['name']) ?></td>
                    <td>
                        <?php if (!empty($item['options']['foto'])): ?>
                            <img src="<?= base_url('img/' . esc($item['options']['foto'])) ?>" width="100px">
                        <?php endif; ?>
                    </td>
                    <td><?= number_to_currency($hargaDiskon, 'IDR') ?></td>
                    <td>
                        <input type="number" name="qty<?= $i++ ?>" min="1" class="form-control" value="<?= esc($item['qty']) ?>">
                    </td>
                    <td><?= number_to_currency($subtotal, 'IDR') ?></td>
                    <td>
                        <a href="<?= base_url('keranjang/delete/' . esc($item['rowid'])) ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus item ini?')">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
        <?php
            endforeach;
        endif;
        ?>
    </tbody>
</table>

<div class="alert alert-info">
    <strong>Total = <?= number_to_currency($total, 'IDR') ?></strong>
</div>

<button type="submit" class="btn btn-primary">Perbarui Keranjang</button>
<a href="<?= base_url('keranjang/clear') ?>" class="btn btn-warning">Kosongkan Keranjang</a>
<?php if (!empty($items)) : ?>
    <a href="<?= base_url('checkout') ?>" class="btn btn-success">Selesai Belanja</a>
<?php endif; ?>

<?= form_close() ?>
<?= $this->endSection() ?>