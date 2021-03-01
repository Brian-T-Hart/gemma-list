<!DOCTYPE html>
<html>
<head>
    <title>Share Email</title>
</head>

<style>
	header {
		align-content: center;
		background-color: green;
		color: #FFF;
		display: flex;
		height: 100px;
		justify-content: center;
		margin-bottom: 40px;
	}

	h1 {
		padding: 10px;
	}

	h2 {
		font-size: 20px;
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

        <p>You have been invited by <b>{{ $shareData->email }}</b> to share a list on gemmalist.com. Use the confirmation link below to accept the invitation and begin using the shared list.</p>

        <p><a href="https://www.gemmalist.com/shared/confirm/{{ $shareData->confirm }}" target="_blank">www.gemmalist.com/shared/confirm/{{ $shareData->confirm }}</a></p>

	</div>

</body>

</html>