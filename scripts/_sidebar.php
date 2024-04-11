


<style>
.list-group-item {
    margin-bottom: 20px; 
}
</style>

<aside class="col-md-3">
    <h2>Categorias</h2>
    <div id="list-example" class="list-group">
        <?php
        $sql = "SELECT * FROM Categoria ORDER BY nome";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                
                
                echo '<a class="list-group-item list-group-item-action list-group-item-lightblue" href="index.php?categoria_id=' . $row["id"] . '">' . $row["nome"] . '</a>';

            }
        } else {
            echo "<p>Não existem resultados para esta pesquisa</p>";
        }
        ?>
    </div>
</aside>