<div>Blog</div>

<?php foreach($data['posts'] as $posts): ?>
       <div>
        <h2><?php echo $posts["title"]; ?></h2>
        <div>
            <img src="<?php echo $posts["photo_path"] ?>" >
        </div>
        <a href="<?php echo "/blog/".$posts["sciezka"]."-".$posts["id"] ?>">Czytaj więcej</a>
       </div>
        <?php endforeach; ?>