<?php if (!empty($flashes)): ?>
    <div class="container flash-container" style="margin-top: 20px;">
        <?php foreach ($flashes as $type => $messages): ?>
            <?php foreach ($messages as $msg): ?>
                <div class="alert alert-<?= htmlspecialchars($type) ?>" role="alert">
                    <?= htmlspecialchars($msg) ?>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
