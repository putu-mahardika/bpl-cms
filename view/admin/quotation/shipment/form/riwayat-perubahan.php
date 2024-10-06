<div class="row">
    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold">Riwayat Perubahan</h5>
    </div>
    <div class="col-md-12 mb-3">
        <ul class="timeline">
            <?php foreach ($quotationLog as $key => $value) {?>
                <li class="d-flex timeline-item">
                    <div class="timeline-box">
                        <div class="timeline-line"></div>
                        <div class="timeline-dots"></div>
                    </div>
                    <div class="ml-2 py-2">
                        <div class="font-italic">
                            <?php echo $value['created_at'] ?>
                        </div>
                        <div><?php echo $value['Note'] ?></div>
                        <small><?php echo $value['changes'] ?></small>
                    </div>
                </li>
            <?php }?>
        </ul>
    </div>
</div>