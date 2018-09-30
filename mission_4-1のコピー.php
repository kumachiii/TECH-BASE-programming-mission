<?php
//3-1
//データベースへの接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);


//3-2
//テーブル作成
$sql="CREATE TABLE IF NOT EXISTS mission4"
//テーブルがなかったら作成
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
//PRIMARY NOT NULL PRIMARY
//小さい整数値から自動的に1ずつ増やした値を割り振るもの
."name TEXT,"
."comment TEXT,"
."date DATETIME,"
."pass TEXT"
.");";
$stmt=$pdo->query($sql);
//query「問い合わせ」
//データベースの検索で、指定された条件を満たす条件を取り出すために行われる処理要求


//変数宣言
$name=$_POST['name'];
$comment=$_POST['comment'];
$pass=$_POST['pass'];
$date=date("Y/m/d H:i:s");
$delete=$_POST['delete'];
$edit=$_POST['edit'];
$editnum=$_POST['editnum'];
$deletepass=$_POST['deletepass'];
$editpass=$_POST['editpass'];

//3-5 instertを行ってデータを入力
//追加機能or編集機能
if(!empty($name)and($comment)and($pass)){
	$sql=$pdo->prepare("INSERT INTO mission4(id,name,comment,date,pass) VALUES (:id,:name,:comment,:date,:pass)");
	$sql->bindParam(':id',$id,PDO::PARAM_STR);
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql->bindParam(':date',$date,PDO::PARAM_STR);
	$sql->bindParam(':pass',$pass,PDO::PARAM_STR);	
	//preapareのプレースホルダーの数とバインドしているものの数を合わせる
	
	$sql->execute();
	
	//3-8 updateにより編集
	if(!empty($editnum)){
		$nm=$_POST['name'];
		$kome=$_POST['comment'];
		$pasu=$_POST['pass'];
		$sql="update mission4 set name='$nm',comment='$kome',pass='$pass',time where id=$editnum";
		$result=$pdo->query($sql);
	}
}

//削除機能
if(!empty($delete)){
	//パスワード呼び出し
	$sql="SELECT pass FROM mission4 WHERE id=$delete";
	$stmt=$pdo->query($sql);
	//連想配列として取得
	$result=$stmt->fetch(PDO::FETCH_ASSOC);
	//fetch1件のみデータ取得、fetchAll結果データを全部まとめて取得
		
	foreach($result as $row){
		if($deletepass==$row){
			//3-8 入力したデータをdeleteによって削除
			$sql="delete from mission4 where id=$delete";
			$result=$pdo->query($sql);
		}else{
			echo"パスワードが違います。";
		}
	}
}

//編集機能（フォームに元の内容を表示させる処理）
if(!empty($edit)){
	$sql="SELECT pass FROM mission4 where id=$edit";
	$stmt=$pdo->query($sql);
	//連想配列として取得
	$result=$stmt->fetch(PDO::FETCH_ASSOC);
	
	foreach($result as $row){
		if($editpass==$row){
			$sql1="SELECT name from mission4 where id=$edit";
			$stmt1=$pdo->query($sql1);
			$editname=implode("",$stmt1->fetch(PDO::FETCH_ASSOC));
				
				$sql2="SELECT comment FROM mission4 where id=$edit";
				$stmt2=$pdo->query($sql2);
				$editcomment=implode("",$stmt2->fetch(PDO::FETCH_ASSOC));
		}else{
			echo"パスワードが違います。";
		}
	}
}


?>



<!DOCTYPE html>
<html lang="ja">
<head>
<mete charset="UTF-8">
</head>
<body>

<form method="post" action="mission_4-1.php">

<!--名前フォーム-->
<input type="text" name="name" placeholder="名前" value="<?php echo $editname; ?>"><br/>

<!--コメントフォーム-->
<input type="text" name="comment" placeholder="コメント" value="<?php echo $editcomment; ?>"><br/>

<!--編集フォーム（hiddenで隠す）-->
<input type="hidden" name="editnum" value="<?php echo $edit; ?>">

<!--パスワード-->
<input type="text" name="pass" placeholder="パスワード" value="" >

<!--送信ボタン-->
<input type="submit" value="送信"><br/>
<br/>


<!--削除フォーム-->
<input type="text" name="delete" value="" placeholder="削除対象番号"><br/>

<!--パスワード-->
<input type="text" name="deletepass" placeholder="パスワード" value="" >

<!--削除ボタン-->
<input type="submit" value="削除"><br/>
<br/>


<!--編集フォーム-->
<input type="text" name="edit" value="" placeholder="編集対象番号"><br/>

<!--パスワード-->
<input type="text" name="editpass" placeholder="パスワード" value="" >

<!--編集ボタン-->
<input type="submit" value="編集"><br/>
<br/>
</form>

</body>
</html>

<?php
//3-6

$sql='SELECT * FROM mission4';
$results=$pdo->query($sql);
foreach($results as $row){
	//$rowの中にはテーブルのカラム名が入る
	//カラム＝データベースに入っているデータの項目のこと
	echo$row['id'].',';
	echo$row['name'].',';
	echo$row['comment'].',';
	echo$row['date'].'<br>';
	}
?>
