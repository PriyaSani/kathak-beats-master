<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Testing</title>
</head>
<body>
	<form action="{{ route('uploadProfilepic') }}" method="post" enctype="multipart/form-data">
		@csrf
		<input type="file" name="profile" required />
		<button type="submit">Submit</button>

	</form>
</body>
</html>