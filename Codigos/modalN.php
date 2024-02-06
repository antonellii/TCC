<div id="modal" class="modal">
  <div class="modal-content">
    <span class="close-modal" onclick="closeModal()">&times;</span>
    <h2>Notificações</h2>
    <ul id="notification-list">
    </ul>
  </div>
</div>

<style>
.modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.7);
  z-index: 9999;
}

.modal-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: black;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
}

.close-modal {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 20px;
  cursor: pointer;
}

#notification-list {
  list-style: none;
  padding: 0;
}

</style>

<script>
  function openModal() {
    var modal = document.getElementById("modal");
    modal.style.display = "block";

    var notificationList = document.getElementById("notification-list");
    notificationList.innerHTML = ""; // Limpa a lista antes de adicionar as novas notificações

    <?php
      // Substitua esta parte pela lógica de busca das notificações no banco de dados
      $sql = "SELECT mensagem, data_criacao FROM notifications WHERE user_id = $id_user";
      $result = $conexao->query($sql);

      if ($result !== false && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          $mensagem = $row['mensagem'];
          $data = substr($row['data_criacao'], 0, 10);

          echo "var notificationItem = document.createElement('li');";
          echo "notificationItem.textContent = '$mensagem / $data';";
          echo "notificationList.appendChild(notificationItem);";
        }
      } else {
        echo "var notificationItem = document.createElement('li');";
        echo "notificationItem.textContent = 'Nenhuma notificação encontrada';";
        echo "notificationList.appendChild(notificationItem);";
      }
    ?>
  
  }
  
  function closeModal() {
  var modal = document.getElementById("modal");
  modal.style.display = "none";
}

  // Restante do código
</script>
