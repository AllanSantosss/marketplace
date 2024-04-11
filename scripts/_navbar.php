

<header>    


    <nav class="navbar navbar-expand-lg bg-body-tertiary px-40">
        <div class="container">
            <a class="navbar-brand" style="font-size: 30px;" href="/"><strong>MARKETPLACE</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/produtos/index.php">Meus Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../chat/chat.php">Mensagens</a>
                    </li>
                    
                </ul>
                
                <form class="d-flex" role="search">
                    <?php if(isset($_SESSION["id"])) { ?>
                        <a class="btn btn-outline-primary" href="../logout.php">Logout</a>
                    <?php } else { ?>
                        <a class="btn btn-outline-success" href="../login.php">Login</a>
                    <?php } ?>
                </form>
                    
            </div>
        </div>
    </nav>
</header>