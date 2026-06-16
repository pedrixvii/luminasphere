<!DOCTYPE html>
<html lang="zxx">

<head>
	<meta charset="UTF-8">
	<meta name="description" content="Anime Template">
	<meta name="keywords" content="Anime, unica, creative, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Lumina Sphere</title>

	<!-- bootstrap -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
		rel="stylesheet">
	<!-- Toastr CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Toastr JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	<link rel="icon" type="image/x-icon" href="<?= base_url('assets/logo') ?>/logowebsiteperpusukk.png" alt="logo perpustakaan" sizes="32x32">

	<!-- Css Styles -->
	<link rel="stylesheet" href="<?= base_url('assets/template-user') ?>/css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="<?= base_url('assets/template-user') ?>/css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="<?= base_url('assets/template-user') ?>/css/elegant-icons.css" type="text/css">
	<link rel="stylesheet" href="<?= base_url('assets/template-user') ?>/css/plyr.css" type="text/css">
	<link rel="stylesheet" href="<?= base_url('assets/template-user') ?>/css/nice-select.css" type="text/css">
	<link rel="stylesheet" href="<?= base_url('assets/template-user') ?>/css/owl.carousel.min.css" type="text/css">
	<link rel="stylesheet" href="<?= base_url('assets/template-user') ?>/css/slicknav.min.css" type="text/css">
	<link rel="stylesheet" href="<?= base_url('assets/template-user') ?>/css/style.css" type="text/css">
</head>

<body>

	<!-- Header Section Begin -->
	<nav class="navbar navbar-expand-lg navbar-custom">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">
				<img src="<?= base_url('assets/logo/logowebsiteperpusukk.png') ?>" alt="Bootstrap" width="200" height="auto">
			</a>
			<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
				<ul class="navbar-nav mx-auto mb-2 mb-lg-0">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="<?= base_url('dashboard/user') ?>">Home</a>
					</li>
					<li class="nav-item">
					<a class="nav-link" href="<?= base_url('user/buku_dipinjam'); ?>">📖 Buku Dipinjam</a>
					</li>
				</ul>
				<div class="btn-group">

				</div>
				<form method="GET" action="<?= base_url('user/search') ?>" class="d-flex" role="search">
					<!-- Input untuk pencarian -->
					<input class="form-control me-2" type="search" name="keyword" placeholder="Search" aria-label="Search" required>

					<!-- Input hidden untuk menyimpan filter -->
					<input type="hidden" name="filter" id="filterInput" value="title">

					<!-- Dropdown filter -->
					<div class="btn-group">
						<button class="btn btn-outline-warning" type="submit">Search</button>
						<!-- <button type="button" class="btn btn-outline-warning dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
							<span class="visually-hidden">Toggle Dropdown</span>
						</button> -->
						<ul class="dropdown-menu">
							<li><a class="dropdown-item filter-option" href="#" data-value="title">Judul</a></li>
							<li><a class="dropdown-item filter-option" href="#" data-value="author">Author</a></li>
							<li><a class="dropdown-item filter-option" href="#" data-value="genre">Genre</a></li>
							<li>
								<hr class="dropdown-divider" />
							</li>
							<li><a class="dropdown-item filter-option" href="#" data-value="isbn">ISBN</a></li>
						</ul>
					</div>
				</form>
			</div>
			<ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu">
				<li class="nav-item dropdown">
					<a class="nav-link" href="<?= base_url('Usersettings') ?>" role="button" aria-expanded="false">
						<div class="profile-pic">
							<img src="<?= base_url('upload/foto_user/' . $foto) ?>"
								alt="User Profile"
								class="rounded-circle" width="45" height="45">
						</div>
					</a>
				</li>
			</ul>
		</div>
	</nav>
	<style>
		:root {
			--bs-navbar-bg: #243F46;
			--bs-navbar-color: white;
			--bs-navbar-hover-color: #fed36a;
		}

		.navbar-custom {
			background-color: var(--bs-navbar-bg) !important;
			color: var(--bs-navbar-color) !important;
		}

		.navbar-custom .nav-link {
			color: white !important;
		}

		.navbar-custom .nav-link:hover {
			color: #fed36a !important;
		}
	</style>

	<!-- Header End -->
