<div class="row">
    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
        <h5 class="font-weight-bold">Riwayat Perubahan</h5>
    </div>
    <div class="col-md-12 mb-3">
        <ul class="timeline">
            <?php if (count($quotationLog) > 0) {?>
                <?php foreach ($quotationLog as $key => $value) {?>
                    <li class="d-flex timeline-item">
                        <div class="timeline-box">
                            <div class="timeline-line" <?php if($key == 0) {?>style="height: 50%; top: 50%"<?php }?> <?php if($key == count($quotationLog)-1) {?>style="height: 50%"<?php }?>></div>
                            <div class="timeline-dots"></div>
                        </div>
                        <div class="timeline-content ml-2 py-2" <?php if($key == 0) {?>style="color: #6777ef"<?php }?>>
                            <div class="font-italic font-weight-bold">
                                <?php echo $value['created_at'] ?>
                            </div>
                            <div><?php echo $value['Note'] ?></div>
                        </div>
                    </li>
                <?php }?>
            <?php } else {?>
                <div class="w-full text-center">Belum ada riwayat</div>
            <?php }?>
        </ul>
    </div>
</div>