<h1><?php echo isset($data['post']['title']) ? $data['post']['title'] : ''; ?></h1>
<div>
    <img src="<?php echo isset($data['post']['photo_path']) ? $data['post']['photo_path'] : ''; ?>" alt="">
</div>
<div>
    <?php echo isset($data['post']['content']) ? $data['post']['content'] : ''; ?>
</div>