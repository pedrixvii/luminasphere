<!-- Layout wrapper -->

<?php
$current_page = $this->uri->segment(1);
?>
<div class="layout-wrapper layout-content-navbar">
	<div class="layout-container">
		<!-- Menu -->
		<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
			<div class="app-brand demo">
				<a href="<?= base_url('dashboard/staff') ?>" class="app-brand-link">
					<img src="<?= base_url('assets/logo/logowebsiteperpusukk.png') ?>" alt="" style="width: 200px;">
				</a>
				<a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
					<i class="bx bx-chevron-left bx-sm align-middle"></i>
				</a>
			</div>

			<div class="menu-inner-shadow"></div>

			<ul class="menu-inner py-1">
				<!-- Dashboard -->
				<li class="menu-item <?= ($current_page == 'dashboard') ? 'active' : '' ?>">
					<a href="<?= base_url('dashboard/admin') ?>" class="menu-link">
						<i class="menu-icon tf-icons bx bx-home-circle"></i>
						<div data-i18n="Analytics">Dashboard</div>
					</a>
				</li>

				<li class="menu-header small text-uppercase">
					<span class="menu-header-text">Koleksi Buku</span>
				</li>

				<!-- Data Book -->
				<li class="menu-item <?= ($current_page == 'buku' || $current_page == 'genre') ? 'active open' : '' ?>">
					<a href="javascript:void(0);" class="menu-link menu-toggle">
						<i class="menu-icon tf-icons bx bx-book"></i>
						<div data-i18n="Account Settings">Data Book</div>
					</a>
					<ul class="menu-sub">
						<li class="menu-item <?= ($current_page === 'buku') ? 'active current-page' : '' ?>">
							<a href="<?= base_url('buku') ?>" class="menu-link">
								<div data-i18n="Account">Data E-Book</div>
							</a>
						</li>
						<li class="menu-item <?= ($current_page === 'genre') ? 'active current-page' : '' ?>">
							<a href="<?= base_url('genre') ?>" class="menu-link">
								<div data-i18n="Account">Data Genre</div>
							</a>
						</li>
					</ul>
				</li>

				<!-- Data Sliders -->
				<li class="menu-item <?= ($current_page == 'sliders') ? 'active current-page' : '' ?>">
					<a href="<?= base_url('sliders') ?>" class="menu-link">
						<i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
						<div data-i18n="Account">Data Sliders</div>
					</a>
				</li>
				<!-- Misc -->
				<li class="menu-header small text-uppercase"><span class="menu-header-text">Misc</span></li>
				<li class="menu-item">
					<a
						href=""
						class="menu-link" onclick="return confirm('Apakah Anda yakin ingin logout?')">
						<i class='bx bx-log-out-circle'></i>
						<div data-i18n="Logout">Logout</div>
					</a>
				</li>
			</ul>
		</aside>
		<!-- / Menu -->

		<!-- Layout container -->
		<div class="layout-page">
			<!-- Navbar -->
			<nav
				class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
				id="layout-navbar">
				<div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
					<a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
						<i class="bx bx-menu bx-sm"></i>
					</a>
				</div>

				<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
					<!-- Search -->
					<div class="navbar-nav align-items-center">
						<div class="nav-item d-flex align-items-center">
							<i class="bx bx-search fs-4 lh-0"></i>
							<input
								type="text"
								class="form-control border-0 shadow-none"
								placeholder="Search..."
								aria-label="Search..." />
						</div>
					</div>
					<!-- /Search -->

					<ul class="navbar-nav flex-row align-items-center ms-auto">
						<!-- Place this tag where you want the button to render. -->
						<li class="nav-item lh-1 me-3">
							<a
								class="github-button"
								href="https://github.com/themeselection/sneat-html-admin-template-free"
								data-icon="octicon-star"
								data-size="large"
								data-show-count="true"
								aria-label="Star themeselection/sneat-html-admin-template-free on GitHub">Star</a>
						</li>

						<!-- User -->
						<li class="nav-item navbar-dropdown dropdown-user dropdown">
							<a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
								<div class="avatar avatar-online">
									<img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
								</div>
							</a>
							<ul class="dropdown-menu dropdown-menu-end">
								<li>
									<a class="dropdown-item" href="#">
										<div class="d-flex">
											<div class="flex-shrink-0 me-3">
												<div class="avatar avatar-online">
													<img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
												</div>
											</div>
											<div class="flex-grow-1">
												<span class="fw-semibold d-block">John Doe</span>
												<small class="text-muted">Admin</small>
											</div>
										</div>
									</a>
								</li>
								<li>
									<div class="dropdown-divider"></div>
								</li>
								<li>
									<a class="dropdown-item" href="#">
										<i class="bx bx-user me-2"></i>
										<span class="align-middle">My Profile</span>
									</a>
								</li>
								<li>
									<a class="dropdown-item" href="#">
										<i class="bx bx-cog me-2"></i>
										<span class="align-middle">Settings</span>
									</a>
								</li>
								<li>
									<a class="dropdown-item" href="#">
										<span class="d-flex align-items-center align-middle">
											<i class="flex-shrink-0 bx bx-credit-card me-2"></i>
											<span class="flex-grow-1 align-middle">Billing</span>
											<span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
										</span>
									</a>
								</li>
								<li>
									<div class="dropdown-divider"></div>
								</li>
								<li>
									<a class="dropdown-item" href="auth-login-basic.html">
										<i class="bx bx-power-off me-2"></i>
										<span class="align-middle">Log Out</span>
									</a>
								</li>
							</ul>
						</li>
						<!--/ User -->
					</ul>
				</div>
			</nav>

			<!-- / Navbar -->
