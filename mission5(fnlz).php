<html>
	<head>
		<title>mission5</title>
	<meta charset = "utf-8">
	</head>
	<body>
		<?php
			$dsn = 'データベース名';
			$user = 'ユーザー名';
			$password = 'パスワード';
			$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
			if (!empty($_POST["del"]) && !empty($_POST["delpass"])) {
				$del = $_POST["del"];
				$delpass = $_POST["delpass"];
				$sql = 'delete from fiveth where id=:id && password=:password';
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':id', $del, PDO::PARAM_INT);
				$stmt->bindParam(':password', $delpass, PDO::PARAM_STR);
				$stmt->execute();
			}
			if (!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"]) && empty($_POST["editnum"])) {
				$name = $_POST["name"];
				$comment = $_POST["comment"];
				$times = date("Y:m:d H:i:s");
				$password = $_POST["password"];
				$sql = $pdo -> prepare("INSERT INTO fiveth (name, comment, times, password) VALUES (:name, :comment, :times, :password)");
				$sql -> bindParam(':name', $name, PDO::PARAM_STR);
				$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
				$sql -> bindParam(':times', $times, PDO::PARAM_STR);
				$sql -> bindParam(':password', $password, PDO::PARAM_STR);
				$sql -> execute();
			}
			if (!empty($_POST["editnum"]) && !empty($_POST["name"]) && !empty($_POST["comment"])) {
				$editnum = $_POST["editnum"];
				$name = $_POST["name"];
				$comment = $_POST["comment"];
				$password = $_POST["password"];
				$sql = 'update fiveth set name=:name,comment=:comment where id=:id && password=:password';
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':name', $name, PDO::PARAM_STR);
				$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
				$stmt->bindParam(':id', $editnum, PDO::PARAM_INT);
				$stmt->bindParam(':password', $password, PDO::PARAM_STR);
				$stmt->execute();
			}
			$sql = 'SELECT * FROM fiveth';
			$stmt = $pdo->query($sql);
			$results = $stmt->fetchAll();
			foreach ($results as $row){
				echo $row['id'].',';
				echo $row['name'].',';
				echo $row['comment'].',';
				echo $row['times'].'<br>';
			echo "<hr>";
			}
			$sql = "CREATE TABLE IF NOT EXISTS fiveth"
			."("
			."id INT AUTO_INCREMENT PRIMARY KEY,"
			."name char(32),"
			."comment TEXT,"
			."times DATETIME,"
			."password char(16)"
			.");";
			$stmt = $pdo->query($sql);
		?>
		<?php
			if(!empty($_POST["edit"])) {
				$edit = $_POST["edit"];
				$sql = 'SELECT * FROM fiveth';
				$stmt = $pdo->query($sql);
				$results = $stmt->fetchAll();
				foreach ($results as $row) {
					if($row['id'] == $edit) {
						$edname = $row['name'];
						$edcomment = $row['comment'];
					}
				}
			}
		?>
		<form action="" method="post">
		Name:
			<input type="text" name="name""
				value= "<?php
					if(!empty($_POST["edit"])) {
						echo $edname;
					}
					?>"
				placeholder="your name.">
			</input type>
		<br>
		Comment:
			<input type= "text" name= "comment" 
				value= "<?php
					if(!empty($_POST["edit"])) {
						echo $edcomment;
					}
					?>"
				placeholder="your comment.">
			</input type>
		<br>
		Password:
			<input type= "text" name= "password" value= "" placeholder="your password.">
			</input type>
		<br>
			<input type= "hidden" name= "editnum" 
				value= "<?php
						if(!empty($_POST["edit"])) {
							echo $_POST["edit"];
						}
					?>">
			</input type>
		<input type= "submit" value= "Submit"></p>
		<br>
		Delete No.:
			<input type= "text" name= "del" value="" placeholder="Give No.you gonna delete.">
			</input type>
		<br>
		Password:
			<input type = "text" name = "delpass" value = "" placeholder="your password.">
			</input type>
			<input type = "submit" value = "Delete"></p>
		<br>
		Edit No.:
			<input type= "text" name= "edit" value= "" placeholder="Give No. you gonna edit.">
			<input type= "submit" value= "Edit">
		<br>
		</form>
	</body>
</html>