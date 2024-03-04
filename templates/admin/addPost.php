<h1>Dodaj post</h1>
    <form action="/add-post" method="post" enctype="multipart/form-data">
      <div>
        <label>Meta title</label>
      <input type="text" name="title">
      </div>  
       <div>
        <label>Adres URL</label>
       <input type="text" name="sciezka">
       </div> 
       <div>
        <label>Zdjęcie wyróżniające</label>
       <input type="file" name="photo">
       </div>
        
        <textarea name="content" id="editor">
            
        </textarea>
        <p><input type="submit" value="Dodaj wpis"></p>
    </form>

   
    <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

    