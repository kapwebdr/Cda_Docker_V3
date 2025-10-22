<!DOCTYPE html>
<form action="/upload" 
    method="post" 
    enctype="multipart/form-data"
>
    <input type="file" multiple name="fichiers[]"/>
    <input type="text" name="nom"/>
    <input type="submit" name="Uploader"/>

</form>