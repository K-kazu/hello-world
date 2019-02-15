<?php
	$dsn = 'データベース';
	$user = 'ユーザー名';
	$password ='パスワード';
	$pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE =>
	PDO::ERRMODE_WARNING));
	//MySQLに接続

	$sql = "CREATE TABLE IF NOT EXISTS mission41"
	."("
	."id INT,"
	."name char(32),"
	."comment TEXT,"
	."time DATETIME,"
	."pass char(32)"
	.");";
	$stmt = $pdo->query($sql);
	//テーブル作成

	$B = "";//フォームの"名前"の初期値
	$C = "";//フォームの"コメント"の初期値
	$P = "";//フォームの"password"の初期値
	if(isset($_POST['botan1'])){        //送信ボタンが押された時の処理　開始
		if(empty($_POST['edit2'])){       //通常の入力処理（非編集モード）開始
			if(!empty($_POST['comment']) && !empty($_POST['name']) && !empty($_POST['pass1'])){
				$sql = 'SELECT*FROM mission41';
				$stmt = $pdo->query($sql);
				$results = $stmt->fetchAll();
				if (!empty($results)){foreach($results as $row){$count = $row['id'] + 1;}}
				else{$count = 1;}
				$time1 = date("Y/m/d H:i:s");
				$sql = $pdo ->prepare("INSERT INTO mission41(id,name,comment,time,pass)VALUES(:id,:name,:comment,:time,:pass)");
				$sql ->bindParam(':id',$id,PDO::PARAM_STR);
				$sql ->bindParam(':name',$name,PDO::PARAM_STR);
				$sql ->bindParam(':comment',$comment,PDO::PARAM_STR);
				$sql ->bindParam(':time',$time,PDO::PARAM_STR);
				$sql ->bindParam(':pass',$pass,PDO::PARAM_STR);
				$id = $count;
				$name = $_POST['name'];
				$comment = $_POST['comment'];
				$time = $time1;
				$pass = $_POST['pass1'];
				$sql ->execute();
			}       //通常の入力処理（非編集モード）終わり
		}else{     //編集モードでの入力処理　開始
			if(!empty($_POST['comment']) && !empty($_POST['name']) && !empty($_POST['pass1'])){
				$time1 = date("Y/m/d H:i:s");
				$sql = 'SELECT*FROM mission41';
				$stmt = $pdo->query($sql);
				$results = $stmt->fetchAll();
				if(!empty($results)){foreach($results as $row){$count = $row['id'] + 1;}}
				else{$count = 1;}
				$time1 = date("Y/m/d H:i:s");
					$sql = 'delete from mission41';
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':id',$id,PDO::PARAM_INT);
					$stmt->execute();
				for($i = 1;$i < $_POST['edit2'];$i++){
					$sql = $pdo ->prepare("INSERT INTO mission41(id,name,comment,time,pass)VALUES(:id,:name,:comment,:time,:pass)");
					$sql ->bindParam(':id',$id,PDO::PARAM_STR);
					$sql ->bindParam(':name',$name,PDO::PARAM_STR);
					$sql ->bindParam(':comment',$comment,PDO::PARAM_STR);
					$sql ->bindParam(':time',$time,PDO::PARAM_STR);
					$sql ->bindParam(':pass',$pass,PDO::PARAM_STR);
					$id = $results[$i - 1]['id'];
					$name = $results[$i - 1]['name'];
					$comment = $results[$i - 1]['comment'];
					$time = $results[$i - 1]['time'];
					$pass = $results[$i - 1]['pass'];
					$sql ->execute();
				}
				$sql = $pdo ->prepare("INSERT INTO mission41(id,name,comment,time,pass)VALUES(:id,:name,:comment,:time,:pass)");
				$sql ->bindParam(':id',$id,PDO::PARAM_STR);
				$sql ->bindParam(':name',$name,PDO::PARAM_STR);
				$sql ->bindParam(':comment',$comment,PDO::PARAM_STR);
				$sql ->bindParam(':time',$time,PDO::PARAM_STR);
				$sql ->bindParam(':pass',$pass,PDO::PARAM_STR);
				$id = $_POST['edit2'];
				$name = $_POST['name'];
				$comment = $_POST['comment'];
				$time = $time1;
				$pass = $_POST['pass1'];
				$sql ->execute();
				for($i = $_POST['edit2'];$i < count($results);$i++){
					$sql = $pdo ->prepare("INSERT INTO mission41(id,name,comment,time,pass)VALUES(:id,:name,:comment,:time,:pass)");
					$sql ->bindParam(':id',$id,PDO::PARAM_STR);
					$sql ->bindParam(':name',$name,PDO::PARAM_STR);
					$sql ->bindParam(':comment',$comment,PDO::PARAM_STR);
					$sql ->bindParam(':time',$time,PDO::PARAM_STR);
					$sql ->bindParam(':pass',$pass,PDO::PARAM_STR);
					$id = $results[$i]['id'];
					$name = $results[$i]['name'];
					$comment = $results[$i]['comment'];
					$time = $results[$i]['time'];
					$pass = $results[$i]['pass'];
					$sql ->execute();
				}
			}
		}       //編集モードでの入力処理　終わり
	}        //送信ボタンが押された時の処理　終わり
	else{       //送信ボタンが押された時以外の処理（＊とおく）　開始
		if(isset($_POST['botan2'])){      //削除ボタンが押された時の処理　開始
			if(!empty($_POST['delete']) && !empty($_POST['pass2'])){
				$sql = 'SELECT*FROM mission41';
				$stmt = $pdo->query($sql);
				$results = $stmt->fetchAll();
				$A2 = 0;     //passがあってるか確認の変数
				foreach($results as $row){
					if($row['id'] == $_POST['delete'] ){
						if($row['pass'] == $_POST['pass2']){$A2 = 1;}
						else {echo "パスワードが違います";}
					}
				}
				$AA = 1;      //idのつけ直すための変数
				if($A2 == 1){
					$sql = 'delete from mission41';
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':id',$id,PDO::PARAM_INT);
					$stmt->execute();
					for($i = 1;$i < $_POST['delete'];$i++){
						$sql = $pdo ->prepare("INSERT INTO mission41(id,name,comment,time,pass)VALUES(:id,:name,:comment,:time,:pass)");
						$sql ->bindParam(':id',$id,PDO::PARAM_STR);
						$sql ->bindParam(':name',$name,PDO::PARAM_STR);
						$sql ->bindParam(':comment',$comment,PDO::PARAM_STR);
						$sql ->bindParam(':time',$time,PDO::PARAM_STR);
						$sql ->bindParam(':pass',$pass,PDO::PARAM_STR);
						$id = $AA++;
						$name = $results[$i - 1]['name'];
						$comment = $results[$i - 1]['comment'];
						$time = $results[$i - 1]['time'];
						$pass = $results[$i - 1]['pass'];
						$sql ->execute();
					}
					for($i = $_POST['delete'];$i < count($results);$i++){
						$sql = $pdo ->prepare("INSERT INTO mission41(id,name,comment,time,pass)VALUES(:id,:name,:comment,:time,:pass)");
						$sql ->bindParam(':id',$id,PDO::PARAM_STR);
						$sql ->bindParam(':name',$name,PDO::PARAM_STR);
						$sql ->bindParam(':comment',$comment,PDO::PARAM_STR);
						$sql ->bindParam(':time',$time,PDO::PARAM_STR);
						$sql ->bindParam(':pass',$pass,PDO::PARAM_STR);
						$id = $AA++;
						$name = $results[$i]['name'];
						$comment = $results[$i]['comment'];
						$time = $results[$i]['time'];
						$pass = $results[$i]['pass'];
						$sql ->execute();
					}
				}
			}
		}      //削除ボタンが押された時の処理　終わり
		elseif(isset($_POST['botan3'])){           //送信ボタンが押された時以外＆＆削除ボタンが押された時以外　で編集ボタンが押された時の処理（＊＊とおく）　開始
			if(!empty($_POST['edit']) && !empty($_POST['pass3'])){
				$sql = 'SELECT*FROM mission41';
				$stmt = $pdo->query($sql);
				$results = $stmt->fetchAll();
				foreach($results as $row){
					if($row['id'] == $_POST['edit'] ){
						if($row['pass'] == $_POST['pass3']){
							$B = $row['name'];
							$C = $row['comment'];
							$P = $row['pass'];
						}
						else {echo "パスワードが違います";}
					}
				}
			}
		}      //（＊＊） 終わり
	}      //（＊）　終わり
/*削除機能と編集機能はほぼ同じ．１．データすべて消す　２．指定したidより前をinsert　３．指定したidの情報insert　４．指定したidより後をinsert
行程３の有無がその違い．ついでにidは削除後つけ直すようにした$count.
deleteを用いて削除すると，その次の入力位置がdeleteした場所からになってしまった*/
?>
<html>
	<head>
		<meta charset = "utf-8">
	</head>
	<body>
		<form action = "mission_4-1.php" method = "post">
			<?php
				if($C == ""){echo"<input type = 'text' name = 'comment' placeholder = 'コメント'><br>";}
				else{echo"<input type = 'text' name = 'comment' value = '".$C."'><br>";}
				if($B == ""){echo"<input type = 'text' name = 'name' placeholder = '名前'><br>";}
				else{echo"<input type = 'text' name = 'name' value = '".$B."'><br>";}
				if(!empty($_POST['edit'])){echo"<input type = 'hidden' name = 'edit2' value = '".$_POST['edit']."'>";}
				else{echo"<input type = 'hidden' name = 'edit2'>";}
				if($P == ""){echo"<input type = 'text' name = 'pass1' placeholder = 'パスワード'>";}
				else{echo"<input type = 'text' name = 'pass1' value = '".$P."'>";}
				echo"<input type = 'submit' name = 'botan1' value = '送信'><br><br>";
				echo"<input type = 'text' name = 'delete' placeholder = '削除対象番号'><br>";
				echo"<input type = 'text' name ='pass2' placeholder = 'パスワード'>";
				echo"<input type = 'submit' name = 'botan2' value = '削除'><br><br>";
				echo"<input type = 'text' name = 'edit' placeholder = '編集対象番号'><br>";
				echo"<input type = 'text' name ='pass3' placeholder = 'パスワード'>";
				echo"<input type = 'submit' name = 'botan3' value = '編集'><br>";
			?>
		</form>
		<?php
			$sql = 'SELECT*FROM mission41';
			$stmt = $pdo->query($sql);
			$results = $stmt->fetchAll();
			foreach($results as $row){
				echo $row['id'].' ';
				echo $row['name'].' ';
				echo $row['comment'].' ';
				echo $row['time'].'<br>';
			}
		?>
	</body>
</html>