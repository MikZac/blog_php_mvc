
<h1>Edytuj post</h1>
    <form action="/posts?edit=<?php echo $data['post'][0]['id']?>" method="post" enctype="multipart/form-data">
      <div>
        <label>Meta title</label>
      <input type="text" name="title" value="<?php echo $data['post'][0]['title'];?>">
      </div>  
       <div>
        <label>Adres URL</label>
       <input type="text" name="sciezka" value="<?php echo $data['post'][0]['sciezka'];?>">
       </div> 
       <div>
       <div>
       <img src="<?php echo isset($data['post'][0]['photo_path']) ? $data['post'][0]['photo_path'] : ''; ?>" alt="">
       </div>
        <label>Zamień zdjęcie</label>
       <input type="file" name="photo" value="<?php echo $data['post'][0]['photo_path'];?>">
       </div>
        
        <textarea name="content" id="editor" value="">
        <?php echo $data['post'][0]['content'];?>  
        </textarea>
        <p><input type="submit" value="Edytuj wpis"></p>
    </form>

   
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>