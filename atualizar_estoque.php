<?php
  //  MEMORIA E TEMPO AUMENTADOS PARA INSERIR 1 MILHAO DE REGISTROS NO BANCO
    ini_set('memory_limit', '2G');
    set_time_limit(2000);

  // FUNCAO PARA VERIFICAR SE EXISTE ESTOQUE
    function verificar_estoque($produto, $cor, $tamanho, $deposito, $data_disp, $pdo) {
      try {
        $sql = "SELECT id FROM empresa.estoque WHERE produto=:produto AND cor=:cor AND tamanho=:tamanho AND deposito=:deposito AND data_disponibilidade=:data_disp";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':produto', $produto);
        $stmt->bindParam(':cor', $cor);
        $stmt->bindParam(':tamanho', $tamanho);
        $stmt->bindParam(':deposito', $deposito);
        $stmt->bindParam(':data_disp', $data_disp);
        $stmt->execute();    
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
          return $row['id'];
        }
        return 0;
      } catch (PDOException $e) {
        echo "Erro ao verificar o estoque: " . $e->getMessage();
        exit;
      }
    }

  // PRINCIPAL FUNCAO DO PROCESSO SELETIVO QUE ATUALIZA A QUANTIDADE DO ESTOQUE OU INSERE NOVO ESTOQUE DO PRODUTO
    function atualizar_estoque($json_produtos) {
      try {
        // ACESSO AO BANCO
          $host = "localhost";
          $dbname = "empresa";
          $dbuser = "root";
          $dbpass = "root";
          $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname.';', $dbuser, $dbpass);
  
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->beginTransaction();
  
        // UTILIZANDO LOTES PARA SALVAR AS INFORMAÇÕES PARCIAIS DOS COMMITS E PREVINIR FALHAS COM GRANDE QUANTIDADE DE INSERCOES DURANTE O PROCESSO
          $tamanho_lote = 1000;
          $contador = 0;
  
        foreach ($json_produtos as $estoque) {
          try {
            $produto = $estoque['produto'];
            $cor = $estoque['cor'];
            $tamanho = $estoque['tamanho'];
            $deposito = $estoque['deposito'];
            $data_disp = $estoque['data_disponibilidade'];
            $quantidade = $estoque['quantidade'];
            $id = verificar_estoque($produto, $cor, $tamanho, $deposito, $data_disp, $pdo);
            if ($id != 0) {
              try {
                // NESTA PARTE DO CÓDIGO FOI ENCONTRADO ESTOQUE DO PRODUTO COM A CHAVE ÚNICA, LOGO SERÁ ATUALIZADO A QUANTIDADE DO ESTOQUE
                  $sql = "UPDATE empresa.estoque SET quantidade=:quantidade WHERE id=:id";
                  $stmt = $pdo->prepare($sql);
                  $stmt->bindParam(':id', $id);
                  $stmt->bindParam(':quantidade', $quantidade);
                  $stmt->execute();    
              } catch (PDOException $e) {
                $pdo->rollBack();
                echo 'Falha ao atualizar quantidade do estoque: ' . $e->getMessage();
                exit;
              }
              continue;
            }
            // NESTA PARTE DO CÓDIGO NÃO FORAM ENCONTRADOS ESTOQUES DO PRODUTO DA CHAVE ÚNICA, LOGO SERÁ INSERIDO O NOVO ESTOQUE NO BANCO
              $sql = "INSERT INTO empresa.estoque (produto, cor, tamanho, deposito, data_disponibilidade, quantidade) VALUES (:produto, :cor, :tamanho, :deposito, :data_disp, :quantidade)";
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(':produto', $produto);
              $stmt->bindParam(':cor', $cor);
              $stmt->bindParam(':tamanho', $tamanho);
              $stmt->bindParam(':deposito', $deposito);
              $stmt->bindParam(':data_disp', $data_disp);
              $stmt->bindParam(':quantidade', $quantidade);
              $stmt->execute();
  
            // SE O CONTADOR ATINGE O TAMANHO DO LOTE, FAZER COMMIT E REINICIAR A TRANSAÇÃO
              $contador++;
              if ($contador % $tamanho_lote == 0) {
                $pdo->commit();
                $pdo->beginTransaction();
              }
          } catch (PDOException $e) {
            $pdo->rollBack();
            echo 'Falha ao inserir novo estoque com registro: ' . $contador . '<br>' . $e->getMessage();
            exit;
          }
        }
        $pdo->commit();
        echo "Estoques inseridos com sucesso.";
      } catch (PDOException $e) {
        $pdo->rollBack();
        echo 'Falha ao conectar com o banco: ' . $e->getMessage();
      }
    }

  // FUNCAO UTILIZADA PARA TESTES DE FORMA A GERAR N REGISTROS DE ESTOQUE
    function gerar_estoque($size) {
      $movimentacao_estoque = [];
      for ($i = 0; $i < $size; $i++) {
        $produto = sprintf('3.%03d.%05d', rand(1, 999), rand(1, 99999));
        $cor = sprintf('%02d', rand(0, 99));
        $tamanho = chr(rand(65, 90)); // Gera uma letra maiúscula
        $deposito = 'DEP' . rand(1, 20);
        $data_disponibilidade = date('Y-m-d', strtotime('+' . rand(0, 365) . ' days'));
        $quantidade = rand(1, 100);
        $movimentacao_estoque[] = [
          "produto" => $produto,
          "cor" => $cor,
          "tamanho" => $tamanho,
          "deposito" => $deposito,
          "data_disponibilidade" => $data_disponibilidade,
          "quantidade" => $quantidade
        ];
      }
      return $movimentacao_estoque;
    }

  $json_produtos = [];
  // EXEMPLO PARA TESTAR OS REGISTROS
    // $json_produtos = gerar_estoque(100);

  atualizar_estoque($json_produtos);
?>
