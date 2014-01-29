<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>売りたい書籍のリスト作成 for 電脳書房</title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::js('//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js'); ?>

	<script>
	// クリックした table の行のセルの値を取得
	$(document).on('click', '#books td', function() {
		var tr = $(this).parent()[0];
		var title = $(tr).children().eq(0).text();
		var isbn  = $(tr).children().eq(1).text();
		//console.log(title);
		//console.log(isbn);
		
		$.ajax({
			type: 'POST',
			url: './cart/add',
			data: {'title': title, 'isbn': isbn},
			dataType: 'json',
			success: function(data) {
				alert(data.status);
				location.reload();
			},
			error: function() {
				alert('Post Error');
			}
		});
	});
	
	$(document).on('click', '#cart td', function() {
		var tr = $(this).parent()[0];
		var title = $(tr).children().eq(0).text();
		var isbn  = $(tr).children().eq(1).text();
		//console.log(title);
		//console.log(isbn);
		
		$.ajax({
			type: 'POST',
			url: './cart/delete',
			data: {'title': title, 'isbn': isbn},
			dataType: 'json',
			success: function(data) {
				alert(data.status);
				location.reload();
			},
			error: function() {
				alert('Post Error');
			}
		});
	});
	</script>
</head>

<body>
<h1>売りたい書籍のリスト作成 for 電脳書房</h1>

		<form method="get" action="<?php echo Uri::current(); ?>">
	書籍タイトル： <input type="search" name="q" value="<?php echo $keyword; ?>">
	<input type="submit" value="検索">
</form>

<hr>

<h2>検索結果</h2>
追加したい書籍をクリック

<?php if (isset($results)): ?>
<table id="books" border="1">
<?php foreach ($results as $item): ?>
	<tr>
		<td><?php echo $item['title']; ?></td>
		<td><?php echo $item['isbn']; ?></td>
		<td><?php echo $item['publisher']; ?></td>
		<td><?php echo $item['pubDate']; ?></td>
		<td><a href="<?php echo $item['link']; ?>"><?php echo $item['link']; ?></a></td>
	</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>

<hr>

<h2>登録済み書籍</h2>
削除したい書籍をクリック

<table id="cart" border="1">
<?php foreach ($cart as $isbn => $title): ?>
	<tr>
		<td><?php echo $title; ?></td>
		<td><?php echo $isbn; ?></td>
	</tr>
<?php endforeach; ?>
</table>

<a href="<?php echo Uri::create('cart/get'); ?>">CSVをダウンロード</a>
</body>
</html>
