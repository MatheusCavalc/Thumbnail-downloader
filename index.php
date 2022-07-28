<?php
  if(isset($_POST['button'])){ //retornando o conteúdo recuperado do URL
    $imgUrl = $_POST['imgurl'];
    $ch = curl_init($imgUrl); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $downloadImg = curl_exec($ch);
    curl_close($ch);
    header('Content-type: image/jpg');
    header('Content-Disposition: attachment;filename="thumbnail.jpg"');
    echo $downloadImg;
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thumbnail downloader</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>

  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <header>Download Thumbnail</header>
    <div class="url-input">
      <span class="title">Insira o url do vídeo:</span>

      <div class="field">
        <input type="text" placeholder="https://www.youtube.com/watch?v=lqwdD2ivIbM" required>
        <input class="hidden-input" type="hidden" name="imgurl">
        <span class="bottom-line"></span>
      </div>
    
    </div>
  
    <div class="preview-area">
      <img class="thumbnail" src="" alt="">
      <i class="icon fas fa-cloud-download-alt"></i>
      <span>Insira o url do vídeo para ver a prévia</span>
    </div>

    <button class="download-btn" type="submit" name="button">Baixar Thumbnail</button>
  
  </form>

  <script>
    const urlField = document.querySelector(".field input"),
    previewArea = document.querySelector(".preview-area"),
    imgTag = previewArea.querySelector(".thumbnail"),
    hiddenInput = document.querySelector(".hidden-input"),
    button = document.querySelector(".download-btn");

    urlField.onkeyup = ()=>{ // quando cntrl+v eh solto

      let imgUrl = urlField.value; //valor do campo = variavel
      previewArea.classList.add("active"); //div com nova class
      button.style.pointerEvents = "auto"; //button com novo valor de estilo pointer-events = auto

      if(imgUrl.indexOf("https://www.youtube.com/watch?v=") != -1){ // se a variavel imgUrl possuir o indexOf diferent de -1
        let vidId = imgUrl.split('v=')[1].substring(0, 11); //variavel = id do video
        let ytImgUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`; //api do youtube para salvar thumbs
        imgTag.src = ytImgUrl; // src do campo de imagem no DOM

      }else if(imgUrl.indexOf("https://youtu.be/") != -1){ 
        let vidId = imgUrl.split('be/')[1].substring(0, 11);
        let ytImgUrl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`;
        imgTag.src = ytImgUrl;

      }else{
        imgTag.src = "";
        button.style.pointerEvents = "none";
        previewArea.classList.remove("active");
      }
      hiddenInput.value = imgTag.src;
    }
  </script>

</body>
</html>
