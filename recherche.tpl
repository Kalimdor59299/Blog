<form  method="get" action="recherche.php">
  <div class="form-group">
      <input type="text" class="form-control" id="recherche" name="recherche">
  </div>  
  <button type="submit" class="btn btn-primary">Recherche</button>
</form>

                   


<div class="container">

    {if isset($smarty.session.notification)}
        <div class="row">
            <div clas "col-12">
                <div class="alert alert-{$smarty.session.notification.result}" role="alert">
                    {$smarty.session.notification.message}
                 
                </div>
            </div>
        </div>
    {/if}
   
   
        <div class="row">
           
            {foreach from=$array item=value}
               
                <div class="col-6">  
                    <div class="card" style="width: 100%;">
                        <img src="img/{$value.id}.jpg" class="card-img-top" alt="{$value.id}">
                        <div class="card-body">
                            <h5 class="card-title">{$value.titre}</h5>
                            <p class="card-text">{$value.texte}</p>
                            <a href="#" class="btn btn-primary">{$value.date_fr}</a>
                            <a href="article.php id={$value.id} &action=modifier" class="btn btn-primary">Modifier l'article</a>
                           
                        </div>
                    </div>
                </div>
          {/foreach}
        </div>
       
        <div class="row">
            <div class="col-12">
                <nav>
                    <ul class="pagination pagination-lg">
                                    {for $index=1 to $nb_total_pages}
                        <li class="page-item {if $page_courante == $index } $active{/if}"><a class="page-link" href="?p={$index}" >{$index}</a></li>
                        {/for}
                    </ul>
                </nav>
            </div>
        </div>
</div>
       
                   
                   
        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.slim.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        </body>

        </html>