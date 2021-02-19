<!DOCTYPE html>
<html>
<head>
    <title>Share Email</title>
</head>

<style>
	header {
		background-color: green;
		color: #FFF;
		display: flex;
		height: 100px;
		justify-content: center;
		align-content: center;
	}

	h1 {
		padding: 10px;
	}

	h2 {
		text-transform: uppercase;
	}

	h3 {
		font-weight: 200;
	}

	.blue {
		color: blue;
	}

	.container {
		margin: auto;
		width: 80%;
	}

</style>

<body>

	<header class="header">

		<h1>GemmaList</h1>

	</header>

	<div class="container">

		<h2>A list has been shared with you.</h2>

        <p><b>The {{ $shareData->title }} list</b> was shared by <b>{{ $shareData->email }}</b>. Use the link below to access it.

        <h3><a href="https://www.gemmalist.com/glists/share/{{ $shareData->confirm }}" target="_blank">https://www.gemmalist.com/glists/share/{{ $shareData->confirm }}</a></h3>

	</div>

</body>

</html>