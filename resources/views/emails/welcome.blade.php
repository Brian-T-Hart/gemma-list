<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
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
		font-family: cursive;
		text-transform: uppercase;
	}

	h3 {
		font-family: cursive;
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
		
		<h2>{{$user['name']}},</h2>

		<h3>Welcome to GemmaList</h3>

		<h3>Your registered email is <span class="blue">{{$user['email']}}<span></h3>

		<h3>If you have any questions you can contact us at <span class="blue">support@gemmalist.com</span></h3>

	</div>

</body>

</html>