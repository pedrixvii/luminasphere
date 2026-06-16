<!-- Footer Section Begin -->
<footer class="footer">
	<div class="page-up">
		<a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<div class="footer__logo">
					<a href="./index.html"><img src="img/logo.png" alt=""></a>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="footer__nav">
					<ul>
						<li class="active"><a href="./index.html">Homepage</a></li>
						<li><a href="./categories.html">Categories</a></li>
						<li><a href="./blog.html">Our Blog</a></li>
						<li><a href="#">Contacts</a></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3">
				<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					Copyright &copy;<script>
						document.write(new Date().getFullYear());
					</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>

			</div>
		</div>
	</div>
</footer>
<style>
	.rating-container {
		font-family: Arial, sans-serif;
	}

	.rating {
		justify-content: left;
		display: flex;
		flex-direction: row-reverse;
		font-size: 2rem;
		color: #ddd;
		cursor: pointer;
	}

	.rating input {
		display: none;
	}

	.rating label {
		display: inline-block;
		transition: color 0.3s;
	}

	.rating input:checked~label,
	.rating label:hover,
	.rating label:hover~label {
		color: #ffcc00;
	}

	.rating label:active {
		transform: scale(1.1);
	}

	.product__item__pic {
    position: relative;
    overflow: hidden;
}

.badge-stock {
    position: absolute;
    top: 10px;
    left: 10px;
    background-color: #007bff; /* Warna biru */
    color: white;
    padding: 5px 10px;
    font-size: 12px;
    border-radius: 5px;
    font-weight: bold;
}

.badge-rating {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #ffc107; /* Warna kuning */
    color: black;
    padding: 5px 10px;
    font-size: 12px;
    border-radius: 5px;
    font-weight: bold;
}

.badge-rating.no-rating {
    background-color: #6c757d; /* Warna abu-abu */
    color: white;
}
#toast-container {
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        position: fixed !important;
        z-index: 99999;
    }

    .toast {
        opacity: 0.95 !important;
        border-radius: 10px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        padding: 15px;
        font-size: 16px;
    }
    
    .toast-success {
        background-color: #28a745 !important;
        color: #fff !important;
    }

    .toast-info {
        background-color: #17a2b8 !important;
        color: #fff !important;
    }

    .toast-error {
        background-color: #dc3545 !important;
        color: #fff !important;
    }

</style>
<!-- Footer Section End -->
<!-- Js Plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>

<script src="<?= base_url('assets/template-user') ?>/js/jquery-3.3.1.min.js"></script>
<script src="<?= base_url('assets/template-user') ?>/js/bootstrap.min.js"></script>
<script src="<?= base_url('assets/template-user') ?>/js/player.js"></script>
<script src="<?= base_url('assets/template-user') ?>/js/jquery.nice-select.min.js"></script>
<script src="<?= base_url('assets/template-user') ?>/js/mixitup.min.js"></script>
<script src="<?= base_url('assets/template-user') ?>/js/jquery.slicknav.js"></script>
<script src="<?= base_url('assets/template-user') ?>/js/owl.carousel.min.js"></script>
<script src="<?= base_url('assets/template-user') ?>/js/main.js"></script>
</body>

</html>
