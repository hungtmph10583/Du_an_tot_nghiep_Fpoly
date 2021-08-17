<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->
<head>
	<meta charset="utf-8" />
	<title>@yield('title')</title>
	<meta name="description" content="Latest updates and statistic charts">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

	<!--begin::Web font -->
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	<script>
		WebFont.load({
		google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
		active: function() {
			sessionStorage.fonts = true;
		}
		});
	</script>
	<!--end::Web font -->
	<!-- CSS -->
	@include('layouts.admin.style')
	@yield('pageStyle')
</head>
<!-- end::Head -->

<!-- begin::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

	<!-- begin:: Page -->
	<div class="m-grid m-grid--hor m-grid--root m-page">

		<!-- BEGIN: Header -->
		@include('layouts.admin.header')
		<!-- END: Header -->

		<!-- begin::Body -->
		@include('layouts.admin.aside')
		<!-- end:: Body -->

		<!-- begin::Footer -->
		<footer class="m-grid__item		m-footer ">
			<div class="m-container m-container--fluid m-container--full-height m-page__container">
				<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
					<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
						<span class="m-footer__copyright">
							2017 &copy; Metronic theme by <a href="https://keenthemes.com" class="m-link">Keenthemes</a>
						</span>
					</div>
				</div>
			</div>
		</footer>
		<!-- end::Footer -->

	</div>
	<!-- end:: Page -->

	<!-- begin::Quick Sidebar -->
	<div id="m_quick_sidebar" class="m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light">
		<div class="m-quick-sidebar__content m--hide">
			<span id="m_quick_sidebar_close" class="m-quick-sidebar__close"><i class="la la-close"></i></span>
			<ul id="m_quick_sidebar_tabs" class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand" role="tablist">
				<li class="nav-item m-tabs__item">
					<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_quick_sidebar_tabs_messenger" role="tab">Messages</a>
				</li>
				<li class="nav-item m-tabs__item">
					<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_quick_sidebar_tabs_settings" role="tab">Settings</a>
				</li>
				<li class="nav-item m-tabs__item">
					<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_quick_sidebar_tabs_logs" role="tab">Logs</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="m_quick_sidebar_tabs_messenger" role="tabpanel">
					<div class="m-messenger m-messenger--message-arrow m-messenger--skin-light">
						<div class="m-messenger__messages m-scrollable">
							<div class="m-messenger__wrapper">
								<div class="m-messenger__message m-messenger__message--in">
									<div class="m-messenger__message-pic">
										<img src="{{ asset('admin-theme/assets/app/media/img//users/user3.jpg')}}" alt="" />
									</div>
									<div class="m-messenger__message-body">
										<div class="m-messenger__message-arrow"></div>
										<div class="m-messenger__message-content">
											<div class="m-messenger__message-username">
												Megan wrote
											</div>
											<div class="m-messenger__message-text">
												Hi Bob. What time will be the meeting ?
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="m-messenger__wrapper">
								<div class="m-messenger__message m-messenger__message--out">
									<div class="m-messenger__message-body">
										<div class="m-messenger__message-arrow"></div>
										<div class="m-messenger__message-content">
											<div class="m-messenger__message-text">
												Hi Megan. It's at 2.30PM
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="m-messenger__wrapper">
								<div class="m-messenger__message m-messenger__message--in">
									<div class="m-messenger__message-pic">
										<img src="{{ asset('admin-theme/assets/app/media/img//users/user3.jpg')}}" alt="" />
									</div>
									<div class="m-messenger__message-body">
										<div class="m-messenger__message-arrow"></div>
										<div class="m-messenger__message-content">
											<div class="m-messenger__message-username">
												Megan wrote
											</div>
											<div class="m-messenger__message-text">
												Will the development team be joining ?
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="m-messenger__wrapper">
								<div class="m-messenger__message m-messenger__message--out">
									<div class="m-messenger__message-body">
										<div class="m-messenger__message-arrow"></div>
										<div class="m-messenger__message-content">
											<div class="m-messenger__message-text">
												Yes sure. I invited them as well
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="m-messenger__datetime">2:30PM</div>
							<div class="m-messenger__wrapper">
								<div class="m-messenger__message m-messenger__message--in">
									<div class="m-messenger__message-pic">
										<img src="{{ asset('admin-theme/assets/app/media/img//users/user3.jpg')}}" alt="" />
									</div>
									<div class="m-messenger__message-body">
										<div class="m-messenger__message-arrow"></div>
										<div class="m-messenger__message-content">
											<div class="m-messenger__message-username">
												Megan wrote
											</div>
											<div class="m-messenger__message-text">
												Noted. For the Coca-Cola Mobile App project as well ?
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="m-messenger__wrapper">
								<div class="m-messenger__message m-messenger__message--out">
									<div class="m-messenger__message-body">
										<div class="m-messenger__message-arrow"></div>
										<div class="m-messenger__message-content">
											<div class="m-messenger__message-text">
												Yes, sure.
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="m-messenger__wrapper">
								<div class="m-messenger__message m-messenger__message--out">
									<div class="m-messenger__message-body">
										<div class="m-messenger__message-arrow"></div>
										<div class="m-messenger__message-content">
											<div class="m-messenger__message-text">
												Please also prepare the quotation for the Loop CRM project as well.
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="m-messenger__datetime">3:15PM</div>
							<div class="m-messenger__wrapper">
								<div class="m-messenger__message m-messenger__message--in">
									<div class="m-messenger__message-no-pic m--bg-fill-danger">
										<span>M</span>
									</div>
									<div class="m-messenger__message-body">
										<div class="m-messenger__message-arrow"></div>
										<div class="m-messenger__message-content">
											<div class="m-messenger__message-username">
												Megan wrote
											</div>
											<div class="m-messenger__message-text">
												Noted. I will prepare it.
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="m-messenger__wrapper">
								<div class="m-messenger__message m-messenger__message--out">
									<div class="m-messenger__message-body">
										<div class="m-messenger__message-arrow"></div>
										<div class="m-messenger__message-content">
											<div class="m-messenger__message-text">
												Thanks Megan. I will see you later.
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="m-messenger__wrapper">
								<div class="m-messenger__message m-messenger__message--in">
									<div class="m-messenger__message-pic">
										<img src="{{ asset('admin-theme/assets/app/media/img//users/user3.jpg')}}" alt="" />
									</div>
									<div class="m-messenger__message-body">
										<div class="m-messenger__message-arrow"></div>
										<div class="m-messenger__message-content">
											<div class="m-messenger__message-username">
												Megan wrote
											</div>
											<div class="m-messenger__message-text">
												Sure. See you in the meeting soon.
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="m-messenger__seperator"></div>
						<div class="m-messenger__form">
							<div class="m-messenger__form-controls">
								<input type="text" name="" placeholder="Type here..." class="m-messenger__form-input">
							</div>
							<div class="m-messenger__form-tools">
								<a href="" class="m-messenger__form-attachment">
									<i class="la la-paperclip"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end::Quick Sidebar -->

	<!-- begin::Scroll Top -->
	<div id="m_scroll_top" class="m-scroll-top">
		<i class="la la-arrow-up"></i>
	</div>

	<!-- end::Scroll Top -->

	<!-- begin::Quick Nav -->

	<!-- begin::Quick Nav -->
	@include('layouts.admin.script')
	@yield('pagejs')
</body>

<!-- end::Body -->
</html>