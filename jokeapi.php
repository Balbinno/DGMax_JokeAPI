<!DOCTYPE html>
<html>
<head>
<!-- Personalização em CSS dos elementos contidos na página -->
  <style type="text/css">
    body{
      background-color: #484D50;
    }
    .box-container{
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .box{
      background:white;
      border-radius: 15px;
      box-shadow: 3px 10px 15px #abc;
      display: flex;
      align-items: center;
      text-align: center;
      font-size:30px;
      padding:50px;
      font-family: monospace;
      font-weight: bold;
      position: relative;
    }
    .tag{
      position: absolute;
      top: 0;
      left: 0;
      font-size: 15px;
      background-color: #666;
      color:#fff;
      padding:5px 10px;
    }
    
    .search-container {
      display: all;
      justify-content: center;
      position: absolute;
      top: 0px;
      left: 0;
      right: 0;
    }
    .search-form {
      display: all;
      align-items: center;
      background: white;
      border-radius: 0px;
      box-shadow: 3px 10px 15px #abc;
      padding: 20px;
    }
    .search-form label {
      margin-right: 10px;
      font-size: 20px
      
    }
    .search-form select,
    .search-form input[type="text"],
    .search-form input[type="submit"] {
      font-size: 15px;
      padding: 5px;
      border: none;
      background: black;
      border-radius: 5px;
      border-color: black;
      color: white;
    }
  </style>
</head>
<body>

<!-- Barra de pesquisa de piadas com os filtros de certas categorias -->
  <div class="search-container">
    <form class="search-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label for="filter">Joke Filter:</label>
      <select id="filter" name="filter">
        <option value="Any">Any Category</option>
        <option value="Miscellaneous">Miscellaneous</option>
        <option value="Programming">Programming</option>
        <option value="Pun">Joke Pun</option>
      </select>

      <label for="keyword"> Key Word:</label>
      <input type="text" id="keyword" name="keyword">

      <input type="submit" value="Search">
    </form>
  </div>
  
  <!-- Conexão com a API -->
  <?php
  //Verificação do envio de forrmulário
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keyword = $_POST['keyword'];
    $filter = $_POST['filter'];

    //Busca na API com base nos filtros de pesquisa
    $api_url = "https://v2.jokeapi.dev/joke/$filter?contains=$keyword";
    $jokes = json_decode(file_get_contents($api_url));
  } else {
      //Busca padrão na API
    $api_url = "https://v2.jokeapi.dev/joke/Any";
    $jokes = json_decode(file_get_contents($api_url));
  }
  ?>

<!-- Exibição das piadas, incluindo as informações de categoria -->
  <div class="box-container">
    <div class="box">
      <div class="box-content">
        <?php if (!empty($jokes->joke)) { ?>
          <div class="tag">
            <?php echo $jokes->category;?>
          </div>
          <?php if($jokes->type=='single'){?>
            <span><?php echo $jokes->joke;?></span>
          <?php } else { ?>
            <span><?php echo $jokes->setup;?></span>
            <hr>
            <span><?php echo $jokes->delivery;?></span>
          <?php } ?>
        <?php } else { ?>
        <!-- Exibe esta mensagem caso não retorne nenhuma piada -->
          <span>No joke available.</span>
        <?php } ?>
      </div>
    </div>
  </div>
</body>
</html>